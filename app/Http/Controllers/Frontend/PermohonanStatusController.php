<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class PermohonanStatusController extends Controller
{
    /**
     * Tampilkan form cek status
     */
    public function index()
    {
        return view('frontend.permohonan.cek-status');
    }

    /**
     * Proses pengecekan status permohonan
     */
    public function cek(Request $request)
    {
        $request->validate([
            'nomor_registrasi' => 'required|string'
        ]);

        $permohonan = Permohonan::where(
            'nomor_registrasi',
            $request->nomor_registrasi
        )->first();

        if (!$permohonan) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nomor registrasi tidak ditemukan.');
        }

        // View hasil status (sesuai update)
        return view('frontend.permohonan.hasil-status', compact('permohonan'));
    }
}
