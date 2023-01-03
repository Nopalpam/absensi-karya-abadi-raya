@extends('layouts.master')

@section('title')
List Invoice
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.dataTables.min.css">
<style>
.text-successnew{
    color: #1ac91d
}
.text-warningnew{
    color: #f9b63c
}
.font-weight-bold{
    font-weight: bold
}
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="active">List Invoice</li>
@endsection
@php
    $nip = isset($_GET['nip'])?$_GET['nip'] : null;
@endphp
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">List Invoice</h3>
        <div class="box-tools">
            {{-- <a href="{{ route('invoice.view_pdf') }}" target="_blank" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Lihat Contoh PDF</a> --}}
            <button class="btn btn-success btn-xs btn-flat getcheckboxdata"><i class="fa fa-plus-circle"></i> Convert to Invoice</button>
        </div>
    </div>
    <div style="padding: 10px;">
        <p>Filter by Nama Customer</p>
        <select name="" id="customerlist" class="form-control" style="width: auto">
            <option value="">All</option>
            @foreach ($getcustomer as $dgetcustomer)
            <option value="{{$dgetcustomer->nama_customer}}">{{$dgetcustomer->nama_customer}}</option>
            @endforeach
        </select>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-stiped table-bordered">
                <thead>
                    <th width="5%">No</th>
                    <th>Status</th>
                    <th>No SPK</th>
                    <th>Work Order Number</th>
                    <th>Tanggal Service</th>
                    <th>Nama Customer</th>
                    <th>Nama Teknisi</th>
                    <th>Aksi</th>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@includeIf('invoice.form')
@push('scripts')
<script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>
<script>
let table;
$(function () {
    table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
            url: `{{ route('invoice.data') }}`,
        },
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'status',
                render: function(data, type, row) {
                    if(data == '1') {
                        return '<p class="text-successnew font-weight-bold">Sudah SelesaI</p>';
                    }else {
                        return '<p class="text-warningnew font-weight-bold">Sedang dalam pekerjaan</p>';
                    }
                }
            },
            {data: 'no_spk'},
            {data: 'work_order_number'},
            {data: 'tanggal_service'},
            {data: 'nama_customer'},
            {data: 'nama_teknisi'},
            {data: 'aksi', searchable: false, sortable: false},
        ],
        select: {
            style:    'multi',
            selector: 'td:first-child'
        }
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

$('#customerlist').on('change', function() {
    var oTable = $('.table').DataTable();
    oTable.search(this.value).draw();
});

$(".getcheckboxdata").click(function(e){
    var oTable = $('.table').DataTable();

    var rows = oTable.rows( { selected: true } ).count();
    var selected_rows = oTable.rows( {selected: true} ).data(0);
    var selected_ids = [];
    for (i=0; i < rows; i++) {
        var reduced_object = selected_rows[i]['id_transaksi_service'];
        selected_ids.push(reduced_object);
    };

    // console.log(selected_ids);

    if(rows > 0){
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Cetak Invoice');
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('post');
    $('#modal-form form')[0].reset();
    $('#modal-form [name=prefix]').focus();
    $('#modal-form [name=id_transaksiservice]').val(selected_ids);
    } else {
        alert('Silahkan ceklis data yang ingin di pilih!');
    }

});

function getsingledata(id_transaksi_service) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Cetak Invoice');
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('post');
    $('#modal-form form')[0].reset();
    $('#modal-form [name=prefix]').focus();
    $('#modal-form [name=id_transaksiservice]').val(id_transaksi_service);

    // console.log(id_transaksi_service);

    // $.get(url)
    //     .done((response) => {
    //         $('#modal-form [name=id_transaksiservice]').val(response.id_transaksi_service);
    //         console.log(response.id_transaksi_service);
    //     })
    //     .fail((errors) => {
    //         alert('Tidak dapat menampilkan data');
    //         return;
    //     });
}

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
    $('#modal-form .modal-title').text('Edit invoice');
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('put');
    $('#modal-form form')[0].reset();
    $('#modal-form [name=prefix]').focus();

    $.get(url)
        .done((response) => {
            $('#modal-form [name=nama_teknisi]').val(response.nama_teknisi);
            $('#modal-form [name=work_order_number]').val(response.work_order_number);
            $('#modal-form [name=tanggal_service]').val(response.tanggal_service);
            $('#modal-form [name=nama_customer]').val(response.nama_customer);
            $('#modal-form [name=plat_nomor_mobil]').val(response.plat_nomor_mobil);
            $('#modal-form [name=models]').val(response.models);
            $('#modal-form [name=vin]').val(response.vin);
            // $('#modal-form [name=jenis_pekerjaan]').val(response.jenis_pekerjaan);
            $('#modal-form [name=pekerjaan_lainnya]').val(response.pekerjaan_lainnya);
            $('#modal-form [name=harga]').val(response.harga);
            var str = response.jenis_pekerjaan;
            var temp = new Array();
            temp = str.split(",");
            var tempn = temp.map(Number)
            $("#jenis_pekerjaan").val(tempn).change();
        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
}

function viewForm(url) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit invoice');
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('put');
    $('#modal-form form')[0].reset();
    $('#modal-form [name=prefix]').focus();
    $('#modal-form .btnsubmit').hide();

    $.get(url)
        .done((response) => {
            $('#modal-form [name=nama_teknisi]').val(response.nama_teknisi);
            $('#modal-form [name=work_order_number]').val(response.work_order_number).attr("disabled", true);
            $('#modal-form [name=tanggal_service]').val(response.tanggal_service).attr("disabled", true);
            $('#modal-form [name=nama_customer]').val(response.nama_customer).attr("disabled", true);
            $('#modal-form [name=plat_nomor_mobil]').val(response.plat_nomor_mobil).attr("disabled", true);
            $('#modal-form [name=models]').val(response.models).attr("disabled", true);
            $('#modal-form [name=vin]').val(response.vin).attr("disabled", true);
            $('#modal-form [name=pekerjaan_lainnya]').val(response.pekerjaan_lainnya).attr("disabled", true);
            $('#modal-form [name=harga]').val(response.harga).attr("disabled", true);
            $('#jenis_pekerjaan').attr("disabled", true);
            var str = response.jenis_pekerjaan;
            var temp = new Array();
            temp = str.split(",");
            var tempn = temp.map(Number)
            $("#jenis_pekerjaan").val(tempn).change();
        })
        .fail((errors) => {
            alert('Tidak dapat menampilkan data');
            return;
        });
}
// $('#modal-form').on('hidden.bs.modal', function () {
//     $('#modal-form [name=work_order_number]').attr("disabled", false);
// });

function finishForm(url) {
    if (confirm('Yakin ingin finish data terpilih?')) {
        $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'post'
            })
            .done((response) => {
                table.ajax.reload();
            })
            .fail((errors) => {
                alert('Tidak dapat edit data');
                return;
            });
    }
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
