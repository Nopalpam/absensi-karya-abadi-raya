@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
    .ui-datepicker-calendar {
        display: none;
    }
    </style>
@endpush

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $transaksi_service_sudah }}</h3>

                <p>Transaksi Service yang Sudah Selesai</p>
            </div>
            <div class="icon">
                <i class="fa fa-cube"></i>
            </div>
            <a href="{{ route('transaksi_service.index')}}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $transaksi_service_belum }}</h3>

                <p>Transaksi Service yang Sedang dalam pekerjaan</p>
            </div>
            <div class="icon">
                <i class="fa fa-cubes"></i>
            </div>
            <a href="{{ route('transaksi_service.index')}}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>Rp. {{ formatRupiah($sum_tot_Price) }}</h3>

                <p>Total Harga di Settlement Tahun Ini</p>
            </div>
            <div class="icon">
                <i class="fa fa-id-card"></i>
            </div>
            <a href="{{ route('settlement.index')}}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
            <h3 class="box-title">Total Harga</h3>
                <!-- <h3 class="box-title">Grafik Pinjaman {{ tanggal_indonesia($tanggal_awal, false) }} s/d {{ tanggal_indonesia($tanggal_akhir, false) }}</h3> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12">
                        <p>Filter dengan Bulan & Tahun :</p>
                        <div>
                            <input type="text" name="tanggal" id="daterangepicker" class="form-control datepicker" style="width: auto;display:inline-block">
                            <button type="button" id="rangesubmit" class="btn btn-primary">Submit</button>
                        </div>
                        {{-- <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="salesChart2" style="height: 180px;"></canvas>
                        </div> --}}
                        <!-- /.chart-responsive -->
                    </div>
                    @if(app('request')->input('monthyearsettlement'))
                    <div class="col-lg-3 col-xs-6" style="margin-top: 30px">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>Rp. {{ formatRupiah($sum_tot_Price_filter) }}</h3>

                                <p>Total Harga di Settlement Bulan dan Tahun Ini</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-id-card"></i>
                            </div>
                            <a href="{{ route('settlement.index')}}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @endif
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row (main row) -->
@endsection

@push('scripts')
<!-- ChartJS -->
{{-- <script src="{{ asset('AdminLTE-2/bower_components/chart.js/Chart.js') }}"></script> --}}
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
$('#daterangepicker').datepicker( {
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM-yy',
    onClose: function(dateText, inst) {
        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
    }
});

@if(app('request')->input('monthyearsettlement'))
$("#daterangepicker").val('{{app('request')->input('monthyearsettlement')}}')
@endif
$("#rangesubmit").click(function(){
//   alert($("#daterangepicker").val());
    var getdataval = $("#daterangepicker").val();
    // console.log(getdataval);
    if(!getdataval){
        alert('Harap untuk dipilih tanggal dan tahunnya.');
    } else{
        var daterange = '?monthyearsettlement='+getdataval;
        window.location.href = window.location.href.replace( /[\?#].*|$/, daterange );
    }
});
// $(function() {
//     var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
//     var salesChart = new Chart(salesChartCanvas);

//     var salesChartData = {
//         labels: {{ json_encode($tanggal_akhir) }},
//         datasets: [
//             {
//                 label: 'Pinjaman',
//                 fillColor           : 'rgba(60,141,188,0.9)',
//                 strokeColor         : 'rgba(60,141,188,0.8)',
//                 pointColor          : '#3b8bba',
//                 pointStrokeColor    : 'rgba(60,141,188,1)',
//                 pointHighlightFill  : '#fff',
//                 pointHighlightStroke: 'rgba(60,141,188,1)',
//                 data: {{ json_encode(0) }}
//             }
//         ]
//     };

//     var salesChartOptions = {
//         pointDot : false,
//         responsive : true
//     };

//     salesChart.Line(salesChartData, salesChartOptions);
// });
</script>
@endpush
