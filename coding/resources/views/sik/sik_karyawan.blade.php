@extends('layouts.master')

@section('title')
    SIK Karyawan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">SIK Karyawan</li>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar SIK Karyawan</h3>
    </div>
    <div class="box-body">
        <table class="table table-stiped table-bordered">
            <thead>
                <th width="5%">No.</th>
                <th>Nama Karyawan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Sakit/ijin/Cuti</th>
                <th>Link File</th>
                <th width="15%"><i class="fa fa-cog"></i></th>
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
                url: `{{ route('sik.data') }}`,
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'karyawan'},
                {data: 'tanggal_start'},
                {data: 'tanggal_end'},
                {data: 'sik'},
                {data: 'gambar'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });
    });

    function verifiedData(url) {
        if (confirm('Yakin ingin verifikasi data terpilih?')) {
            $.get(url)
                .done((response) => {
                    window.location.href = url;
                })
                .fail((errors) => {
                    alert('Data gagal diverifikasi');
                    return;
                });
        }
    }

    function rejectData(url) {
        if (confirm('Yakin ingin tolak data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat tolak data');
                    return;
                });
        }
    }
</script>
@endpush