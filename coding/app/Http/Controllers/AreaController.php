<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\User;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        // data area
        $area = Area::orderBy('id', 'desc')->get();
        return datatables()
            ->of($area)
            ->addIndexColumn()
            ->addColumn('map_link', function ($area) {
                return '
                <div class="btn-group">
                    <a target="_blank" href="'.$area->map_link.'" class="btn btn-xs btn-success btn-flat"><i class="fa fa-eye   "></i></a>
                </div>
                ';
            })
            ->addColumn('aksi', function ($area) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('area.update', $area->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('area.destroy', $area->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['map_link', 'aksi'])
            ->make(true);
    }

    public function index()
    {
        // tampilkan view index //
        $members = User::isNotAdmin()->where('deleted', false)->orderBy('id', 'desc')->get();
        return view('area.index', compact('members'));
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
        // store data area //
        $store = new Area();
        $store->nama_area = $request->nama_area;
        $store->lat_area = $request->lat_area;
        $store->lang_area = $request->lang_area;
        $store->map_link = $request->map_link;
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
        $show = Area::find($id);
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
        // update data area //
        $update = Area::find($id);
        $update->nama_area = $request->nama_area;
        $update->lat_area = $request->lat_area;
        $update->lang_area = $request->lang_area;
        $update->map_link = $request->map_link;
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
        $delete = Satuan::findorfail($id);
        $delete->delete();
        return response('Data berhasil dihapus', 204);
    }
}
