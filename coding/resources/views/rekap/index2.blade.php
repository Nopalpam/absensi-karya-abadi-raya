@extends('layouts.master')

@section('title')
Rekap Absen Bulanan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Rekap Absen Bulanan</li>
@endsection

@section('content')
@php 
    $area = isset($_GET['area'])?$_GET['area'] : null; 
    $nip = isset($_GET['nip'])?$_GET['nip'] : null; 
@endphp
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Rekap Absen Bulanan</h3>
    </div>
    <div class="box-body">
        <div class="col-md-4"></div>
        <div class="col-md-8">
        <form class="form-inline pull-right" action="{{ route('rekap_absen.bulanan') }}" method="get">
            <select name="nip" class="form-control select2" id="nip">
                <option selected value="" disabled>--pilih karyawan--</option>
                @foreach($datas as $karyawan)
                <option value="{{$karyawan->nip}}" @if($karyawan->nip == $nip)selected @endif>{{$karyawan->name}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-info btn-flat margin"><i class="fa fa-search"></i> filter</button>
        </form>
        </div>
        @if($datas->count() > 0)
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nama Karyawan</th>
                    <th>HADIR</th>
                    <th>TELAT</th>
                    <th>SAKIT</th>
                    <th>IJIN</th>
                    <th>CUTI</th>
                </tr>
                @foreach($datas as $i => $data)
                <tr>
                    <td>{{ $datas->firstItem() + $i }}.</td>
                    <td colspan="6"><b>{{ $data->name}}</b> <i>{{" (".$data->nip}} - {{$data->occupation.")" }}</i></td>
                </tr>
                    @foreach(absensi_tahun_ini($data->id) as $bln => $rekap)
                    @php
                        $bulan = $bln + 1;
                        switch ($bulan) {
                            case "1":
                                $bulan = "Januari";
                            break;
                            case "2":
                                $bulan = "Februari";
                            break;
                            case "3":
                                $bulan = "Maret";
                            break;
                            case "4":
                                $bulan = "April";
                            break;
                            case "5":
                                $bulan = "Mei";
                            break;
                            case "6":
                                $bulan = "Juni";
                            break;
                            case "7":
                                $bulan = "Juli";
                            break;
                            case "8":
                                $bulan = "Agustus";
                            break;
                            case "9":
                                $bulan = "September";
                            break;
                            case "10":
                                $bulan = "Oktober";
                            break;
                            case "11":
                                $bulan = "November";
                            break;
                            case "12":
                                $bulan = "Desember";
                            break;
                            default:
                            echo "-";
                        }
                        @endphp
                    <tr>
                        <td colspan="2" style="text-align:center"><b>{{ $bulan }}</b></td>
                        <td style="text-align:center" width="12%">{{ $rekap->sum('hadir') }}</td>
                        <td style="text-align:center" width="12%">{{ $rekap->sum('telat') }}</td>
                        <td style="text-align:center" width="12%">{{ $rekap->sum('sakit') }}</td>
                        <td style="text-align:center" width="12%">{{ $rekap->sum('ijin') }}</td>
                        <td style="text-align:center" width="12%">{{ $rekap->sum('cuti') }}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <!-- /.box-footer-->
        @else
        <div class="box-body">
            <h2>Filter Data lebih Dahulu..</h2>
        </div>
        @endif
    </div>
    <!-- /.box-body -->
    @if($datas->count() > 0)
    <div class="box-footer clearfix">
        <ul class="pagination pagination-sm no-margin pull-right">
            <?php if (1 < $datas->currentpage()){ ?>
            <li><a href="{{ $datas->previousPageUrl() }}">«</a></li>
            <?php } ?>
            <li><a href="#">{{ $datas->currentpage() }}</a></li>
            <?php if ($datas->currentpage() < $datas->lastPage()){ ?>
            <li><a href="{{ $datas->nextPageUrl() }}">»</a></li>
            <?php } ?>
        </ul>
    </div>
    @endif
    </div>
</div>
@endsection
@push('scripts')
<script>
$(function () {
    $('.select2').select2();
});
// show form //
</script>
@endpush