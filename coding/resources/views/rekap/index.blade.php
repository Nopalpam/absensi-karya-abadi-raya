@extends('layouts.master')

@section('title')
Rekap Absen
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Rekap Absen</li>
@endsection
@php 
    $nip = isset($_GET['nip'])?$_GET['nip'] : null; 
@endphp
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Rekap Absen</h3>
        <div class="box-tools">
            <button onclick="downloadForm(`{{ route('rekap_absen.download') }}`)" class="btn btn-success btn-flat"><i class="fa fa-download"></i> Download</button>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-stiped table-bordered">
            <thead>
                <th width="5%">No</th>
                <th>Karyawan</th>
                <th>Tanggal</th>
                <th>Status Absen</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Telat</th>
                <th>Hadir</th>
                <th>Sakit</th>
                <th>Ijin</th>
                <th>Cuti</th>
            </thead>
        </table>
    </div>
</div>
@endsection
@includeIf('rekap.form')
@push('scripts')
<script>
let table;
$(function () {
    table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
            url: `{{ route('rekap_absen.data') }}`,
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'nama_karyawan'},
            {data: 'tanggal'},
            {data: 'status_absen'},
            {data: 'jam_masuk'},
            {data: 'jam_pulang'},
            {data: 'telat'},
            {data: 'hadir'},
            {data: 'sakit'},
            {data: 'ijin'},
            {data: 'cuti'}
        ]
    });
});

function downloadForm(url) {
    $('#modal-rekap').modal('show');
    $('#modal-rekap .modal-title').text('Dewnload Data Rekap Absensi');
    $('#modal-rekap form').attr('action', url);
    $('#modal-rekap [name=_method]').val('post');
    $('#modal-rekap form')[0].reset();
    $('#modal-rekap [name=nama]').focus();
}
</script>
@endpush