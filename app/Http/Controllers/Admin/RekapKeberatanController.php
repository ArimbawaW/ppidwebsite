<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RekapKeberatanController extends Controller
{
    /**
     * Display rekap page
     */
    public function index(Request $request)
    {
        $currentYear = date('Y');
        
        // Ambil periode dari request atau default semua data
        $tanggalMulai = $request->filled('periode_mulai') 
            ? Carbon::parse($request->periode_mulai) 
            : null;
        
        $tanggalSelesai = $request->filled('periode_selesai') 
            ? Carbon::parse($request->periode_selesai) 
            : null;
        
        // Query builder untuk stats
        $statsQuery = function($query) use ($tanggalMulai, $tanggalSelesai) {
            if ($tanggalMulai && $tanggalSelesai) {
                return $query->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
            }
            return $query;
        };
        
        // Get statistics dengan filter periode (jika ada)
        $stats = [
            'total' => $statsQuery(Keberatan::query())->count(),
            'bulan_ini' => Keberatan::whereMonth('created_at', date('m'))
                                    ->whereYear('created_at', $currentYear)
                                    ->count(),
            'tahun_ini' => Keberatan::whereYear('created_at', $currentYear)->count(),
            'pending' => $statsQuery(Keberatan::whereIn('status', ['pending', 'perlu_verifikasi']))->count(),
            'diproses' => $statsQuery(Keberatan::where('status', 'diproses'))->count(),
            'selesai' => $statsQuery(Keberatan::where('status', 'selesai'))->count(),
            'ditolak' => $statsQuery(Keberatan::where('status', 'ditolak'))->count(),
        ];
        
        // Get data by month dengan filter periode
        $dataPerBulanQuery = Keberatan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $currentYear);
        
        if ($tanggalMulai && $tanggalSelesai) {
            $dataPerBulanQuery->whereBetween('created_at', [$tanggalMulai->copy()->startOfYear(), $tanggalSelesai->copy()->endOfYear()]);
        }
        
        $dataPerBulan = $dataPerBulanQuery->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('total', 'bulan')
            ->toArray();
        
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $dataPerBulan[$i] ?? 0;
        }
        
        // Get data by alasan dengan filter periode
        $dataPerAlasanQuery = Keberatan::selectRaw('alasan_keberatan, COUNT(*) as total');
        if ($tanggalMulai && $tanggalSelesai) {
            $dataPerAlasanQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        }
        $dataPerAlasan = $dataPerAlasanQuery->groupBy('alasan_keberatan')->get();
        
        // Get data by status dengan filter periode
        $dataPerStatusQuery = Keberatan::selectRaw('status, COUNT(*) as total');
        if ($tanggalMulai && $tanggalSelesai) {
            $dataPerStatusQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        }
        $dataPerStatus = $dataPerStatusQuery->groupBy('status')->get();
        
        return view('admin.rekap.keberatan.index', compact(
            'stats',
            'chartData',
            'dataPerAlasan',
            'dataPerStatus',
            'currentYear',
            'tanggalMulai',
            'tanggalSelesai'
        ));
    }
    
    /**
     * Preview
     */
    public function preview(Request $request)
{
    // Normalisasi input (biar konsisten)
    $validated = [
        'tanggal_mulai' => $request->input('tanggal_mulai')
            ?? $request->input('periode_mulai')
            ?? null,

        'tanggal_akhir' => $request->input('tanggal_selesai')
            ?? $request->input('periode_selesai')
            ?? null,

        'status' => $request->input('status'),
        'alasan' => $request->input('alasan'),
    ];

    $query = Keberatan::query();

    if ($validated['tanggal_mulai']) {
        $query->whereDate('created_at', '>=', $validated['tanggal_mulai']);
    }

    if ($validated['tanggal_akhir']) {
        $query->whereDate('created_at', '<=', $validated['tanggal_akhir']);
    }

    if ($validated['status'] && $validated['status'] !== 'semua') {
        $query->where('status', $validated['status']);
    }

    if ($validated['alasan'] && $validated['alasan'] !== 'semua') {
        $query->where('alasan_keberatan', $validated['alasan']);
    }

    $keberatan = $query->orderBy('created_at', 'desc')->get();

    return view('admin.rekap.keberatan.preview', [
        'keberatan' => $keberatan,
        'validated' => $validated, // ✅ STRUKTUR DIJAMIN ADA KEY-NYA
    ]);
}


    
    /**
     * EXPORT EXCEL (FULL DATA)
     */
    public function export(Request $request)
    {
        $query = Keberatan::query();
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('alasan') && $request->alasan != 'semua') {
            $query->where('alasan_keberatan', $request->alasan);
        }
        
        $keberatan = $query->orderBy('created_at', 'desc')->get();
        
        // Spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Keberatan');

        // Header style
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0e5b73']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
        ];

        // HEADERS
        $headers = [
            'A1' => 'No',
            'B1' => 'No. Registrasi Keberatan',
            'C1' => 'No. Registrasi Permohonan',
            'D1' => 'Tanggal Pengajuan',
            'E1' => 'Nama Pemohon',
            'F1' => 'Email',
            'G1' => 'No. Kontak',
            'H1' => 'Alasan Keberatan',
            'I1' => 'Uraian Keberatan',
            'J1' => 'Status',
            'K1' => 'Keterangan Admin',
            'L1' => 'Nama Atasan PPID',
            'M1' => 'Jabatan Atasan PPID',
            'N1' => 'Tanggapan Atasan PPID',
            'O1' => 'Nomor Surat Tanggapan',
            'P1' => 'Tanggal Surat Tanggapan',
            'Q1' => 'Tanggapan Pemohon',
            'R1' => 'Keputusan Mediasi/Ajudikasi',
            'S1' => 'Putusan Pengadilan',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
        }

        foreach (range('A', 'S') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // DATA
        $row = 2;
        foreach ($keberatan as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->nomor_registrasi);
            $sheet->setCellValue('C' . $row, $item->nomor_registrasi_permohonan);
            $sheet->setCellValue('D' . $row, $item->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue('E' . $row, $item->nama_pemohon);
            $sheet->setCellValue('F' . $row, $item->email);
            $sheet->setCellValue('G' . $row, $item->nomor_kontak);
            $sheet->setCellValue('H' . $row, $item->alasan_keberatan_label);
            $sheet->setCellValue('I' . $row, $item->uraian_keberatan);
            $sheet->setCellValue('J' . $row, $item->status_label);
            $sheet->setCellValue('K' . $row, $item->keterangan ?? '-');
            $sheet->setCellValue('L' . $row, $item->nama_atasan_ppid ?? '-');
            $sheet->setCellValue('M' . $row, $item->jabatan_atasan_ppid ?? '-');
            $sheet->setCellValue('N' . $row, $item->tanggapan_atasan_ppid ?? '-');
            $sheet->setCellValue('O' . $row, $item->nomor_surat_tanggapan ?? '-');
            $sheet->setCellValue('P' . $row, 
                $item->tanggal_surat_tanggapan
                    ? Carbon::parse($item->tanggal_surat_tanggapan)->format('d/m/Y')
                    : '-'
            );
            $sheet->setCellValue('Q' . $row, $item->tanggapan_pemohon ?? '-');
            $sheet->setCellValue('R' . $row, $item->keputusan_mediasi ?? '-');
            $sheet->setCellValue('S' . $row, $item->putusan_pengadilan ?? '-');

            foreach (['H','I','K','N','R','S'] as $col) {
                $sheet->getStyle($col . $row)->getAlignment()->setWrapText(true);
            }

            $row++;
        }

        for ($i = 2; $i < $row; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(-1);
        }

        $filename = 'Rekap_Keberatan_Lengkap_' . date('YmdHis') . '.xlsx';

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}