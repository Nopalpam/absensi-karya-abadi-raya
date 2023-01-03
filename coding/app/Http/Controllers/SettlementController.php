<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use App\Models\TransaksiService;
use Carbon\Carbon;
use Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportAbsensi;
use App\Models\Dealer;
use App\Models\JenisPekerjaan;
use App\Models\Setting;
use App\Models\Settlement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PDF;

class SettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        // data settlement //
        $settlement = Settlement::orderby('created_at', 'desc')
        ->get();
        // $getbrand1 = '';
        // if(DB::table('tb_jenis_pekerjaan')->select('brand_lainnya')->where('id_jenis_pekerjaan', '=', '1')->value('brand_lainnya') != null){
        // $getbrand1 = DB::table('tb_jenis_pekerjaan')->select('brand_lainnya')->where('id_jenis_pekerjaan', '=', '1')->value('brand_lainnya');
        // } else{
        // $getbrand1 = DB::table('tb_jenis_pekerjaan')->select('brand')->where('id_jenis_pekerjaan', '=', '1')->value('brand');
        // }
        return datatables()
        ->of($settlement)
        ->addIndexColumn()
        ->addColumn('id_invoice', function ($settlement) {
            return '
            <div>
            <a href="'. route('settlement.view_pdf', $settlement->id_invoice) .'" title="Show Data">
                '.$settlement->id_invoice.'
            </a>
            </div>
            ';
        })
        ->addColumn('aksi', function ($settlement) {
            $actionBtn='';
            if ($settlement->status == 'PAID') {
            } else {
                $actionBtn.=
                '
                <button onclick="paidform(`'. route('settlement.updateStatus', $settlement->id_settlement) .'`)" class="btn btn-sm btn-success btn-flat" title="Ubah Status" style="margin: 0px 10px 10px 0px;padding-bottom: 8px;padding-top: 8px;"><i class="fa fa-money"></i></button>
                ';
            }

            if ($settlement->status_cetak == '1') {
                $actionBtn.=
                '
                <a href="'. route('settlement.view_pdf_full', $settlement->id_invoice) .'" target="_blank" class="btn btn-sm btn-primary btn-flat" style="margin: 0px 10px 10px 0px;">Lihat Invoice &nbsp; <i class="fa fa-eye"></i></a>
                ';
            } else {
                $actionBtn.=
                '
                <button onclick="finishForm(`'. route('settlement.updatefinish', $settlement->id_settlement) .'`)" class="btn btn-sm btn-primary btn-flat" title="Cetak Invoice" style="margin: 0px 10px 10px 0px;padding-bottom: 8px;padding-top: 8px;"><i class="fa fa-print"></i></button>
                ';
            }
            return '<div class="btn-group">'.$actionBtn.'</div>';
        })
        ->addColumn('top', function ($settlement) {
            return date_format($settlement->created_at->addDays($settlement->top),"d F Y");
        })
        ->rawColumns(['id_invoice','aksi','top'])
        ->make(true);
    }

    public function data_bulanan()
    {
        // data transaksi_service absesnsi //
    }

    public function index()
    {
        // index laporan //
        $karyawan = User::where('level', 'karyawan')->orderby('name', 'ASC')->get();
        $getcustomer = Dealer::get();
        $getJpekerjaan = JenisPekerjaan::get();
        return view('settlement.index', compact('karyawan','getcustomer','getJpekerjaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // store transaksi_service //
        $store = new Settlement();
        $store->id_transaksi_services = $request->id_transaksiservice;
        $store->id_invoice = mt_rand(1000000000, 9999999999);
        $store->desc = $request->desc;
        $store->norek = $request->norek;
        $store->nama_bank = $request->nama_bank;
        $store->npwp = $request->npwp;
        $store->top = $request->top;
        $store->save();
        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = Settlement::find($id);
        return response()->json($show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Settlement::find($id);
        $update->work_order_number = $request->work_order_number;
        $update->tanggal_service = $request->tanggal_service;
        $update->nama_customer = $request->nama_customer;
        $update->plat_nomor_mobil = $request->plat_nomor_mobil;
        $update->models = $request->models;
        $update->vin = $request->vin;
        $update->nama_teknisi = $request->nama_teknisi;
        $update->jenis_pekerjaan = implode(",",$request->jenis_pekerjaan);
        if($request->pekerjaan_lainnya != null){
        $update->pekerjaan_lainnya = $request->pekerjaan_lainnya;
        } else {
        $update->pekerjaan_lainnya = '-';
        }
        if($request->pekerjaan_lainnya != null){
        $update->harga = $request->harga;
        } else {
        $update->harga = '-';
        }
        $update->save();

        return response()->json('Data berhasil diupdate', 200);
    }

    public function updateStatus(Request $request, $id)
    {
        Settlement::where('id_settlement',$id)->update([
            'status' => 'PAID',
        ]);
        return response()->json('Data berhasil diupdate', 200);
    }

    public function updatefinish(Request $request, $id)
    {
        Settlement::where('id_settlement',$id)->update([
            'status_cetak' => '1',
        ]);
        return response()->json('Data berhasil diupdate', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Settlement::findorfail($id);
        $delete->delete();
        return response('Data berhasil dihapus', 204);
    }

    public function view_pdf(Request $request, $id) {
        $getTransaksiServiceId = Settlement::select('id_transaksi_services')->where('id_invoice', '=', $id)->value('id_transaksi_services');
    	$data = TransaksiService::whereIn('id_transaksi_service', explode(',', $getTransaksiServiceId))->get();
        $pdf = PDF::loadView('invoice/cetaknoui', ['data'=>$data,'id'=>$id])
        ->setPaper('a4');
        $pdf->setOption('enable-local-file-access', true);
        return $pdf->stream('invoice_'.$id.'.pdf');
    }

    public function view_pdf_full(Request $request, $id) {
        $getTransaksiServiceId = Settlement::select('id_transaksi_services')->where('id_invoice', '=', $id)->value('id_transaksi_services');
        $getTransaksiService = Settlement::where('id_invoice', '=', $id)->get();
        $getSetting = Setting::get();
        $getIdCustomer = explode(',', $getTransaksiService[0]->id_transaksi_services);
        $getTransaksiServiceNama = TransaksiService::where('id_transaksi_service', '=', $getIdCustomer[0])->get();
        $getDealer = Dealer::where('nama_customer', '=', $getTransaksiServiceNama[0]->nama_customer)->get();
        // dd($getDealer);
    	$data = TransaksiService::whereIn('id_transaksi_service', explode(',', $getTransaksiServiceId))->get();
        $pdf = PDF::loadView('invoice/cetak', ['data'=>$data,'datasettle'=>$getTransaksiService,'getSetting'=>$getSetting,'getDealer'=>$getDealer])->setOption('margin-bottom', '0mm')
            ->setOption('margin-top', '0mm')
            ->setOption('margin-right', '0mm')
            ->setOption('margin-left', '0mm')
        ->setPaper('a4');
        $pdf->setOption('enable-local-file-access', true);
        return $pdf->stream('invoice_'.$id.'.pdf');
    }

    public function cetak_pdf()
    {
    	$data = TransaksiService::all();

    	$pdf = PDF::loadview('invoice/cetak',['data'=>$data]);
    	return $pdf->download('laporan-pegawai-pdf.pdf');
    }
}
