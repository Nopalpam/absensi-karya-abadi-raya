@extends('layouts.master')

@section('title')
List Settlement
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
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
div.dt-buttons{
    margin-right: 20px;
}
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="active">List Settlement</li>
@endsection
@php
    $nip = isset($_GET['nip'])?$_GET['nip'] : null;
@endphp
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">List Settlement</h3>
        <div class="box-tools">
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-stiped table-bordered">
                <thead>
                    <th width="5%">No</th>
                    <th>No Invoice</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>TOP</th>
                    <th>Harga Total</th>
                    <th>Aksi</th>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@includeIf('settlement.form')
@push('scripts')
<script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js" type="text/javascript"></script>
<script>
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }
</script>
<script>
let table;
$(function () {
    table = $('.table').DataTable({
        dom: "Blfrtip",
        buttons: [
            // {
            //     text: 'Export CSV',
            //     extend: 'csvHtml5',
            //     title: 'Settlement_CSV',
            //     exportOptions: {
            //         columns: [ 1, 2, 3, 4, 5, 6 ]
            //     }
            // },
            {
                text: 'Export Excel',
                extend: 'excelHtml5',
                title: 'Settlement_Excel',
                filename: function () {
                    var d = new Date();
                    var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();
                    return strDate + '_Settlement_Excel';
                },
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
        ],
        processing: true,
        autoWidth: false,
        ajax: {
            url: `{{ route('settlement.data') }}`,
        },
        columnDefs: [ {
            orderable: false,
            // className: 'select-checkbox',
            targets:   0
        } ],
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'id_invoice'},
            {data: 'status',
                render: function(data, type, row) {
                    if(data == 'UNPAID') {
                        return '<p class="text-warningnew font-weight-bold">UNPAID</p>';
                    }else {
                        return '<p class="text-successnew font-weight-bold">PAID</p>';
                    }
                }
            },
            {data: 'created_at',
                render: function(data, type, row) {
                    return moment(data).format("MM-DD-YYYY HH:mm");
                }
            },
            {data: 'updated_at',
                render: function(data, type, row) {
                    return moment(data).format("MM-DD-YYYY HH:mm");
                }
            },
            {data: 'top', searchable: false, sortable: false},
            {data: 'harga_total',
                render: function(data, type, row) {
                    return formatRupiah(data, "Rp. ");
                }
            },
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
    if (confirm('Yakin ingin cetak data terpilih?')) {
        $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'post'
            })
            .done((response) => {
                table.ajax.reload();
            })
            .fail((errors) => {
                alert('Tidak dapat cetak data');
                return;
            });
    }
}

function paidform(url) {
    if (confirm('Yakin ingin ubah status terpilih menjadi PAID?')) {
        $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'post'
            })
            .done((response) => {
                table.ajax.reload();
            })
            .fail((errors) => {
                alert('Tidak dapat update data');
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
