<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sik_Karyawan;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;

class SikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        // data sik //
        $sik = Sik_Karyawan::with('user');
        if(auth()->user()->level == 'karyawan'){
            $sik = $sik->where('id_karyawan', auth()->user()->id);
        }
        $sik = $sik->orderBy('id', 'desc')->get();
        return datatables()
            ->of($sik)
            ->addIndexColumn()
            ->addColumn('karyawan', function ($sik) {
                return $sik->user->name ?? "-";
            })
            ->addColumn('link_gambar', function ($sik) {
                return '
                <div class="btn-group">
                    <a target="_blank" href="'.$sik->gambar.'" class="btn btn-xs btn-success btn-flat"><i class="fa fa-eye   "></i></a>
                </div>
                ';
            })
            ->addColumn('aksi', function ($sik) {
                if(auth()->user()->level == 'admin' && !$sik->verified){
                    $act = '
                    <div class="btn-group">
                        <button onclick="verifiedData(`'. url('verifikasi_sik', $sik->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-check"></i></button>
                        <button onclick="rejectData(`'. route('sik.destroy', $sik->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i></button>
                    </div>
                    ';
                }else{
                    $act = "-";
                }
                return $act;
            })
            ->rawColumns(['map_link', 'aksi'])
            ->make(true);
    }
    
    public function index()
    {
        // daftar sik //
        return view('sik.index');
    }

    public function sik_karyawan()
    {
        // daftar sik //
        return view('sik.sik_karyawan');
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
        // store data sik //
        $tanggal = isset($request['tanggal'])?$request['tanggal']:null;
        if(isset($tanggal)){
            $tanggal = str_replace(" ", "", $tanggal);
            $ar_tgl = explode("-", $tanggal);
            $start = Carbon::createFromFormat('d/m/Y', $ar_tgl[0])->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $ar_tgl[1])->endOfDay();
        }
        // upload gambar //
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $etc  = $file->getClientOriginalExtension();
            $gambar = auth()->user()->id."_".date('YmdHis').'.'.$etc;
            $file->move("images/sik", $gambar);
            $gambar = 'images/sik/' . $gambar;
        }else{
            $gambar = "-";
        }
        $store = new Sik_Karyawan();
        $store->id_karyawan = auth()->user()->id;
        $store->tanggal_start = $start;
        $store->tanggal_end = $end;
        $store->sik = $request->sik;
        $store->keterangan = $request->keterangan;
        $store->gambar = $gambar;
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verifikasi_sik($id)
    {
        // verifikasi sik //
        $data = Sik_Karyawan::find($id);
        $periode = getDatesFromRange($data->tanggal_start, $data->tanggal_end);
        foreach($periode as $tanggal){
            $cek_absen = Absensi::where('id_karyawan', $data->id_karyawan)->where('tanggal', $tanggal)->first();
            if(!$cek_absen){
                $store = new Absensi();
                $store->hadir = false;
                $store->status_absen = $data->sik;
                $store->id_karyawan = $data->id_karyawan;
                $store->tanggal = $tanggal;
                $store->gambar = $data->gambar;
                if($data->sik == "sakit"){
                    $store->sakit = true;
                }
                if($data->sik == "ijin"){
                    $store->ijin = true;
                }
                if($data->sik == "cuti"){
                    $store->cuti = true;
                }
                $store->save();
            }
            // save verified //
            $data->verified = true;
            $data->verified_by = auth()->user()->name;
            $data->save();
        }
        return redirect()->back();
    }

    public function cek_sik($id)
    {
        $cek_absen = Absensi::where('id_karyawan', $data->id_karyawan)->where('tanggal', $tanggal)->first();
        dd($cek_absen);
    }
}
