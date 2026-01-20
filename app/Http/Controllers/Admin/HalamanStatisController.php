<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HalamanStatis;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\Request;

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
            'slug' => 'required|string|unique:halaman_statis,slug',
            'judul' => 'required|string|max:255',
            'is_active' => 'boolean',
            'sections' => 'required|array',
            'sections.*' => 'required|string',
            'items' => 'required|array',
            'items.*.*' => 'required|string',
            'file_urls' => 'array',
            'file_urls.*.*' => 'nullable|url',
            'files' => 'array',
            'files.*.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:5120',
        ]);

        $konten = $this->buildKonten($request);

        HalamanStatis::create([
            'slug' => $validated['slug'],
            'judul' => $validated['judul'],
            'konten' => $konten,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.halaman-statis.index')
            ->with('success', 'Halaman statis berhasil ditambahkan');
    }

    public function edit(HalamanStatis $halamanStatis)
    {
        return view('admin.halaman-statis.edit', compact('halamanStatis'));
    }

    public function update(Request $request, HalamanStatis $halamanStatis)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:halaman_statis,slug,' . $halamanStatis->id,
            'judul' => 'required|string|max:255',
            'is_active' => 'boolean',
            'sections' => 'required|array',
            'sections.*' => 'required|string',
            'items' => 'required|array',
            'items.*.*' => 'required|string',
            'file_urls' => 'array',
            'file_urls.*.*' => 'nullable|url',
            'files' => 'array',
            'files.*.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:5120',
        ]);

        $oldFilePaths = $this->extractFilePaths($halamanStatis->konten ?? []);
        $konten = $this->buildKonten($request, $halamanStatis->konten ?? []);
        $newFilePaths = $this->extractFilePaths($konten);
        $pathsToDelete = array_diff($oldFilePaths, $newFilePaths);

        $halamanStatis->update([
            'slug' => $validated['slug'],
            'judul' => $validated['judul'],
            'konten' => $konten,
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($pathsToDelete as $path) {
            $this->deleteFile($path);
        }

        return redirect()->route('admin.halaman-statis.index')
            ->with('success', 'Halaman statis berhasil diupdate');
    }

    public function destroy(HalamanStatis $halamanStatis)
    {
        $pathsToDelete = $this->extractFilePaths($halamanStatis->konten ?? []);
        $halamanStatis->delete();

        foreach ($pathsToDelete as $path) {
            $this->deleteFile($path);
        }

        return redirect()->route('admin.halaman-statis.index')
            ->with('success', 'Halaman statis berhasil dihapus');
    }

    /**
     * Susun konten halaman beserta file upload per item.
     */
    private function buildKonten(Request $request, array $existingKonten = []): array
    {
        $konten = [];
        $existingFiles = $request->input('existing_files', []);

        if ($request->has('sections')) {
            foreach ($request->sections as $index => $section) {
                $items = [];

                if (isset($request->items[$index])) {
                    foreach ($request->items[$index] as $itemIndex => $itemText) {
                        $filePath = $existingFiles[$index][$itemIndex] ?? null;

                        if ($request->hasFile("files.$index.$itemIndex")) {
                            $filePath = $this->handleFileUpload(
                                $request->file("files.$index.$itemIndex"),
                                'halaman-statis',
                                $filePath
                            );
                        }

                        $items[] = [
                            'text' => $itemText,
                            'file_url' => $request->file_urls[$index][$itemIndex] ?? null,
                            'file_path' => $filePath,
                        ];
                    }
                }

                $konten[] = [
                    'section' => $section,
                    'items' => $items,
                ];
            }
        }

        return $konten;
    }

    /**
     * Ambil daftar path file dari struktur konten untuk kebutuhan pembersihan.
     */
    private function extractFilePaths(array $konten): array
    {
        $paths = [];

        foreach ($konten as $section) {
            if (!isset($section['items'])) {
                continue;
            }

            foreach ($section['items'] as $item) {
                if (!empty($item['file_path'])) {
                    $paths[] = $item['file_path'];
                }
            }
        }

        return $paths;
    }
}