@extends('layouts.master')

@section('title')
    Jadwal Area Karyawan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Jadwal Area Karyawan</li>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Jadwal Area Karyawan</h3>
        <div class="box-tools">
            <button onclick="addForm(`{{ route('jadwal.store') }}`)" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-stiped table-bordered">
            <thead>
                <th width="5%">No</th>
                <th>Nama User</th>
                <th>Nama Area</th>
                <th width="15%"><i class="fa fa-cog"></i></th>
            </thead>
        </table>
    </div>
</div>
@includeIf('jadwal.form_jadwal')
@endsection
@push('scripts')
<script>
    
    let table;

    $(function () {
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: `{{ route('jadwal.data') }}`,
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_user'},
                {data: 'lokasi'},
                {data: 'aksi', searchable: false, sortable: false},
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

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Jadwal');
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form form')[0].reset();
        $('#modal-form [name=nama]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Jadwal');
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form form')[0].reset();
        $('#modal-form [name=prefix]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_area]').val(response.nama_area);
                $('#modal-form [name=lat_area]').val(response.lat_area);
                $('#modal-form [name=lang_area]').val(response.lang_area);
                $('#modal-form [name=map_link]').val(response.map_link);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>
@endpush