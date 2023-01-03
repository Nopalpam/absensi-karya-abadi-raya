<?php
use App\Models\Absensi;
use Carbon\Carbon;

function format_uang ($angka) {
    return number_format($angka, 0, ',', '.');
}

function terbilang ($angka) {
    $angka = abs($angka);
    $baca  = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
    $terbilang = '';

    if ($angka < 12) { // 0 - 11
        $terbilang = ' ' . $baca[$angka];
    } elseif ($angka < 20) { // 12 - 19
        $terbilang = terbilang($angka -10) . ' belas';
    } elseif ($angka < 100) { // 20 - 99
        $terbilang = terbilang($angka / 10) . ' puluh' . terbilang($angka % 10);
    } elseif ($angka < 200) { // 100 - 199
        $terbilang = ' seratus' . terbilang($angka -100);
    } elseif ($angka < 1000) { // 200 - 999
        $terbilang = terbilang($angka / 100) . ' ratus' . terbilang($angka % 100);
    } elseif ($angka < 2000) { // 1.000 - 1.999
        $terbilang = ' seribu' . terbilang($angka -1000);
    } elseif ($angka < 1000000) { // 2.000 - 999.999
        $terbilang = terbilang($angka / 1000) . ' ribu' . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) { // 1000000 - 999.999.990
        $terbilang = terbilang($angka / 1000000) . ' juta' . terbilang($angka % 1000000);
    }

    return $terbilang;
}

function tanggal_indonesia($tgl, $tampil_hari = true)
{
    $nama_hari  = array(
        'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'
    );
    $nama_bulan = array(1 =>
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    $tahun   = substr($tgl, 0, 4);
    $bulan   = $nama_bulan[(int) substr($tgl, 5, 2)];
    $tanggal = substr($tgl, 8, 2);
    $text    = '';

    if ($tampil_hari) {
        $urutan_hari = date('w', mktime(0,0,0, substr($tgl, 5, 2), $tanggal, $tahun));
        $hari        = $nama_hari[$urutan_hari];
        $text       .= "$hari, $tanggal $bulan $tahun";
    } else {
        $text       .= "$tanggal $bulan $tahun";
    }

    return $text;
}

function tambah_nol_didepan($value, $threshold = null)
{
    return sprintf("%0". $threshold . "s", $value);
}

function generateToken($length = 40) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Function to get all the dates in given range
function getDatesFromRange($start, $end, $format = 'Y-m-d') {
    // Declare an empty array
    $array = array();
    // Variable that store the date interval
    // of period 1 day
    $interval = new DateInterval('P1D');
    $realEnd = new DateTime($end);
    $realEnd->add($interval);
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
    // Use loop to store date into array
    foreach($period as $date) {
        $array[] = $date->format($format);
    }
    // Return the array elements
    return $array;
}

function absensi_tahun_ini($id_user)
{
    $year = Carbon::now()->year;
    $month = Carbon::now()->month;
    if(!empty($id_user))
    {
        for($i = 1; $i <= $month; $i++)
        {
            $result[] = DB::table('absensi as a')
            ->join('users as u','u.id','=','a.id_karyawan')
            ->select(DB::raw('a.id, u.name as nama_karyawan, min(a.waktu_check) as jam_masuk,max(a.waktu_check) as jam_pulang,a.tanggal, a.status_absen, a.hadir, a.telat, a.sakit, a.ijin, a.cuti'))
            ->where('a.id_karyawan', $id_user)->whereMonth('a.tanggal', $i)->whereYear('a.tanggal', $year)
            ->groupBy('a.id_karyawan', 'a.tanggal')
            ->get();
        }
    }else{
        $result = null;
    }
    return $result;
}

function getJPekerjaan($id)
{
    if(!empty($id))
    {
        $result = DB::table('tb_jenis_pekerjaan')->whereIn('id_jenis_pekerjaan', explode(',', $id))->get();
    }else{
        $result = null;
    }
    return $result;
}

function removeString($id)
{
    if(!empty($id))
    {
        $result = preg_replace('/[^0-9,]/s', '', $id);
    }else{
        $result = null;
    }
    return $result;
}

function formatRupiah($id)
{
    if(!empty($id))
    {
        $result = number_format($id,0,',','.');
    }else{
        $result = null;
    }
    return $result;
}
