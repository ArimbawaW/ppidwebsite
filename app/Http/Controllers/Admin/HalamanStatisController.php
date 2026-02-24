<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HalamanStatis;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HalamanStatisController extends Controller
{
    use HandlesFileUploads;

    public function index()
    {
        $halaman = HalamanStatis::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.halaman-statis.index', compact('halaman'));
    }

    public function create()
    {
        return view('admin.halaman-statis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug'       => 'required|string|unique:halaman_statis,slug',
            'judul'      => 'required|string|max:255',
            'sections'   => 'required|array',
            'sections.*' => 'required|string',
            'items'      => 'required|array',
            'items.*.*'  => 'required|string',
            'file_urls'  => 'nullable|array',
            'file_urls.*.*' => 'nullable|url',
            'files'      => 'nullable|array',
            'files.*.*'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:5120',
            'subsection_files.*.*.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:5120',
        ]);

        $konten = $this->buildKonten($request);

        HalamanStatis::create([
            'slug'      => $validated['slug'],
            'judul'     => $validated['judul'],
            'konten'    => $konten,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.halaman-statis.index')
            ->with('success', 'Halaman statis berhasil ditambahkan');
    }

    public function edit(HalamanStatis $halamanStatis)
    {
        return view('admin.halaman-statis.edit', compact('halamanStatis'));
    }

    public function update(Request $request, HalamanStatis $halamanStatis)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'sections'   => 'required|array',
            'sections.*' => 'nullable|string',
            'items'      => 'required|array',
            'items.*.*'  => 'nullable|string',
            'file_urls'  => 'nullable|array',
            'file_urls.*.*' => 'nullable|url',
            'files'      => 'nullable|array',
            'files.*.*'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:5120',
            'subsection_files.*.*.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:5120',
        ]);

        $oldKonten    = is_array($halamanStatis->konten) ? $halamanStatis->konten : [];
        $oldFilePaths = $this->extractFilePaths($oldKonten);

        $konten = $this->buildKontenUpdate($request, $oldKonten);

        $newFilePaths = $this->extractFilePaths($konten);

        $halamanStatis->update([
            'judul'     => $request->judul,
            'konten'    => $konten,
            'is_active' => $request->boolean('is_active'),
        ]);

        $pathsToDelete = array_diff($oldFilePaths, $newFilePaths);
        foreach ($pathsToDelete as $path) {
            if (!empty($path)) {
                $this->deleteFile($path);
            }
        }

        return redirect()
            ->route('admin.halaman-statis.index')
            ->with('success', 'Halaman statis berhasil diupdate');
    }

    public function destroy(HalamanStatis $halamanStatis)
    {
        $konten        = is_array($halamanStatis->konten) ? $halamanStatis->konten : [];
        $pathsToDelete = $this->extractFilePaths($konten);

        $halamanStatis->delete();

        foreach ($pathsToDelete as $path) {
            $this->deleteFile($path);
        }

        return redirect()
            ->route('admin.halaman-statis.index')
            ->with('success', 'Halaman statis berhasil dihapus');
    }

    /**
     * Build konten untuk CREATE.
     * Struktur item:
     *   - Jika has_subsection = 1 → simpan subsections[], file_url & file_path item dikosongkan
     *   - Jika has_subsection = 0 → simpan file_url & file_path item biasa, subsections = []
     */
    private function buildKonten(Request $request): array
    {
        $konten = [];

        foreach ($request->sections as $sIdx => $sectionName) {
            $items = [];

            if (isset($request->items[$sIdx])) {
                foreach ($request->items[$sIdx] as $iIdx => $itemText) {
                    $hasSubsection = ($request->input("has_subsection.$sIdx.$iIdx") == '1')
                        || ($request->input("has_subsection.$sIdx") == '1'); // fallback array format

                    // Cek flag secara array (name="has_subsection[sIdx][]")
                    $hasSubsectionArr = $request->input("has_subsection.$sIdx");
                    if (is_array($hasSubsectionArr)) {
                        $flagVal = $hasSubsectionArr[$iIdx] ?? '0';
                        $hasSubsection = ($flagVal == '1');
                    }

                    if ($hasSubsection) {
                        // Build subsections
                        $subsections = $this->buildSubsections($request, $sIdx, $iIdx);

                        $items[] = [
                            'text'        => $itemText,
                            'file_url'    => null,
                            'file_path'   => null,
                            'subsections' => $subsections,
                        ];
                    } else {
                        $filePath = null;
                        if ($request->hasFile("files.$sIdx.$iIdx")) {
                            $filePath = $this->handleFileUpload(
                                $request->file("files.$sIdx.$iIdx"),
                                'halaman-statis'
                            );
                        }

                        $items[] = [
                            'text'        => $itemText,
                            'file_url'    => $request->input("file_urls.$sIdx.$iIdx"),
                            'file_path'   => $filePath,
                            'subsections' => [],
                        ];
                    }
                }
            }

            $konten[] = [
                'section' => $sectionName,
                'items'   => $items,
            ];
        }

        return $konten;
    }

    /**
     * Build konten untuk UPDATE.
     */
    private function buildKontenUpdate(Request $request, array $existingKonten = []): array
    {
        $konten        = [];
        $existingFiles = $request->input('existing_files', []);
        $existingSubFiles = $request->input('existing_subsection_files', []);

        foreach ($request->sections as $sIdx => $sectionName) {
            $items = [];

            if (isset($request->items[$sIdx])) {
                foreach ($request->items[$sIdx] as $iIdx => $itemText) {
                    // Determine has_subsection flag
                    $hasSubsectionArr = $request->input("has_subsection.$sIdx");
                    $hasSubsection = false;
                    if (is_array($hasSubsectionArr)) {
                        $flagVal = $hasSubsectionArr[$iIdx] ?? '0';
                        $hasSubsection = ($flagVal == '1');
                    }

                    if ($hasSubsection) {
                        $subsections = $this->buildSubsectionsUpdate($request, $sIdx, $iIdx, $existingSubFiles);

                        // Clean up old item file if it existed
                        $oldPath = $existingFiles[$sIdx][$iIdx] ?? null;
                        if ($oldPath) {
                            $this->deleteFile($oldPath);
                        }

                        $items[] = [
                            'text'        => $itemText,
                            'file_url'    => null,
                            'file_path'   => null,
                            'subsections' => $subsections,
                        ];
                    } else {
                        $filePath = $existingFiles[$sIdx][$iIdx] ?? null;

                        if ($request->hasFile("files.$sIdx.$iIdx")) {
                            $filePath = $this->handleFileUpload(
                                $request->file("files.$sIdx.$iIdx"),
                                'halaman-statis',
                                $filePath
                            );
                        }

                        $fileUrl = $request->input("file_urls.$sIdx.$iIdx");

                        $hasContent = (trim((string)$itemText) !== '')
                            || (trim((string)$fileUrl) !== '')
                            || !empty($filePath);

                        if (!$hasContent) continue;

                        $items[] = [
                            'text'        => $itemText,
                            'file_url'    => $fileUrl,
                            'file_path'   => $filePath,
                            'subsections' => [],
                        ];
                    }
                }
            }

            $sectionNameTrimmed = is_string($sectionName) ? trim($sectionName) : '';
            if ($sectionNameTrimmed === '' && count($items) === 0) continue;

            $konten[] = [
                'section' => $sectionName,
                'items'   => $items,
            ];
        }

        return $konten;
    }

    /**
     * Build subsections array for CREATE
     */
    private function buildSubsections(Request $request, int $sIdx, int $iIdx): array
    {
        $subsections = [];
        $titles = $request->input("subsection_titles.$sIdx.$iIdx", []);

        foreach ($titles as $subIdx => $title) {
            if (trim((string)$title) === '') continue;

            $filePath = null;
            if ($request->hasFile("subsection_files.$sIdx.$iIdx.$subIdx")) {
                $filePath = $this->handleFileUpload(
                    $request->file("subsection_files.$sIdx.$iIdx.$subIdx"),
                    'halaman-statis'
                );
            }

            $subsections[] = [
                'text'      => $title,
                'file_url'  => $request->input("subsection_urls.$sIdx.$iIdx.$subIdx"),
                'file_path' => $filePath,
            ];
        }

        return $subsections;
    }

    /**
     * Build subsections array for UPDATE (with existing file handling)
     */
    private function buildSubsectionsUpdate(Request $request, int $sIdx, int $iIdx, array $existingSubFiles): array
    {
        $subsections = [];
        $titles = $request->input("subsection_titles.$sIdx.$iIdx", []);

        foreach ($titles as $subIdx => $title) {
            if (trim((string)$title) === '') continue;

            $filePath = $existingSubFiles[$sIdx][$iIdx][$subIdx] ?? null;

            if ($request->hasFile("subsection_files.$sIdx.$iIdx.$subIdx")) {
                $filePath = $this->handleFileUpload(
                    $request->file("subsection_files.$sIdx.$iIdx.$subIdx"),
                    'halaman-statis',
                    $filePath
                );
            }

            $subsections[] = [
                'text'      => $title,
                'file_url'  => $request->input("subsection_urls.$sIdx.$iIdx.$subIdx"),
                'file_path' => $filePath,
            ];
        }

        return $subsections;
    }

    /**
     * Ambil semua file_path dari struktur konten (termasuk subsections).
     */
    private function extractFilePaths(array $konten): array
    {
        $paths = [];
        foreach ($konten as $section) {
            if (!isset($section['items']) || !is_array($section['items'])) continue;

            foreach ($section['items'] as $item) {
                if (!empty($item['file_path'])) {
                    $paths[] = $item['file_path'];
                }

                // Include subsection file paths
                if (!empty($item['subsections']) && is_array($item['subsections'])) {
                    foreach ($item['subsections'] as $sub) {
                        if (!empty($sub['file_path'])) {
                            $paths[] = $sub['file_path'];
                        }
                    }
                }
            }
        }
        return $paths;
    }
}