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
        // Get current year
        $currentYear = date('Y');
        
        // Get statistics
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
        
        // Get data by month (current year)
        $dataPerBulan = Keberatan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('total', 'bulan')
            ->toArray();
        
        // Fill missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $dataPerBulan[$i] ?? 0;
        }
        
        // Get data by alasan
        $dataPerAlasan = Keberatan::selectRaw('alasan_keberatan, COUNT(*) as total')
            ->groupBy('alasan_keberatan')
            ->get();
        
        // Get data by status
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
     * Get filtered data for preview
     */
    public function preview(Request $request)
    {
        $query = Keberatan::with('permohonan');
        
        // Filter by date range
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        // Filter by status
        if ($request->filled('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }
        
        // Filter by alasan
        if ($request->filled('alasan') && $request->alasan != 'semua') {
            $query->where('alasan_keberatan', $request->alasan);
        }
        
        $keberatan = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.rekap.keberatan.preview', compact('keberatan'));
    }
    
    /**
     * Export to Excel
     */
    public function export(Request $request)
    {
        $query = Keberatan::with('permohonan');
        
        // Apply same filters as preview
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
        
        // Create Excel file using PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set title
        $sheet->setTitle('Rekap Keberatan');
        
        // Header styling
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '0e5b73']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];
        
        // Set headers
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
            'L1' => 'Tanggapan Atasan PPID',
            'M1' => 'Tanggapan Pemohon',
        ];
        
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
        }
        
        // Auto-size columns
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Fill data
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
            $sheet->setCellValue('L' . $row, $item->tanggapan_atasan_ppid ?? '-');
            $sheet->setCellValue('M' . $row, $item->tanggapan_pemohon ?? '-');
            
            // Wrap text for long content
            $sheet->getStyle('H' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('I' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('K' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('L' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('M' . $row)->getAlignment()->setWrapText(true);
            
            $row++;
        }
        
        // Set row height
        for ($i = 2; $i < $row; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(-1); // Auto height
        }
        
        // Generate filename
        $filename = 'Rekap_Keberatan_' . date('YmdHis') . '.xlsx';
        
        // Save file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        // Output to browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}