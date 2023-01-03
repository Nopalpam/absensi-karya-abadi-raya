<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use App\Models\Area;
use App\Models\Tb_jadwal_area;

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
        $absen_hari_ini = Absensi::where('nip', auth()->user()->id)->where('tanggal', $date_now)->first();
        if($absen_hari_ini){ 
            $jam_masuk = $absen_hari_ini->check_in;
            $jam_pulang = $absen_hari_ini->check_out;
        }else{ 
            $jam_masuk = false; 
            $jam_pulang = false; 
        }
        return view('karyawan.absensi_in', compact('data', 'jam_masuk', 'jam_pulang', 'absen_hari_ini'));
    }

    public function check_out()
    {
        $data = User::find(auth()->user()->id);
        $date_now = Carbon::now()->format('Y-m-d');
        $absen_hari_ini = Absensi::where('nip', auth()->user()->id)->where('tanggal', $date_now)->latest('id')->first();
        $jam_masuk = Absensi::where('nip', auth()->user()->id)->where('tanggal', $date_now)->first()->check_in;
        $jam_pulang = Absensi::where('nip', auth()->user()->id)->where('tanggal', $date_now)->latest('id')->first()->check_out;
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

    public function store_in(Request $request)
    {
        // store data absen masuk //
        // dd($request->all());
        $jadwal = Tb_jadwal_area::with('area')->where('id_user', auth()->user()->id)->latest('id')->first();
        $check_jadwal = Carbon::now()->between($jadwal->tanggal_start,$jadwal->tanggal_end);
        
        $lat_code = null;
        $lang_code = null;
        $status = 'offline';
        $date = Carbon::now()->format('Y-m-d');        
        $time = Carbon::now()->format('G:i:s');
        // upload foto //
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $etc  = $file->getClientOriginalExtension();
            $foto = auth()->user()->id."_".$date.'.'.$etc;
            $file->move("images/absen_online", $foto);
        }else{
            $foto = "-";
        }
        if(isset($request->location)){
            $lokasi = explode(", ", $request->location);
            $lat_code = $lokasi[0];
            $lang_code = $lokasi[1];
            if($check_jadwal){
                $jarak = $this->distance($jadwal->area->lat_area, $jadwal->area->lang_area, $lat_code, $lang_code);
                if($jarak < 1)
                {
                    $status = 'online';
                }

            }
        }
        $store = new Absensi();
        $store->lat_code = $lat_code;
        $store->lang_code = $lang_code;
        $store->status_absen = $status;
        $store->nip = auth()->user()->id;
        $store->tanggal = Carbon::now()->format('Y-m-d');
        $store->gambar = 'images/absen_online/' . $foto;
        if($request->absensi == "check_in"){
            $store->check_in = Carbon::now();
        }
        $store->save();
        return redirect()->back();
    }

    public function store_out(Request $request, $id)
    {
        // store data absen masuk //
        // dd($request->all());
        $jadwal = Tb_jadwal_area::with('area')->where('id_user', auth()->user()->id)->latest('id')->first();
        $check_jadwal = Carbon::now()->between($jadwal->tanggal_start,$jadwal->tanggal_end);
        
        $lat_code = null;
        $lang_code = null;
        $status = 'offline';
        $date = Carbon::now()->format('Y-m-d');        
        $time = Carbon::now()->format('G:i:s');
        // upload foto //
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $etc  = $file->getClientOriginalExtension();
            $foto = auth()->user()->id."_".$date.'.'.$etc;
            $file->move("images/absen_online", $foto);
        }else{
            $foto = "-";
        }
        if(isset($request->location)){
            $lokasi = explode(", ", $request->location);
            $lat_code = $lokasi[0];
            $lang_code = $lokasi[1];
            if($check_jadwal){
                $jarak = $this->distance($jadwal->area->lat_area, $jadwal->area->lang_area, $lat_code, $lang_code);
                if($jarak < 1)
                {
                    $status = 'online';
                }

            }
        }
        $store = new Absensi();
        $store->lat_code = $lat_code;
        $store->lang_code = $lang_code;
        $store->status_absen = $status;
        $store->nip = auth()->user()->id;
        $store->tanggal = Carbon::now()->format('Y-m-d');
        $store->gambar = 'images/absen_online/' . $foto;
        if($request->absensi == "check_out"){
            $store->check_in = Carbon::now();
        }
        $store->save();
        return redirect()->back();
    }
    
    public function store(Request $request)
    {
        // store data absen //
        // dd($request->all());
        $jadwal = Tb_jadwal_area::with('area')->where('id_user', auth()->user()->id)->latest('id')->first();
        $check_jadwal = Carbon::now()->between($jadwal->tanggal_start,$jadwal->tanggal_end);
        
        $lat_code = null;
        $lang_code = null;
        $status = 'offline';
        $date = Carbon::now()->format('Y-m-d');        
        $time = Carbon::now()->format('G:i:s');
        // upload foto //
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $etc  = $file->getClientOriginalExtension();
            $foto = auth()->user()->id."_".$date.'.'.$etc;
            $file->move("images/absen_online", $foto);
        }else{
            $foto = "-";
        }
        if(isset($request->location)){
            $lokasi = explode(", ", $request->location);
            $lat_code = $lokasi[0];
            $lang_code = $lokasi[1];
            if($check_jadwal){
                $jarak = $this->distance($jadwal->area->lat_area, $jadwal->area->lang_area, $lat_code, $lang_code);
                if($jarak < 1)
                {
                    $status = 'online';
                }

            }
        }
        $store = new Absensi();
        $store->lat_code = $lat_code;
        $store->lang_code = $lang_code;
        $store->status_absen = $status;
        $store->nip = auth()->user()->id;
        $store->tanggal = Carbon::now()->format('Y-m-d');
        $store->gambar = 'images/absen_online/' . $foto;
        if($request->absensi == "check_in"){
            $store->check_in = Carbon::now();
        }
        if($request->absensi == "check_out"){
            $store->check_out = Carbon::now();
        }
        $store->save();
        return redirect()->back();
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
        }
        else {
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
}
