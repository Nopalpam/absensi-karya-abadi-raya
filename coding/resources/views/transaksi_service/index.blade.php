@extends('layouts.master')

@section('title')
List Transaksi Service
@endsection

@push('css')
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
    <li class="active">List Transaksi Service</li>
@endsection
@php
    $nip = isset($_GET['nip'])?$_GET['nip'] : null;
@endphp
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">List Transaksi Service</h3>
        {{-- @php
		$getbrand = '';
        if(DB::table('tb_jenis_pekerjaan')->select('brand_lainnya')->where('id_jenis_pekerjaan', '=', '1')->value('brand_lainnya') != null){
		$getbrand = DB::table('tb_jenis_pekerjaan')->select('brand_lainnya')->where('id_jenis_pekerjaan', '=', '1')->value('brand_lainnya');
        } else{
        $getbrand = DB::table('tb_jenis_pekerjaan')->select('brand')->where('id_jenis_pekerjaan', '=', '1')->value('brand');
        }
        @endphp
        <h1>{{$getbrand}}</h1> --}}
        <div class="box-tools">
            @if (auth()->user()->level == 'karyawan')
            <button onclick="addForm(`{{ route('transaksi_service.store') }}`)" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
            @endif
        </div>
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
@includeIf('transaksi_service.form')
@push('scripts')
<script>
let table;
$(function () {
    table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
            url: `{{ route('transaksi_service.data') }}`,
        },
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
    $('#jenis_pekerjaan').val('').trigger('change');
}

function editForm(url) {
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit transaksi_service');
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
    $('#modal-form .modal-title').text('Edit transaksi_service');
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
$('#modal-form').on('hidden.bs.modal', function () {
    $('#modal-form .btnsubmit').show();
    $('#modal-form [name=work_order_number]').attr("disabled", false);
    $('#modal-form [name=tanggal_service]').attr("disabled", false);
    $('#modal-form [name=nama_customer]').attr("disabled", false);
    $('#modal-form [name=plat_nomor_mobil]').attr("disabled", false);
    $('#modal-form [name=models]').attr("disabled", false);
    $('#modal-form [name=vin]').attr("disabled", false);
    $('#modal-form [name=pekerjaan_lainnya]').attr("disabled", false);
    $('#modal-form [name=harga]').attr("disabled", false);
    $('#jenis_pekerjaan').attr("disabled", false);
});

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
$('#customerlist').on('change', function() {
    var oTable = $('.table').DataTable();
    oTable.search(this.value).draw();
});

var rupiah = document.getElementById("harga");
rupiah.addEventListener("keyup", function(e) {
  // tambahkan 'Rp.' pada saat form di ketik
  // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
  rupiah.value = formatRupiah(this.value, "Rp. ");
});

/* Fungsi formatRupiah */
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
@endpush
