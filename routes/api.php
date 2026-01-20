<?php

use App\Http\Controllers\Frontend\InformasiPublikController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Permohonan;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API Publik untuk Informasi Publik
Route::get('/informasi', [InformasiPublikController::class, 'index']);
Route::get('/informasi/{id}', [InformasiPublikController::class, 'show']);

// API untuk cek permohonan (untuk form keberatan)
Route::get('/permohonan/check/{nomor}', function ($nomor) {
    try {
        $permohonan = Permohonan::where('nomor_registrasi', $nomor)
            ->orWhere('kode_permohonan', $nomor)
            ->first();
        
        if (!$permohonan) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor registrasi permohonan tidak ditemukan dalam sistem'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Data permohonan berhasil ditemukan',
            'permohonan' => [
                'nomor_registrasi' => $permohonan->nomor_registrasi,
                'kategori_pemohon' => $permohonan->kategori_pemohon ?? 'perorangan',
                'nama' => $permohonan->nama_pemohon,
                'pekerjaan' => $permohonan->pekerjaan ?? '',
                'alamat' => $permohonan->alamat ?? '',
                // PENTING: Sesuaikan dengan nama kolom di database
                'no_telepon' => $permohonan->no_telepon ?? $permohonan->nomor_hp ?? '',
                'email' => $permohonan->email,
            ]
        ]);
        
    } catch (\Exception $e) {
        \Log::error('API Check Error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan sistem'
        ], 500);
    }
});
    
