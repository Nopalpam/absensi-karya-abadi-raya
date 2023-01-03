<!DOCTYPE html>
<html>
<head>
	<title>Invoice PDF</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>

	<center style="margin-bottom:20px;">
		<h5>Data untuk Nomor Invoice : {{$id}}</h5>
        <h1 id="getTotalPembayaran"></h1>
	</center>

    @if(!$data->isEmpty())
    <h6>List invoice :</h6>
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
    @php
    $sum_tot_Price_Sum_ppn = $sum_tot_Price_Sum * 0.11;
    @endphp
    <h6 style="text-align:right">Sub Total : {{ 'Rp. '.formatRupiah($sum_tot_Price_Sum) }}</h6>
    <h6 style="text-align:right">PPN : {{ 'Rp. '.formatRupiah($sum_tot_Price_Sum_ppn) }}</h6>
    <hr>
    <h4 style="text-align:right" id="TotalPembayaran">Total Pembayaran : {{ 'Rp. '.formatRupiah($sum_tot_Price_Sum_ppn+$sum_tot_Price_Sum_ppn) }}</h4>
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

</body>
</html>
