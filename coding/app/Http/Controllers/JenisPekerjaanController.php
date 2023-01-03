<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use App\Models\JenisPekerjaan;
use Carbon\Carbon;
use Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportAbsensi;

class JenisPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        // data jenis_pekerjaan absesnsi //
        $jenis_pekerjaan = JenisPekerjaan::orderby('id_jenis_pekerjaan', 'desc')
        ->get();
        return datatables()
        ->of($jenis_pekerjaan)
        ->addIndexColumn()
        ->addColumn('aksi', function ($jenis_pekerjaan) {
            return '
            <div class="btn-group">
                <button onclick="editForm(`'. route('jenis_pekerjaan.update', $jenis_pekerjaan->id_jenis_pekerjaan) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`'. route('jenis_pekerjaan.destroy', $jenis_pekerjaan->id_jenis_pekerjaan) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
            </div>
            ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function data_bulanan()
    {
        // data jenis_pekerjaan absesnsi //
    }

    public function index()
    {
        // index laporan //
        $karyawan = User::where('level', 'karyawan')->orderby('name', 'ASC')->get();
        return view('jenis_pekerjaan.index', compact('karyawan'));
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
        // store jenis_pekerjaan //
        // $store = new JenisPekerjaan();
        $requestbrand_lainnya = '';
        if($request->brand == 'lainnya'){
            $requestbrand_lainnya = $request->brand_lainnya;
        }
        $store = new JenisPekerjaan();
        $store->nama_pekerjaan = $request->nama_pekerjaan;
        $store->harga = $request->harga;
        $store->brand = $request->brand;
        $store->brand_lainnya = $requestbrand_lainnya;
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
        $show = JenisPekerjaan::find($id);
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
        // update data jenis_pekerjaan //
        $requestbrand_lainnya = '';
        if($request->brand == 'lainnya'){
            $requestbrand_lainnya = $request->brand_lainnya;
        }
        $update = JenisPekerjaan::find($id);
        $update->nama_pekerjaan = $request->nama_pekerjaan;
        $update->harga = $request->harga;
        $update->brand = $request->brand;
        $update->brand_lainnya = $requestbrand_lainnya;
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
        $delete = JenisPekerjaan::findorfail($id);
        $delete->delete();
        return response('Data berhasil dihapus', 204);
    }
}
