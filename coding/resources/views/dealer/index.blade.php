@extends('layouts.master')

@section('title')
List Customer
@endsection

@section('breadcrumb')
    @parent
    <li class="active">List Customer</li>
@endsection
@php
    $nip = isset($_GET['nip'])?$_GET['nip'] : null;
@endphp
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">List Customer</h3>
        <div class="box-tools">
            <button onclick="addForm(`{{ route('dealer.store') }}`)" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-stiped table-bordered">
            <thead>
                <th width="5%">No</th>
                <th>Nama customer</th>
                <th>Brand customer</th>
                <th>Alamat</th>
                <th>Contact person</th>
                <th>Nomor MOU</th>
                <th>Tanggal perjanjian awal</th>
                <th>Tanggal perjanjian Akhir</th>
                <th>Aksi</th>
            </thead>
        </table>
    </div>
</div>
@endsection
@includeIf('dealer.form')
@push('scripts')
<script>
let table;
$(function () {
    table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
            url: `{{ route('dealer.data') }}`,
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'nama_customer'},
            {data: 'brand_customer'},
            {data: 'alamat'},
            {data: 'contact_person'},
            {data: 'nomor_mou'},
            {data: 'tanggal_perjanjian_awal'},
            {data: 'tanggal_perjanjian_akhir'},
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
    $('#modal-form .modal-title').text('Edit Dealer');
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('put');
    $('#modal-form form')[0].reset();
    $('#modal-form [name=prefix]').focus();

    $.get(url)
        .done((response) => {
            $('#modal-form [name=nama_customer]').val(response.nama_customer);
            $('#modal-form [name=brand_customer]').val(response.brand_customer);
            $('#modal-form [name=alamat]').val(response.alamat);
            $('#modal-form [name=contact_person]').val(response.contact_person);
            $('#modal-form [name=nomor_mou]').val(response.nomor_mou);
            $('#modal-form [name=tanggal_perjanjian_awal]').val(response.tanggal_perjanjian_awal);
            $('#modal-form [name=tanggal_perjanjian_akhir]').val(response.tanggal_perjanjian_akhir);
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
