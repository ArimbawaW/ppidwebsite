<?php
// app/Http/Controllers/Admin/KeberatanController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use App\Services\GraphMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
                        'pending' => '<span class="badge badge-warning">Pending</span>',
                        'diproses' => '<span class="badge badge-info">Diproses</span>',
                        'selesai' => '<span class="badge badge-success">Selesai</span>',
                        'ditolak' => '<span class="badge badge-danger">Ditolak</span>',
                    ];
                    
                    return $badges[$item->status] ?? '<span class="badge badge-secondary">' . ucfirst($item->status) . '</span>';
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
            
            // Validasi untuk kolom tambahan (tanggapan_pemohon tidak divalidasi karena diisi user)
            'tanggapan_atasan_ppid' => 'nullable|string',
            'nomor_surat_tanggapan' => 'nullable|string|max:100',
            'tanggal_surat_tanggapan' => 'nullable|date',
            'nama_atasan_ppid' => 'nullable|string|max:255',
            'jabatan_atasan_ppid' => 'nullable|string|max:255',
            'keputusan_mediasi' => 'nullable|string',
            'putusan_pengadilan' => 'nullable|string',
        ]);

        $keberatan = Keberatan::with('permohonan')->findOrFail($id);
        $oldStatus = $keberatan->status;
        $oldStatusLabel = $keberatan->status_label;
        
        $keberatan->update($validated);
        
        // Refresh untuk mendapatkan status_label yang baru
        $keberatan->refresh();

        // Kirim email pemberitahuan perubahan status ke pemohon
        $permohonan = $keberatan->permohonan;
        if ($permohonan && $permohonan->email) {
            $mailer = app(GraphMailService::class);
            $content =
                "Halo {$keberatan->nama_pemohon},\n\n" .
                "Status keberatan Anda telah berubah.\n" .
                "Nomor Registrasi Keberatan: {$keberatan->nomor_registrasi}\n" .
                "Nomor Registrasi Permohonan: {$keberatan->nomor_registrasi_permohonan}\n" .
                "Status sebelumnya: {$oldStatusLabel}\n" .
                "Status sekarang: {$keberatan->status_label}\n" .
                ($keberatan->keterangan ? "Keterangan: {$keberatan->keterangan}\n" : '') .
                "\nAnda dapat mengecek status melalui halaman cek status keberatan.";

            if (!$mailer->send($permohonan->email, 'Pembaruan Status Keberatan - PPID', $content)) {
                Log::error('Gagal mengirim email status keberatan (Graph).', [
                    'keberatan_id' => $keberatan->id,
                    'email' => $permohonan->email,
                ]);
            }
        }

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