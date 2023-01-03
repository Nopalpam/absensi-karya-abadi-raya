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
        <div class="box-tools">
            <button onclick="addForm(`{{ route('sik.store') }}`)" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
        </div>
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
@includeIf('sik.form')
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

        $('#form-sik').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('#form-sik').attr('action'),
                    type: $('#form-sik').attr('method'),
                    data: new FormData($('#form-sik')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                    .done((response) => {
                        console.log(response);
                        $('#modal-sik').modal('hide');
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
        $('#modal-sik').modal('show');
        $('#modal-sik .modal-title').text('Buat SIK');
        $('#modal-sik form').attr('action', url);
        $('#modal-sik [name=_method]').val('post');
        $('#modal-sik [name=nama]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit SIK');
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

    function add_jadwal(id) {
        $('#modal-jadwal [name=id_area]').val(id);
        url = `{{ route('jadwal.store') }}`;
        $('#modal-jadwal').modal('show');
        $('#modal-jadwal .modal-title').text('Tambah Member');
        $('#modal-jadwal form').attr('action', url);
        $('#modal-jadwal [name=_method]').val('post');
        $('#modal-jadwal form')[0].reset();
        $('#modal-jadwal [name=nama]').focus();
    }
</script>
@endpush