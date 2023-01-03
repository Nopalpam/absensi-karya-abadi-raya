<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use App\Models\Dealer;
use Carbon\Carbon;
use Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportAbsensi;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        // data dealer absesnsi //
        $dealer = Dealer::orderby('id_dealer', 'desc')
        ->get();
        return datatables()
        ->of($dealer)
        ->addIndexColumn()
        ->addColumn('aksi', function ($dealer) {
            return '
            <div class="btn-group">
                <button onclick="editForm(`'. route('dealer.update', $dealer->id_dealer) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`'. route('dealer.destroy', $dealer->id_dealer) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
            </div>
            ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function data_bulanan()
    {
        // data dealer absesnsi //
    }

    public function index()
    {
        // index laporan //
        $karyawan = User::where('level', 'karyawan')->orderby('name', 'ASC')->get();
        return view('dealer.index', compact('karyawan'));
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
        // store Dealer //
        $store = new Dealer();
        $store->nama_customer = $request->nama_customer;
        $store->brand_customer = $request->brand_customer;
        $store->alamat = $request->alamat;
        $store->contact_person = $request->contact_person;
        $store->nomor_mou = $request->nomor_mou;
        $store->tanggal_perjanjian_awal = $request->tanggal_perjanjian_awal;
        $store->tanggal_perjanjian_akhir = $request->tanggal_perjanjian_akhir;
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
        $show = Dealer::find($id);
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
        // update data dealer //
        $update = Dealer::find($id);
        $update->nama_customer = $request->nama_customer;
        $update->brand_customer = $request->brand_customer;
        $update->alamat = $request->alamat;
        $update->contact_person = $request->contact_person;
        $update->nomor_mou = $request->nomor_mou;
        $update->tanggal_perjanjian_awal = $request->tanggal_perjanjian_awal;
        $update->tanggal_perjanjian_akhir = $request->tanggal_perjanjian_akhir;
        $update->save();
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
        $delete = Dealer::findorfail($id);
        $delete->delete();
        return response('Data berhasil dihapus', 204);
    }
}
