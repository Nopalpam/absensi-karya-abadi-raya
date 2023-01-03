<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Tb_jadwal_area;
use App\Models\User;
use App\Models\Area;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $jadwal = Tb_jadwal_area::with(['user', 'area'])->get()->keyBy('id_user');
        return datatables()
            ->of($jadwal)
            ->addIndexColumn()
            ->addColumn('nama_user', function ($jadwal) {
                return $jadwal->user->name;
            })
            ->addColumn('lokasi', function ($jadwal) {
                $area = $this->data_area($jadwal->id_user);
                return $area;
            })
            ->addColumn('aksi', function ($jadwal) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="deleteData(`'. route('jadwal.destroy', $jadwal->id_user) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'lokasi', 'nama_user'])
            ->make(true);
    }

    public function index()
    {
        // index jadwal //
        $members = User::isNotAdmin()->orderBy('id', 'desc')->get();
        $areas = Area::orderBy('id', 'desc')->get();
        return view('jadwal.index', compact('members', 'areas'));
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
        // store jadwal //
        // dd($request->all());
        if(count($request->id_area) > 0){
            foreach ($request->id_area as $key => $value) {
                # code...
                $store = new Tb_jadwal_area();
                $store->id_user = $request->member;
                $store->id_area = $value;
                $store->save();
            }
            return response()->json(200);
        }else{
            return response()->json(201);
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
        $show = Tb_jadwal_area::with(['user', 'area'])->find($id);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_user)
    {
        // delete data //
        $data = Tb_jadwal_area::where('id_user', $id_user);
        $data->delete();
        return response()->json('Berhasil dihapus', 200);
    }

    public function karyawan_area()
    {
        $area = null;
        $jadwals = null;
        $jadwals = Tb_jadwal_area::with(['user', 'area'])->where('id_user', auth()->user()->id)->first();
        if($jadwals){
            $area = $this->data_area(auth()->user()->id);
        }
        return view('jadwal.karyawan_area', compact('jadwals', 'area'));
    }

    private function data_area($id_user)
    {
        $datas = Tb_jadwal_area::with('area')->where('id_user', $id_user)->get();
        foreach($datas as $data){
            $datas2[] = $data->area->nama_area;
        }
        $areas = implode(", ",$datas2);
        return $areas;
    }
}
