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
    public function index()
    {
        $currentYear = date('Y');
        
        $stats = [
            'total' => Keberatan::count(),
            'bulan_ini' => Keberatan::whereMonth('created_at', date('m'))
                                    ->whereYear('created_at', $currentYear)
                                    ->count(),
            'tahun_ini' => Keberatan::whereYear('created_at', $currentYear)->count(),
            'pending' => Keberatan::where('status', 'pending')->count(),
            'diproses' => Keberatan::where('status', 'diproses')->count(),
            'selesai' => Keberatan::where('status', 'selesai')->count(),
            'ditolak' => Keberatan::where('status', 'ditolak')->count(),
        ];
        
        $dataPerBulan = Keberatan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('total', 'bulan')
            ->toArray();
        
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $dataPerBulan[$i] ?? 0;
        }
        
        $dataPerAlasan = Keberatan::selectRaw('alasan_keberatan, COUNT(*) as total')
            ->groupBy('alasan_keberatan')
            ->get();
        
        $dataPerStatus = Keberatan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();
        
        return view('admin.rekap.keberatan.index', compact(
            'stats',
            'chartData',
            'dataPerAlasan',
            'dataPerStatus',
            'currentYear'
        ));
    }
    
    /**
     * Preview
     */
    public function preview(Request $request)
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
        
        return view('admin.rekap.keberatan.preview', compact('keberatan'));
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

            // ATASAN PPID
            'L1' => 'Nama Atasan PPID',
            'M1' => 'Jabatan Atasan PPID',
            'N1' => 'Tanggapan Atasan PPID',
            'O1' => 'Nomor Surat Tanggapan',
            'P1' => 'Tanggal Surat Tanggapan',

            // PEMOHON
            'Q1' => 'Tanggapan Pemohon',

            // MEDIASI
            'R1' => 'Keputusan Mediasi/Ajudikasi',

            // PENGADILAN
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

            // ATASAN PPID
            $sheet->setCellValue('L' . $row, $item->nama_atasan_ppid ?? '-');
            $sheet->setCellValue('M' . $row, $item->jabatan_atasan_ppid ?? '-');
            $sheet->setCellValue('N' . $row, $item->tanggapan_atasan_ppid ?? '-');
            $sheet->setCellValue('O' . $row, $item->nomor_surat_tanggapan ?? '-');
            $sheet->setCellValue('P' . $row, 
                $item->tanggal_surat_tanggapan
                    ? Carbon::parse($item->tanggal_surat_tanggapan)->format('d/m/Y')
                    : '-'
            );

            // PEMOHON
            $sheet->setCellValue('Q' . $row, $item->tanggapan_pemohon ?? '-');

            // MEDIASI
            $sheet->setCellValue('R' . $row, $item->keputusan_mediasi ?? '-');

            // PENGADILAN
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
