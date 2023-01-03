<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use App\Models\Area;
use App\Models\Tb_jadwal_area;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function check_in()
    {
        $data = User::find(auth()->user()->id);
        $date_now = Carbon::now()->format('Y-m-d');
        $absen_hari_ini = Absensi::where('id_karyawan', auth()->user()->id)->where('tanggal', $date_now)->first();
        $jam_masuk = Absensi::where('id_karyawan', auth()->user()->id)->where('tanggal', $date_now)->where('check_in', true)->first();
        $jam_pulang = Absensi::where('id_karyawan', auth()->user()->id)->where('tanggal', $date_now)->where('check_out', true)->latest('id')->first();
        return view('karyawan.absensi_in', compact('data', 'jam_masuk', 'jam_pulang', 'absen_hari_ini'));
    }

    public function check_out()
    {
        $data = User::find(auth()->user()->id);
        $date_now = Carbon::now()->format('Y-m-d');
        $absen_hari_ini = Absensi::where('id_karyawan', auth()->user()->id)->where('tanggal', $date_now)->latest('id')->first();
        $jam_masuk = Absensi::where('id_karyawan', auth()->user()->id)->where('tanggal', $date_now)->where('check_in', true)->first();
        $jam_pulang = Absensi::where('id_karyawan', auth()->user()->id)->where('tanggal', $date_now)->where('check_out', true)->latest('id')->first();
        return view('karyawan.absensi_out', compact('data', 'jam_masuk', 'jam_pulang', 'absen_hari_ini'));
    }
    
    
    public function index()
    {
        //
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
        // store data absen //
        // dd($request->all());
        $areas = Tb_jadwal_area::with('area')->where('id_user', auth()->user()->id)->get();
        $lat_code = null;
        $lang_code = null;
        $status = 'offline';
        $date = Carbon::now()->format('Y-m-d');  
        if(isset($request->location)){
            $lokasi = explode(", ", $request->location);
            $lat_code = $lokasi[0];
            $lang_code = $lokasi[1];
        }
        // upload foto //
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $etc  = $file->getClientOriginalExtension();
            $foto = auth()->user()->id."_".$date.'.'.$etc;
            $file->move("images/absen_online", $foto);
        }else{
            $foto = "-";
        }
        $limit = Carbon::parse('08:30:00')->format('H:i:s');
        $now = Carbon::now();
        // store data absesnsi //
        $store = new Absensi();
        $store->lat_code = $lat_code;
        $store->lang_code = $lang_code;
        $store->hadir = true;
        $store->status_absen = $this->status_absen($areas, $lat_code, $lang_code);
        $store->id_karyawan = auth()->user()->id;
        $store->tanggal = $now;
        $store->waktu_check = $now;
        $store->gambar = 'images/absen_online/' . $foto;
        if($request->absensi == "check_in"){
            $store->check_in = 1;
            $msg = 'Record Absen Masuk Berhasil';
        }
        if($request->absensi == "check_out"){
            $store->check_out = 1;
            $msg = 'Record Absen Pulang Berhasil';
        }
        if($now->format('H:i:s') > $limit){
            $store->telat = 1;
        }
        $store->save();
        return redirect()->back()->with(['success' => $msg]);
    }

    public function status_absen($areas, $lat_code, $lang_code)
    {
        if($areas){
            foreach ($areas as $jadwal) {
                $jarak = $this->distance($jadwal->area->lat_area, $jadwal->area->lang_area, $lat_code, $lang_code, "K");
                if($jarak < 1)
                {
                    $result[] = 1;
                }else{
                    $result[] = 0;
                }
            }
            $arr_result = array_sum($result);
            if($arr_result > 0){ $print = "online"; }else{ $print = "offline"; }
            return $print;
        }else{
            return redirect()->back();
        }
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
    
    function distance($lat1, $lon1, $lat2, $lon2, $unit="K") {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }else{
          $theta = $lon1 - $lon2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
          $unit = strtoupper($unit);
      
          if ($unit == "K") {
            return ($miles * 1.609344);
          } else if ($unit == "N") {
            return ($miles * 0.8684);
          } else {
            return $miles;
          }
        }
      }

    public function rekap_karyawan()
    {
        // index laporan //
        $data = User::find(auth()->user()->id);
        return view('karyawan.rekap_absen', compact('data'));
    }

    public function data_absen_karyawan()
    {
        // data absensi karyawan //
        $absensi = $query = DB::table('absensi as a')
        ->join('users as u','u.id','=','a.id_karyawan')
        ->select(DB::raw('a.id, u.name as nama_karyawan, min(a.waktu_check) as jam_masuk,max(a.waktu_check) as jam_pulang, a.tanggal, a.status_absen, a.hadir, a.telat, a.sakit, a.ijin, a.cuti'))
        ->where('a.id_karyawan', auth()->user()->id)
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

    public function absensi_karyawan()
    {
        // show data absesn karyawan //
        return view('karyawan.data_absensi');
    }
}
