<?php
namespace App\Controllers\Keuangan; // Tambahkan \Keuangan di sini!

use App\Controllers\BaseController; // Wajib panggil ini karena pindah folder
use App\Models\Keuangan\MedicalClaimModel;
use Dompdf\Dompdf;

class Keuangan extends BaseController
{
    protected $claimModel;

    public function __construct() {
        $this->claimModel = new MedicalClaimModel();
    } 

    public function index(){
        $builder = $this->claimModel->builder();
        $builder->select("
            employees.employee_id,
            employees.employee_nik,
            employees.full_name,
            employees.position,
            employees.department,
            COALESCE(claim_limits.max_claim_amount,10000000) as max_claim_amount,
            medical_claims.claim_date,
            medical_claims.claim_amount
        ");
        $builder->join('employees','employees.employee_id=medical_claims.employee_id','right');
        $builder->join('claim_limits','claim_limits.employee_id=employees.employee_id','left');
        $builder->where('medical_claims.status','DIBAYARKAN_KEUANGAN');
        $rows = $builder->get()->getResultArray();

        $karyawanData=[];
        foreach($rows as $r){
            $id=$r['employee_id'];
            if(!isset($karyawanData[$id])){
                $karyawanData[$id]=[
                    'nik'=>$r['employee_nik'],
                    'nama'=>$r['full_name'],
                    'position'=>$r['position'],
                    'department'=>$r['department'],
                    'limit'=>(int)$r['max_claim_amount'],
                    'klaim'=>[]
                ];
            }
            if($r['claim_amount']){
                $karyawanData[$id]['klaim'][]=['tanggal'=>$r['claim_date'],'total'=>(int)$r['claim_amount']];
            }
        }

        return view('keuangan/dashboard',['karyawanData'=>array_values($karyawanData)]);
    }

    public function klaim(){
        $data['klaim']=$this->claimModel
            ->select('medical_claims.*, employees.employee_nik, employees.full_name, employees.position, employees.department')
            ->join('employees','employees.employee_id=medical_claims.employee_id')
            ->where('medical_claims.status','DISETUJUI_HRD')
            ->findAll();
        return view('keuangan/klaim',$data);
    }

    public function bayar($id){
        $this->claimModel->update($id,['status'=>'DIBAYARKAN_KEUANGAN','paid_at'=>date('Y-m-d H:i:s')]);
        return redirect()->to('/keuangan/klaim');
    }

    public function riwayat()
{
    $keyword = $this->request->getGet('keyword');
    $start   = $this->request->getGet('start');
    $end     = $this->request->getGet('end');

    $model = $this->claimModel;

    $model->select('medical_claims.*, employees.employee_nik, employees.full_name, employees.position, employees.department')
          ->join('employees','employees.employee_id = medical_claims.employee_id')
          ->whereIn('medical_claims.status',['DIBAYARKAN_KEUANGAN','DITOLAK_KEUANGAN']);

    // SEARCH
    if ($keyword) {
        $model->groupStart()
              ->like('employees.full_name', $keyword)
              ->orLike('employees.employee_nik', $keyword)
              ->groupEnd();
    }

    // FILTER TANGGAL
    if ($start && $end) {
        $model->where('medical_claims.paid_at >=', $start)
              ->where('medical_claims.paid_at <=', $end . ' 23:59:59');
    }

    // ORDERING (WAJIB SEBELUM PAGINATE)
    $model->orderBy('medical_claims.paid_at','DESC')
          ->orderBy('medical_claims.claim_id','DESC');

    $data['klaim'] = $model->paginate(20);
    $data['pager'] = $model->pager;

    return view('keuangan/riwayat',$data);
}


    public function exportPdf()
{
    $keyword = $this->request->getGet('keyword');
    $start   = $this->request->getGet('start');
    $end     = $this->request->getGet('end');

    $builder = $this->claimModel->builder();

    $builder->select('medical_claims.*, employees.employee_nik, employees.full_name, employees.position, employees.department');
    $builder->join('employees', 'employees.employee_id = medical_claims.employee_id');
    $builder->whereIn('medical_claims.status', ['DIBAYARKAN_KEUANGAN', 'DITOLAK_KEUANGAN']);

    if ($keyword) {
        $builder->groupStart()
                ->like('employees.full_name', $keyword)
                ->orLike('employees.employee_nik', $keyword)
                ->groupEnd();
    }

    if ($start && $end) {
        $builder->where('medical_claims.paid_at >=', $start)
                ->where('medical_claims.paid_at <=', $end . ' 23:59:59');
    }

    $builder->orderBy('medical_claims.paid_at','DESC');

    $klaim = $builder->get()->getResultArray();

    $html = view('keuangan/export_pdf', ['klaim' => $klaim]);

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('laporan_klaim_keuangan.pdf', ['Attachment' => false]);
}

    public function tolak($claim_id)
{
    $this->claimModel->update($claim_id, [
        'status'  => 'DITOLAK_KEUANGAN',
        'paid_at' => date('Y-m-d H:i:s')
    ]);

    return redirect()->to('/keuangan/riwayat');
}

}
