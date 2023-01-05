<?php

namespace App\Http\Controllers;

use App\Models\Settlement;
use App\Models\TransaksiService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');
        if (auth()->user()->level == 'admin') {
            $transaksi_service_sudah = TransaksiService::where('status', '1')
            ->count();
            $transaksi_service_belum = TransaksiService::where('status', '0')
            ->count();

            $sum_tot_Price_filter = 0;
            if ($request->has('monthyearsettlement') && !empty($request->monthyearsettlement))
            {
                $monthyearsettlement = explode("-",$request->monthyearsettlement);
                $gmonth = Carbon::parse($monthyearsettlement[0])->format('m');
                $gyear = $monthyearsettlement[1];

                $datamonthsettlement = Settlement::whereYear('created_at', '=', $gyear)
                ->whereMonth('created_at', '=', $gmonth)
                ->get();
                // dd($datamonthsettlement);
                foreach ($datamonthsettlement as $d) {
                    $sum_tot_Price_filter += $d->harga_total;
                }
            }
            $dd = Settlement::whereYear('created_at', '=', '2023')
                ->whereMonth('created_at', '=', '01')
                ->get();
                // dd($dd);

            $year = Carbon::now()->year;
            // $year = '2021';
            $data = Settlement::whereYear('created_at', $year)->get();
            $sum_tot_Price = 0;
            foreach ($data as $ddata) {
                $sum_tot_Price += $ddata->harga_total;
            }

            return view('admin.dashboard', compact('tanggal_awal', 'tanggal_akhir','transaksi_service_sudah','transaksi_service_belum','sum_tot_Price','sum_tot_Price_filter'));
        } else {
            return view('karyawan.dashboard');
        }
    }

    public function absensi()
    {
        return view('karyawan.absensi');
    }
}
