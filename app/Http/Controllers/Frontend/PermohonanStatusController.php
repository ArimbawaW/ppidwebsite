<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class PermohonanStatusController extends Controller
{
    /**
     * Display the check status form
     */
    public function index()
    {
        return view('frontend.permohonan.cek-status');
    }

    /**
     * Check permohonan status with email validation
     */
    public function cek(Request $request)
    {
        $validated = $request->validate([
            'nomor_registrasi' => 'required|string',
            'email' => 'required|email',
        ], [
            'nomor_registrasi.required' => 'Nomor registrasi wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $permohonan = Permohonan::where('nomor_registrasi', $validated['nomor_registrasi'])->first();

        if (!$permohonan) {
            return back()
                ->withInput()
                ->with('error', 'Nomor registrasi tidak ditemukan. Silakan periksa kembali.');
        }

        // Validasi email harus sesuai
        if (strtolower(trim($permohonan->email)) !== strtolower(trim($validated['email']))) {
            return back()
                ->withInput()
                ->with('error', 'Email yang Anda masukkan tidak sesuai dengan email yang terdaftar pada permohonan ini. Silakan gunakan email yang sama saat mengajukan permohonan.');
        }

        return view('frontend.permohonan.hasil-status', compact('permohonan'));
    }
}