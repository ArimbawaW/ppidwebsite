<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgendaKegiatan;
use Illuminate\Http\Request;

class AgendaKegiatanController extends Controller
{
    public function index()
    {
        $agenda = AgendaKegiatan::orderBy('tanggal', 'desc')->paginate(15);
        return view('admin.agenda-kegiatan.index', compact('agenda'));
    }

    public function create()
    {
        return view('admin.agenda-kegiatan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable',  // ← HAPUS date_format:H:i
            'waktu_selesai' => 'nullable',  // ← HAPUS date_format:H:i|after:waktu_mulai
            'lokasi' => 'nullable|string|max:255',
            'penyelenggara' => 'nullable|string|max:255',
            'status' => 'required|in:upcoming,ongoing,completed',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        AgendaKegiatan::create($validated);

        return redirect()->route('admin.agenda-kegiatan.index')
            ->with('success', 'Agenda kegiatan berhasil ditambahkan');
    }

    public function edit(AgendaKegiatan $agendaKegiatan)
    {
        return view('admin.agenda-kegiatan.edit', compact('agendaKegiatan'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'waktu_mulai' => 'nullable',
        'waktu_selesai' => 'nullable',
        'lokasi' => 'nullable|string|max:255',
        'deskripsi' => 'nullable|string',
        'penyelenggara' => 'nullable|string|max:255',
        'status' => 'required|in:upcoming,ongoing,completed', // ← Tambahkan validasi status
    ]);
    
    $agenda = AgendaKegiatan::findOrFail($id);
    
    $agenda->update([
        'judul' => $request->judul,
        'tanggal' => $request->tanggal,
        'waktu_mulai' => $request->waktu_mulai,
        'waktu_selesai' => $request->waktu_selesai,
        'lokasi' => $request->lokasi,
        'deskripsi' => $request->deskripsi,
        'penyelenggara' => $request->penyelenggara, // ← Tambahkan
        'status' => $request->status, // ← TAMBAHKAN INI (PENTING!)
        'is_active' => $request->has('is_active'), // ← Tambahkan
    ]);
    
    return redirect()->route('admin.agenda-kegiatan.index')
        ->with('success', 'Agenda kegiatan berhasil diperbarui!');
}

    public function destroy(AgendaKegiatan $agendaKegiatan)
    {
        $agendaKegiatan->delete();

        return redirect()->route('admin.agenda-kegiatan.index')
            ->with('success', 'Agenda kegiatan berhasil dihapus');
    }
}