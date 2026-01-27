<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HalamanStatis;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Pastikan ini diimport jika delete ada di trait

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
            'sections' => 'required|array',
            'sections.*' => 'required|string',
            'items' => 'required|array',
            'items.*.*' => 'required|string',
            'file_urls' => 'nullable|array',
            'file_urls.*.*' => 'nullable|url',
            'files' => 'nullable|array',
            'files.*.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:5120',
        ]);

        $konten = $this->buildKonten($request);

        HalamanStatis::create([
            'slug' => $validated['slug'],
            'judul' => $validated['judul'],
            'konten' => $konten,
            'is_active' => $request->boolean('is_active'), // Lebih aman menggunakan boolean()
        ]);

        return redirect()->route('admin.halaman-statis.index')
            ->with('success', 'Halaman statis berhasil ditambahkan');
    }

    public function edit(HalamanStatis $halamanStatis)
    {
        // Pastikan konten adalah array jika di cast di Model
        return view('admin.halaman-statis.edit', compact('halamanStatis'));
    }

    public function update(Request $request, HalamanStatis $halamanStatis)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'sections' => 'required|array',
            'sections.*' => 'required|string',
            'items' => 'required|array',
            'items.*.*' => 'required|string',
            'file_urls' => 'nullable|array',
            'files' => 'nullable|array',
            'files.*.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:5120',
        ]);

        $oldKonten = is_array($halamanStatis->konten) ? $halamanStatis->konten : [];
        $oldFilePaths = $this->extractFilePaths($oldKonten);
        
        $konten = $this->buildKontenUpdate($request, $oldKonten);
        
        $newFilePaths = $this->extractFilePaths($konten);
        $pathsToDelete = array_diff($oldFilePaths, $newFilePaths);

        $halamanStatis->update([
            'judul' => $request->judul,
            'konten' => $konten,
            'is_active' => $request->boolean('is_active'),
        ]);

        // Hapus file fisik yang sudah tidak terpakai
        foreach ($pathsToDelete as $path) {
            $this->deleteFile($path); 
        }

        return redirect()->route('admin.halaman-statis.index')
            ->with('success', 'Halaman statis berhasil diupdate');
    }

    public function destroy(HalamanStatis $halamanStatis)
    {
        $konten = is_array($halamanStatis->konten) ? $halamanStatis->konten : [];
        $pathsToDelete = $this->extractFilePaths($konten);
        
        $halamanStatis->delete();

        foreach ($pathsToDelete as $path) {
            $this->deleteFile($path);
        }

        return redirect()->route('admin.halaman-statis.index')
            ->with('success', 'Halaman statis berhasil dihapus');
    }

    private function buildKonten(Request $request): array
    {
        $konten = [];
        if ($request->has('sections')) {
            foreach ($request->sections as $index => $section) {
                $items = [];
                if (isset($request->items[$index])) {
                    foreach ($request->items[$index] as $itemIndex => $itemText) {
                        $filePath = null;
                        if ($request->hasFile("files.$index.$itemIndex")) {
                            $filePath = $this->handleFileUpload(
                                $request->file("files.$index.$itemIndex"),
                                'halaman-statis'
                            );
                        }

                        $items[] = [
                            'text' => $itemText,
                            'file_url' => $request->file_urls[$index][$itemIndex] ?? null,
                            'file_path' => $filePath,
                        ];
                    }
                }
                $konten[] = ['section' => $section, 'items' => $items];
            }
        }
        return $konten;
    }

    private function buildKontenUpdate(Request $request, array $existingKonten = []): array
    {
        $konten = [];
        // existing_files dikirim dari hidden input di form edit
        $existingFiles = $request->input('existing_files', []);

        if ($request->has('sections')) {
            foreach ($request->sections as $sectionIndex => $section) {
                $items = [];
                if (isset($request->items[$sectionIndex])) {
                    foreach ($request->items[$sectionIndex] as $itemIndex => $itemText) {
                        $filePath = $existingFiles[$sectionIndex][$itemIndex] ?? null;

                        if ($request->hasFile("files.$sectionIndex.$itemIndex")) {
                            // Upload baru dan hapus file lama jika ada
                            $filePath = $this->handleFileUpload(
                                $request->file("files.$sectionIndex.$itemIndex"),
                                'halaman-statis',
                                $filePath 
                            );
                        }

                        $items[] = [
                            'text' => $itemText,
                            'file_url' => $request->input("file_urls.$sectionIndex.$itemIndex") ?? null,
                            'file_path' => $filePath,
                        ];
                    }
                }
                $konten[] = ['section' => $section, 'items' => $items];
            }
        }
        return $konten;
    }

    private function extractFilePaths(array $konten): array
    {
        $paths = [];
        foreach ($konten as $section) {
            if (isset($section['items']) && is_array($section['items'])) {
                foreach ($section['items'] as $item) {
                    if (!empty($item['file_path'])) {
                        $paths[] = $item['file_path'];
                    }
                }
            }
        }
        return $paths;
    }
}