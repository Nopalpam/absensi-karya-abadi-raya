<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satuan;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        // data satuan //
        $satuan = Satuan::where('deleted_at', null)->where('bisnis_id', auth()->user()->bisnis_id)->orderBy('id')->get();
        return datatables()
            ->of($satuan)
            ->addIndexColumn()
            ->addColumn('base_unit', function ($satuan) {
                return $satuan->base_unit ? $kategori->base_unit->name : '-';
            })
            ->addColumn('aksi', function ($satuan) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('satuan.update', $satuan->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('satuan.destroy', $satuan->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function index()
    {
        // tampilkan view index //
        return view('satuan.index');
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
        // store data satuan //
        $store = new Satuan();
        $store->bisnis_id = auth()->user()->bisnis_id;
        $store->actual_name = $request->actual_name;
        $store->short_name = $request->short_name;
        $store->created_by = auth()->user()->id;
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
        $show = Satuan::find($id);
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
        // edit data satuan //
        $update = Satuan::find($id);
        $update->actual_name = $request->actual_name;
        $update->short_name = $request->short_name;
        $update->update();
        return response()->json('Data berhasil disimpan', 200);
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
