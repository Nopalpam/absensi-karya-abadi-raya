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
use App\Models\Settlement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PDF;
use PDFSnappy;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $transaksi_service = TransaksiService::where('status' ,'1')->where('status_settlement' ,'0')->orderby('id_transaksi_service', 'desc')
        ->get();
        return datatables()
        ->of($transaksi_service)
        ->addIndexColumn()
        ->addColumn('brand', function ($transaksi_service) {
            return $transaksi_service->jpekerjaan;
        })
        ->addColumn('aksi', function ($transaksi_service) {
            return '
            <div class="btn-group">
                <button onclick="getsingledata('.$transaksi_service->id_transaksi_service.')" class="btn btn-sm btn-success btn-flat" title="Cetak Invoice"><i class="fa fa-book"></i></button>
            </div>
            ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function data_bulanan()
    {
    }

    public function index()
    {
        // index laporan //
        $karyawan = User::where('level', 'karyawan')->orderby('name', 'ASC')->get();
        $getcustomer = Dealer::get();
        $getJpekerjaan = JenisPekerjaan::get();
        return view('invoice.index', compact('karyawan','getcustomer','getJpekerjaan'));
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

        TransaksiService::whereIn('id_transaksi_service', explode(',', $request->id_transaksiservice))
        ->update(['status_settlement' => 1]);

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
        $show = TransaksiService::find($id);
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
        $update = TransaksiService::find($id);
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

    public function updatefinish(Request $request, $id)
    {
        TransaksiService::where('id_transaksi_service',$id)->update([
            'status' => '1',
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
        $delete = TransaksiService::findorfail($id);
        $delete->delete();
        return response('Data berhasil dihapus', 204);
    }

    public function view_pdf_old(Request $request) {
        // dibawah ini cara munculin list di pdf
        // $q_editpost = TransaksiService::whereIn('id_transaksi_service', ['9', '8'])
        // ->get();
        // dd($q_editpost);
    	$data = TransaksiService::where('status','1')->get();
        $pdf = PDF::loadView('invoice/cetak', ['data'=>$data])->setPaper('A4', 'landscape');
        return $pdf->stream('laporan-pegawai-pdf.pdf');
        // return view('invoice.cetak');
    }

    // public function view_pdf() {
    // 	$data = TransaksiService::where('status','1')->get();
    //     $pdf = PDF::loadView('invoice/cetak', ['data'=>$data])->setOption('margin-bottom', '0mm')
    //     ->setOption('margin-top', '0mm')
    //     ->setOption('margin-right', '0mm')
    //     ->setOption('margin-left', '0mm')
    //     ->setPaper('a4');
    //     $pdf->setOption('enable-local-file-access', true);
    //     return $pdf->stream('invoice_'.$id.'.pdf');
    //     // return $pdf->download('table.pdf);
    // }

    // public function cetak_pdf()
    // {
    // 	$data = TransaksiService::all();

    // 	$pdf = PDF::loadview('invoice/cetak',['data'=>$data]);
    // 	return $pdf->download('laporan-pegawai-pdf.pdf');
    // }
}
