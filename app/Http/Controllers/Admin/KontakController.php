<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KontakController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kontak = Kontak::query();
            return DataTables::of($kontak)
                ->addColumn('action', function ($item) {
                    return view('admin.kontak.action', compact('item'))->render();
                })
                ->editColumn('status', function ($item) {
                    $badge = match($item->status) {
                        'unread' => 'warning',
                        'read' => 'info',
                        'replied' => 'success',
                        default => 'secondary',
                    };
                    return '<span class="badge bg-' . $badge . '">' . ucfirst($item->status) . '</span>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.kontak.index');
    }

    public function show($id)
    {
        $kontak = Kontak::findOrFail($id);
        $kontak->update(['status' => 'read']);
        return view('admin.kontak.show', compact('kontak'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:unread,read,replied',
        ]);

        $kontak = Kontak::findOrFail($id);
        $kontak->update($validated);

        return redirect()->route('admin.kontak.index')
            ->with('success', 'Status kontak berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kontak = Kontak::findOrFail($id);
        $kontak->delete();

        return redirect()->route('admin.kontak.index')
            ->with('success', 'Kontak berhasil dihapus.');
    }
}

