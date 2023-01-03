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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TransaksiServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        // data transaksi_service absesnsi //
        $transaksi_service = TransaksiService::orderby('id_transaksi_service', 'desc')
        ->get();
        // $getbrand1 = '';
        // if(DB::table('tb_jenis_pekerjaan')->select('brand_lainnya')->where('id_jenis_pekerjaan', '=', '1')->value('brand_lainnya') != null){
        // $getbrand1 = DB::table('tb_jenis_pekerjaan')->select('brand_lainnya')->where('id_jenis_pekerjaan', '=', '1')->value('brand_lainnya');
        // } else{
        // $getbrand1 = DB::table('tb_jenis_pekerjaan')->select('brand')->where('id_jenis_pekerjaan', '=', '1')->value('brand');
        // }
        return datatables()
        ->of($transaksi_service)
        ->addIndexColumn()
        ->addColumn('brand', function ($transaksi_service) {
            return $transaksi_service->jpekerjaan;
        })
        ->addColumn('aksi',function($transaksi_service){
            $actionBtn='';

            if (auth()->user()->level == 'karyawan'){
                if ($transaksi_service->status == '1') {
                    $actionBtn.=
                    '
                    <div class="btn-group">
                        <button onclick="viewForm(`'. route('transaksi_service.update', $transaksi_service->id_transaksi_service) .'`)" class="btn btn-sm btn-primary btn-flat" style="margin: 0px 10px 10px 0px;" title="View Data"><i class="fa fa-eye"></i></button>
                        <button onclick="editForm(`'. route('transaksi_service.update', $transaksi_service->id_transaksi_service) .'`)" class="btn btn-sm btn-info btn-flat" style="margin: 0px 10px 10px 0px;" title="Edit Data"><i class="fa fa-pencil"></i></button>
                    </div>
                    ';
                } else {
                    $actionBtn.=
                    '
                    <div class="btn-group">
                        <button onclick="viewForm(`'. route('transaksi_service.update', $transaksi_service->id_transaksi_service) .'`)" class="btn btn-sm btn-primary btn-flat" style="margin: 0px 10px 10px 0px;" title="View Data"><i class="fa fa-eye"></i></button>
                        <button onclick="editForm(`'. route('transaksi_service.update', $transaksi_service->id_transaksi_service) .'`)" class="btn btn-sm btn-info btn-flat" style="margin: 0px 10px 10px 0px;" title="Edit Data"><i class="fa fa-pencil"></i></button>
                        <button onclick="finishForm(`'. route('transaksi_service.updatefinish', $transaksi_service->id_transaksi_service) .'`)" class="btn btn-sm btn-success btn-flat" style="margin: 0px 10px 10px 0px;" title="Finish Data"><i class="fa fa-check"></i></button>
                    </div>
                    ';
                }
            } elseif(auth()->user()->level == 'admin'){
                $actionBtn.=
                '
                <div class="btn-group">
                    <button onclick="deleteData(`'. route('transaksi_service.destroy', $transaksi_service->id_transaksi_service) .'`)" class="btn btn-sm btn-danger btn-flat" style="margin: 0px 10px 10px 0px;" title="Delete Data"><i class="fa fa-trash"></i></button>
                </div>
                ';
            }
            return $actionBtn;
        })
        ->rawColumns(['aksi'])
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
        return view('transaksi_service.index', compact('karyawan','getcustomer','getJpekerjaan'));
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
        $getDMY = \Carbon\Carbon::now()->format('dmY');
		$getbrand = DB::table('tb_jenis_pekerjaan')->select('brand')->where('id_jenis_pekerjaan', '=', $request->jenis_pekerjaan)->value('brand');
        $store = new TransaksiService();
        $store->no_spk = 'SPK-'.$getbrand.$getDMY.mt_rand(1000, 9999);
        $store->work_order_number = $request->work_order_number;
        $store->tanggal_service = $request->tanggal_service;
        $store->nama_customer = $request->nama_customer;
        $store->plat_nomor_mobil = $request->plat_nomor_mobil;
        $store->models = $request->models;
        $store->vin = $request->vin;
        $store->nama_teknisi = $request->nama_teknisi;
        $store->jenis_pekerjaan = implode(",",$request->jenis_pekerjaan);
        if($request->pekerjaan_lainnya != null){
        $store->pekerjaan_lainnya = $request->pekerjaan_lainnya;
        } else {
        $store->pekerjaan_lainnya = '-';
        }
        if($request->pekerjaan_lainnya != null){
        $store->harga = $request->harga;
        } else {
        $store->harga = '-';
        }
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
}
