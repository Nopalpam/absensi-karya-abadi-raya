@extends('layouts.master')

@section('title')
    Jadwal
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Jadwal Area</li>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Jadwal Area</h3>
    </div>
    <div class="box-body">
        <table class="table table-stiped table-bordered">
            <thead>
                <th>Nama Karyawan</th>
                <th>Nama Area</th>
            </thead>
            <tr>
                <td>{{ auth()->user()->name }}</td>
                <td>{{ $area }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection