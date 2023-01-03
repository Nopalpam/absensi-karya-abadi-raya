@extends('layouts.master')

@section('title')
Data Absensi
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Data Absensi</li>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Data Absensi</h3>
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
@push('scripts')
<script>
let table;
$(function () {
    table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
            url: `{{ route('data_absen_karyawan') }}`,
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

    $('#modal-form').validator().on('submit', function (e) {
        if (! e.preventDefault()) {
            $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                .done((response) => {
                    console.log(response);
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
        }
    });
});
</script>
@endpush