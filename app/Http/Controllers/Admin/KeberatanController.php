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
            'status' => 'required|in:pending,diproses,dikabulkan,ditolak',
            'tanggapan_ppid' => 'nullable|string',
        ]);

        $oldStatus = $keberatan->status;

        $keberatan->status = $request->status;
        $keberatan->tanggapan_ppid = $request->tanggapan_ppid;
        
        // Set tanggal selesai jika status dikabulkan atau ditolak
        if (in_array($request->status, ['dikabulkan', 'ditolak'])) {
            $keberatan->tanggal_selesai = now();
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
            'aman' => 0,
            'perhatian' => 0,
            'urgent' => 0,
            'terlambat' => 0,
        ];

        foreach ($keberatanAktif as $item) {
            $indikator = $item->indikator_waktu;
            $label = strtolower($indikator['label']);
            
            if ($label === 'aman') {
                $statsIndikator['aman']++;
            } elseif ($label === 'perhatian') {
                $statsIndikator['perhatian']++;
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