@extends('layouts.master')

@section('title')
List Invoice
@endsection

@push('css')
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/select/1.5.0/css/select.dataTables.min.css"> --}}
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

<style type="text/css">
    table tr td,
    table tr th{
        font-size: 9pt;
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
<div class="text-left" style="margin-bottom: 15px;">
    <a href="{{ route('settlement.index') }}" class="btn btn-primary">Kembali</a>
</div>
    @if(!$data->isEmpty())
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Untuk No Invoice : {{$id}}</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th style="font-size: 16px;">NO SPK</th>
                            <th style="font-size: 16px;">TANGGAL SERVICE</th>
                            <th style="font-size: 16px;">JENIS PEKERJAAN</th>
                            <th style="font-size: 16px;">HARGA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                            $sum_tot_Price_Sum = 0;
                        @endphp
                        @foreach($data as $p)
                        <tr>
                            <td style="font-size: 15px;">{{$p->no_spk}}</td>
                            <td style="font-size: 15px;">{{$p->tanggal_service}}</td>
                            <td style="font-size: 15px;">
                                @foreach (getJPekerjaan($p->jenis_pekerjaan) as $ditem)
                                    {{ $loop->first ? '' : ', ' }}
                                    {{$ditem->nama_pekerjaan}}
                                    @if($loop->last)
                                        @if($p->pekerjaan_lainnya != '-')
                                            , {{ $p->pekerjaan_lainnya }}
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                            <td style="font-size: 15px;">
                                <?php
                                    $sum_tot_Price = 0;
                                 ?>
                                @foreach (getJPekerjaan($p->jenis_pekerjaan) as $ditem)
                                    @php
                                        $sum_tot_Price += removeString($ditem->harga)
                                    @endphp
                                    @if($loop->last)
                                    @php
                                        $sum_tot_Price_total = ((int)$sum_tot_Price  + (int)removeString($p->harga))
                                    @endphp
                                        {{ 'Rp. '.formatRupiah($sum_tot_Price_total) }}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        @php
                        $sum_tot_Price_Sum += $sum_tot_Price_total;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            @php
            $sum_tot_Price_Sum_ppn = $sum_tot_Price_Sum * 0.11;
            @endphp
            <h5 style="text-align:right">Sub Total : {{ 'Rp. '.formatRupiah($sum_tot_Price_Sum) }}</h5>
            <h5 style="text-align:right">PPN : {{ 'Rp. '.formatRupiah($sum_tot_Price_Sum_ppn) }}</h5>
            <hr>
            <h4 style="text-align:right" id="TotalPembayaran">Total Pembayaran : {{ 'Rp. '.formatRupiah($sum_tot_Price_Sum_ppn+$sum_tot_Price_Sum) }}</h4>
        </div>
    </div>
    <div class="text-center">
        <a href="{{ route('settlement.view_pdf_full', $id) }}" target="_blank" class="btn btn-primary">Lihat Invoice</a>
    </div>
    @else
    <hr>
	<center>
        <h5 class="text-align:center;">Data kosong</h5>
	</center>
    @endif

    {{-- <script src="{{ asset('AdminLTE-2/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            alert('test');
            $('#getTotalPembayaran').text('#TotalPembayaran');
        });
    </script> --}}


@endsection
