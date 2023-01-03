@extends('layouts.master')

@section('title')
List Jenis Pekerjaan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">List Jenis Pekerjaan</li>
@endsection
@php
    $nip = isset($_GET['nip'])?$_GET['nip'] : null;
@endphp
@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">List Jenis Pekerjaan</h3>
        <div class="box-tools">
            <button onclick="addForm(`{{ route('jenis_pekerjaan.store') }}`)" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-stiped table-bordered">
            <thead>
                <th width="5%">No</th>
                <th>nama_pekerjaan</th>
                <th>harga</th>
                <th>brand</th>
                <th>Aksi</th>
            </thead>
        </table>
    </div>
</div>
@endsection
@includeIf('jenis_pekerjaan.form')
@push('scripts')
<script>
let table;
$(function () {
    table = $('.table').DataTable({
        processing: true,
        autoWidth: false,
        ajax: {
            url: `{{ route('jenis_pekerjaan.data') }}`,
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'nama_pekerjaan'},
            {data: 'harga'},
            {data: 'brand',
                render: function(data, type, row) {
                    if(data == 'lainnya') {
                        return row['brand_lainnya'];
                    }else {
                        return data;
                    }
                }
            },
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
    $('#modal-form .modal-title').text('Edit Jenis Pekerjaan');
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('put');
    $('#modal-form form')[0].reset();
    $('#modal-form [name=prefix]').focus();

    $.get(url)
        .done((response) => {
            $('#modal-form [name=nama_pekerjaan]').val(response.nama_pekerjaan);
            $('#modal-form [name=harga]').val(response.harga);
            $('#modal-form [name=brand]').val(response.brand);
            if(response.brand == 'lainnya'){
                $('#brand_lainnya').removeClass("d-none");
                $('#brand_lainnya').addClass("d-block");
            $('#modal-form [name=brand_lainnya]').val(response.brand_lainnya);
            } else {
                $('#brand_lainnya').removeClass("d-block");
                $('#brand_lainnya').addClass("d-none");
            }
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
