@extends('layouts.master')

@section('title')
Rekap Absen Bulanan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Rekap Absen Bulanan</li>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Rekap Absen Bulanan</h3>
    </div>
    <div class="box-body">
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
                <tr>
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
            </tbody>
        </table>
        <!-- /.box-footer-->
    </div>
</div>
@endsection
@push('scripts')
<script>
$(function () {
    $('.select2').select2();
});
</script>
@endpush