<?php
// app/Http/Controllers/Admin/KeberatanController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KeberatanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $keberatan = Keberatan::with('permohonan')->select('keberatan.*');
            
            return DataTables::of($keberatan)
                ->addIndexColumn()
                ->addColumn('alasan_keberatan', function ($item) {
                    $labels = [
                        'penolakan_pasal_17' => 'Penolakan Pasal 17',
                        'tidak_disediakan_berkala' => 'Tidak Disediakan Berkala',
                        'tidak_ditanggapi' => 'Tidak Ditanggapi',
                        'tidak_sesuai_permintaan' => 'Tidak Sesuai Permintaan',
                        'tidak_dipenuhi' => 'Tidak Dipenuhi',
                        'biaya_tidak_wajar' => 'Biaya Tidak Wajar',
                        'melebihi_jangka_waktu' => 'Melebihi Jangka Waktu',
                    ];
                    
                    $label = $labels[$item->alasan_keberatan] ?? $item->alasan_keberatan;
                    return '<span class="badge bg-secondary">' . $label . '</span>';
                })
                ->addColumn('status', function ($item) {
                    $badges = [
                        'pending' => '<span class="badge bg-warning text-dark">Pending</span>',
                        'diproses' => '<span class="badge bg-info">Diproses</span>',
                        'selesai' => '<span class="badge bg-success">Selesai</span>',
                        'ditolak' => '<span class="badge bg-danger">Ditolak</span>',
                    ];
                    
                    return $badges[$item->status] ?? '<span class="badge bg-secondary">' . ucfirst($item->status) . '</span>';
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at->format('d M Y H:i');
                })
                ->addColumn('action', function ($item) {
                    return view('admin.keberatan.action', compact('item'))->render();
                })
                ->rawColumns(['alasan_keberatan', 'status', 'action'])
                ->make(true);
        }

        return view('admin.keberatan.index');
    }

    public function show($id)
    {
        $keberatan = Keberatan::with('permohonan')->findOrFail($id);
        return view('admin.keberatan.show', compact('keberatan'));
    }

    public function quickView($id)
    {
        $keberatan = Keberatan::with('permohonan')->findOrFail($id);
        return view('admin.keberatan.quick-view', compact('keberatan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $keberatan = Keberatan::findOrFail($id);
        $keberatan->update($validated);

        return redirect()->route('admin.keberatan.index')
            ->with('success', 'Status keberatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $keberatan = Keberatan::findOrFail($id);
        
        // Hapus file kartu identitas jika ada
        if ($keberatan->kartu_identitas_path) {
            \Storage::disk('public')->delete($keberatan->kartu_identitas_path);
        }
        
        $keberatan->delete();

        return redirect()->route('admin.keberatan.index')
            ->with('success', 'Keberatan berhasil dihapus.');
    }
}