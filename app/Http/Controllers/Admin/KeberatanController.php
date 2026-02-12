<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class KeberatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Load semua keberatan dengan relasi permohonan
        $keberatan = Keberatan::with('permohonan')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.keberatan.index', compact('keberatan'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Keberatan $keberatan)
    {
        $keberatan->load('permohonan');
        
        return view('admin.keberatan.show', compact('keberatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keberatan $keberatan)
    {
        $keberatan->load('permohonan');
        
        return view('admin.keberatan.edit', compact('keberatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keberatan $keberatan)
    {
        $request->validate([
            'status' => 'required|in:pending,perlu_verifikasi,diproses,ditunda,selesai,dikabulkan,ditolak',
            'keterangan' => 'nullable|string',
            'tanggapan_atasan_ppid' => 'nullable|string',
            'nama_atasan_ppid' => 'nullable|string',
            'jabatan_atasan_ppid' => 'nullable|string',
            'nomor_surat_tanggapan' => 'nullable|string',
            'tanggal_surat_tanggapan' => 'nullable|date',
            'keputusan_mediasi' => 'nullable|string',
            'putusan_pengadilan' => 'nullable|string',
        ]);

        $oldStatus = $keberatan->status;

        // Update field satu per satu untuk menghindari mass assignment error
        $keberatan->status = $request->status;
        $keberatan->keterangan = $request->keterangan;
        $keberatan->tanggapan_atasan_ppid = $request->tanggapan_atasan_ppid;
        $keberatan->nama_atasan_ppid = $request->nama_atasan_ppid;
        $keberatan->jabatan_atasan_ppid = $request->jabatan_atasan_ppid;
        $keberatan->nomor_surat_tanggapan = $request->nomor_surat_tanggapan;
        $keberatan->tanggal_surat_tanggapan = $request->tanggal_surat_tanggapan;
        $keberatan->keputusan_mediasi = $request->keputusan_mediasi;
        $keberatan->putusan_pengadilan = $request->putusan_pengadilan;
        
        // Set tanggal selesai jika status selesai, dikabulkan, atau ditolak
        if (in_array($request->status, ['selesai', 'dikabulkan', 'ditolak']) && !$keberatan->tanggal_selesai) {
            $keberatan->tanggal_selesai = now();
        }
        
        // Reset tanggal selesai jika status kembali ke pending/diproses/ditunda
        if (in_array($request->status, ['pending', 'perlu_verifikasi', 'diproses', 'ditunda'])) {
            $keberatan->tanggal_selesai = null;
        }
        
        $keberatan->save();

        // Kirim email notifikasi jika status berubah
        if ($oldStatus !== $request->status && $keberatan->email) {
            try {
                $this->sendStatusChangeEmail($keberatan);
            } catch (\Exception $e) {
                Log::error('Error mengirim email keberatan: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.keberatan.show', $keberatan)
            ->with('success', 'Keberatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keberatan $keberatan)
    {
        // Hapus file dokumen pendukung jika ada
        if ($keberatan->file_pendukung_path && Storage::disk('public')->exists($keberatan->file_pendukung_path)) {
            Storage::disk('public')->delete($keberatan->file_pendukung_path);
        }
        
        $keberatan->delete();

        return redirect()->route('admin.keberatan.index')
            ->with('success', 'Keberatan berhasil dihapus.');
    }

    /**
     * Display statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => Keberatan::count(),
            'pending' => Keberatan::where('status', 'pending')->count(),
            'diproses' => Keberatan::where('status', 'diproses')->count(),
            'dikabulkan' => Keberatan::where('status', 'dikabulkan')->count(),
            'ditolak' => Keberatan::where('status', 'ditolak')->count(),
        ];

        // Statistik Indikator Waktu
        $keberatanAktif = Keberatan::aktif()->get();
        $statsIndikator = [
            'on_schedule' => 0,
            'attention' => 0,
            'urgent' => 0,
            'terlambat' => 0,
        ];

        foreach ($keberatanAktif as $item) {
            $indikator = $item->indikator_waktu;
            $label = strtolower(str_replace(' ', '_', $indikator['label']));
            
            if ($label === 'on_schedule') {
                $statsIndikator['on_schedule']++;
            } elseif ($label === 'attention') {
                $statsIndikator['attention']++;
            } elseif ($label === 'urgent') {
                $statsIndikator['urgent']++;
            } elseif ($label === 'terlambat') {
                $statsIndikator['terlambat']++;
            }
        }

        return view('admin.keberatan.statistics', compact('stats', 'statsIndikator'));
    }

    /**
     * Send email notification for status change
     */
    private function sendStatusChangeEmail($keberatan)
    {
        // Implementasi pengiriman email
        // Sesuaikan dengan template email yang sudah dibuat
        // Anda bisa menggunakan GraphMailService seperti di PermohonanController
    }
}