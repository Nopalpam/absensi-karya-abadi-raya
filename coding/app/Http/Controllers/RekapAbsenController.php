<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportAbsensi;

class RekapAbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        // data rekap absesnsi //
        $absensi = $query = DB::table('absensi as a')
        ->join('users as u','u.id','=','a.id_karyawan')
        ->select(DB::raw('a.id, u.name as nama_karyawan, min(a.waktu_check) as jam_masuk,max(a.waktu_check) as jam_pulang,a.tanggal, a.status_absen, a.hadir, a.telat, a.sakit, a.ijin, a.cuti'))
        ->groupBy('a.tanggal', 'a.id_karyawan')
        ->orderby('a.tanggal', 'desc')
        ->get();
        return datatables()
        ->of($absensi)
        ->addIndexColumn()
        ->editColumn('jam_masuk', function ($absensi) {
            return $absensi->jam_masuk ?? "-"; 
        })
        ->editColumn('jam_pulang', function ($absensi) {
            return $absensi->jam_pulang ?? "-"; 
        })
        ->make(true);
    }

    public function data_bulanan()
    {
        // data rekap absesnsi //
    }

    public function index()
    {
        // index laporan //
        $karyawan = User::where('level', 'karyawan')->orderby('name', 'ASC')->get();
        return view('rekap.index', compact('karyawan'));
    }

    public function index2(Request $request)
    {
        // index laporan //
        $nip = $request['nip'];
        $karyawans = User::where('level', 'karyawan')->orderby('name', 'ASC')->get();
        $datas = User::where('level', 'karyawan');
        if($nip){
            $datas = $datas->where('nip', $nip);
        }
        $datas = $datas->orderBy('name', 'ASC')->paginate();
        return view('rekap.index2', compact('datas'));
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
        //
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

    public function download(Request $request)
    {
        // export data //
        $tanggal = isset($request['tanggal'])?$request['tanggal']:null;
        $nip = $request->nip;
        if(isset($tanggal)){
            $tanggal = str_replace(" ", "", $tanggal);
            $ar_tgl = explode("-", $tanggal);
            $start = Carbon::createFromFormat('d/m/Y', $ar_tgl[0])->startOfDay();
            $end = Carbon::createFromFormat('d/m/Y', $ar_tgl[1])->endOfDay();
        }
        $name_periode = 'Rekap_absen ('.substr($start,0,-9).'-'.substr($end,0,-9).').xlsx';
        return Excel::download(new ExportAbsensi($start, $end, $nip), $name_periode);
    }

    // public function absensi_tahun_ini($id_user)
    // {
    //     $year = Carbon::now()->year;
    //     $month = Carbon::now()->month;
    //     if(!empty($id_user))
    //     {
    //         for($i = 1; $i <= $month; $i++)
    //         {
    //             $result[] = DB::table('absensi as a')
    //             ->join('users as u','u.id','=','a.id_karyawan')
    //             ->select(DB::raw('a.id, u.name as nama_karyawan, min(a.waktu_check) as jam_masuk,max(a.waktu_check) as jam_pulang,a.tanggal, a.status_absen, sum(a.hadir), a.sakit, a.ijin, a.cuti'))
    //             ->where('a.id_karyawan', $id_user)->whereMonth('a.tanggal', $i)->whereYear('a.tanggal', $year)
    //             ->groupBy('a.id_karyawan', 'a.tanggal')
    //             ->get();
    //         }
    //     }else{
    //         $result = null;
    //     }
    //     return $result;
    // }
}
