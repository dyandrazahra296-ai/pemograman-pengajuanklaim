<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MedicalClaimModel;

// Import library eksternal
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reports extends BaseController
{
    /**
     * Halaman Utama Dashboard Report
     */
    public function index()
    {
        $claimModel = new MedicalClaimModel();

        $totalPengajuan = $claimModel->where('status', 'PENGAJUAN')->countAllResults();
        $totalDisetujui = $claimModel->whereIn('status', ['DISETUJUI_HRD', 'DIBAYARKAN_KEUANGAN'])->countAllResults();
        $totalDitolak   = $claimModel->where('status', 'DITOLAK_HRD')->countAllResults();

        $totalNominal = $claimModel
            ->selectSum('claim_amount')
            ->get()
            ->getRow()
            ->claim_amount ?? 0;

        return view('admin/reports/index', [
            'totalPengajuan' => $totalPengajuan,
            'totalDisetujui' => $totalDisetujui,
            'totalDitolak'   => $totalDitolak,
            'totalNominal'   => $totalNominal,
        ]);
    }

    /**
     * Menampilkan hasil filter di tabel (AJAX/Normal)
     */
    public function filter()
    {
        $claims = $this->_getFilteredClaims();

        return view('admin/reports/result', [
            'claims' => $claims
        ]);
    }

    /**
     * Export ke PDF menggunakan Dompdf
     */
    public function exportPdf()
    {
        $claims = $this->_getFilteredClaims();

        $html = view('admin/reports/pdf', ['claims' => $claims]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        // JANGAN pakai ->download() milik CI4 jika datanya hasil renderan Dompdf
        // Langsung saja stream dari objek dompdf-nya
        $dompdf->stream("laporan_klaim.pdf", ["Attachment" => 1]);
        exit(); // Wajib pakai exit supaya tidak diproses lagi oleh CI4
    }
    /**
     * Export ke Excel menggunakan PhpSpreadsheet
     */
    public function exportExcel()
    {
        $claims = $this->_getFilteredClaims();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // HEADER
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal Klaim');
        $sheet->setCellValue('C1', 'Nominal');
        $sheet->setCellValue('D1', 'Status');

        // Styling Header
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal('center');

        // Isi Data
        $row = 2;
        $no = 1;
        foreach ($claims as $c) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $c['claim_date']);
            $sheet->setCellValue('C' . $row, $c['claim_amount']);
            $sheet->setCellValue('D' . $row, $c['status']);
            $row++;
        }

        // Auto size kolom
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        // Header untuk download langsung
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="laporan_klaim.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * Fungsi Private untuk memproses filter data agar tidak terjadi duplikasi kode
     */
    private function _getFilteredClaims()
    {
        $claimModel = new MedicalClaimModel();

        $start  = $this->request->getGet('start_date');
        $end    = $this->request->getGet('end_date');
        $status = $this->request->getGet('status');

        if ($start && $end) {
            $claimModel->where('claim_date >=', $start)
                       ->where('claim_date <=', $end);
        }

        if ($status && $status !== 'ALL') {
            $claimModel->where('status', $status);
        }

        return $claimModel->orderBy('claim_date', 'DESC')->findAll();
    }
}