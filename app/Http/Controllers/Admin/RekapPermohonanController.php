<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RekapPermohonanController extends Controller
{
    /**
     * Display rekap page
     */
    public function index(Request $request)
    {
        // Get current year
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
            'total' => $statsQuery(Permohonan::query())->count(),
            'bulan_ini' => Permohonan::whereMonth('created_at', date('m'))
                                     ->whereYear('created_at', $currentYear)
                                     ->count(),
            'tahun_ini' => Permohonan::whereYear('created_at', $currentYear)->count(),
            'perlu_verifikasi' => $statsQuery(Permohonan::where('status', 'perlu_verifikasi'))->count(),
            'diproses' => $statsQuery(Permohonan::where('status', 'diproses'))->count(),
            'selesai' => $statsQuery(Permohonan::whereIn('status', ['dikabulkan_seluruhnya', 'dikabulkan_sebagian']))->count(),
            'ditolak' => $statsQuery(Permohonan::where('status', 'ditolak'))->count(),
        ];
        
        // Get data by month (current year)
        $dataPerBulanQuery = Permohonan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $currentYear);
        
        if ($tanggalMulai && $tanggalSelesai) {
            $dataPerBulanQuery->whereBetween('created_at', [$tanggalMulai->copy()->startOfYear(), $tanggalSelesai->copy()->endOfYear()]);
        }
        
        $dataPerBulan = $dataPerBulanQuery->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('total', 'bulan')
            ->toArray();
        
        // Fill missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $dataPerBulan[$i] ?? 0;
        }
        
        // Get data by kategori dengan filter periode
        $dataPerKategoriQuery = Permohonan::selectRaw('kategori_pemohon, COUNT(*) as total');
        if ($tanggalMulai && $tanggalSelesai) {
            $dataPerKategoriQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        }
        $dataPerKategori = $dataPerKategoriQuery->groupBy('kategori_pemohon')->get();
        
        // Get data by status dengan filter periode
        $dataPerStatusQuery = Permohonan::selectRaw('status, COUNT(*) as total');
        if ($tanggalMulai && $tanggalSelesai) {
            $dataPerStatusQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        }
        $dataPerStatus = $dataPerStatusQuery->groupBy('status')->get();
        
        return view('admin.rekap.permohonan.index', compact(
            'stats',
            'chartData',
            'dataPerKategori',
            'dataPerStatus',
            'currentYear',
            'tanggalMulai',
            'tanggalSelesai'
        ));
    }
    
    /**
     * Get filtered data for preview
     */
    public function preview(Request $request)
    {
        $query = Permohonan::query();
        
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
        
        // Filter by kategori informasi
        if ($request->filled('kategori_informasi') && $request->kategori_informasi != 'semua') {
            $query->where('kategori_informasi', $request->kategori_informasi);
        }
        
        $permohonan = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.rekap.permohonan.preview', compact('permohonan'));
    }
    
    /**
     * Export to Excel
     */
    public function export(Request $request)
    {
        $query = Permohonan::query();
        
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
        
        if ($request->filled('kategori_informasi') && $request->kategori_informasi != 'semua') {
            $query->where('kategori_informasi', $request->kategori_informasi);
        }
        
        $permohonan = $query->orderBy('created_at', 'desc')->get();
        
        // Create Excel file using PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set title
        $sheet->setTitle('Rekap Permohonan');
        
        // Header styling
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '0e5b73']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];
        
        // Set headers
        $headers = [
            'A1' => 'No',
            'B1' => 'Nomor Registrasi',
            'C1' => 'Tanggal Pengajuan',
            'D1' => 'Kategori Pemohon',
            'E1' => 'Nama Pemohon',
            'F1' => 'Kategori Informasi',
            'G1' => 'Jenis Permohonan',
            'H1' => 'Status Informasi',
            'I1' => 'Bentuk Informasi',
            'J1' => 'Jenis Permintaan',
            'K1' => 'Rincian Informasi',
            'L1' => 'Status',
            'M1' => 'Tanggal Selesai',
            'N1' => 'Catatan Admin',
        ];
        
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
        }
        
        // Auto-size columns
        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Fill data
        $row = 2;
        foreach ($permohonan as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->nomor_registrasi);
            $sheet->setCellValue('C' . $row, $item->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue('D' . $row, $item->kategori_label);
            $sheet->setCellValue('E' . $row, $item->nama);
            $sheet->setCellValue('F' . $row, $item->kategori_informasi ?? '-');
            $sheet->setCellValue('G' . $row, $item->jenis_permohonan_informasi ?? '-');
            $sheet->setCellValue('H' . $row, $item->status_informasi ?? '-');
            $sheet->setCellValue('I' . $row, $item->bentuk_informasi ?? '-');
            $sheet->setCellValue('J' . $row, $item->jenis_permintaan ?? '-');
            $sheet->setCellValue('K' . $row, $item->rincian_informasi);
            $sheet->setCellValue('L' . $row, $item->status_label);
            $sheet->setCellValue('M' . $row, $item->tanggal_selesai ? Carbon::parse($item->tanggal_selesai)->format('d/m/Y H:i') : '-');
            $sheet->setCellValue('N' . $row, $item->catatan_admin ?? '-');
            
            // Wrap text for long content
            foreach (['H','I','J','K','N'] as $col) {
                $sheet->getStyle($col . $row)->getAlignment()->setWrapText(true);
            }
            
            $row++;
        }
        
        // Set row height
        for ($i = 2; $i < $row; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(-1);
        }
        
        // Generate filename
        $filename = 'Rekap_Permohonan_' . date('YmdHis') . '.xlsx';
        
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