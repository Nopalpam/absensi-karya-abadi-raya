<?php

namespace App\Exports;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportAbsensi implements FromCollection, WithColumnFormatting, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $start,$end,$nip;
    
    public function __construct(String  $start, String $end, String $nip)
    {
        $this->start = $start;
        $this->end = $end;
        $this->nip = $nip;
    }

    public function collection()
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $datas = DB::table('absensi as a')
        ->join('users as u','u.id','=','a.id_karyawan')
        ->select(DB::raw('a.id, u.nip, u.name as nama_karyawan, min(a.waktu_check) as jam_masuk,max(a.waktu_check) as jam_pulang, a.tanggal, a.status_absen, a.hadir, a.telat, a.sakit, a.ijin, a.cuti'))->whereBetween('tanggal', [$this->start, $this->end]);
        if($this->nip != 'all'){
            $datas = $datas->where('a.nip', $this->nip);
        }
        $datas = $datas->groupBy('a.id_karyawan', 'a.tanggal')
        ->get();
        // dd($datas);
        return $datas;
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
        ];
    }
    
    public function map($map) : array 
    {
        $kolom1 = strval($map->tanggal);
        $kolom2 = strval($map->nama_karyawan);
        $kolom3 = strval($map->jam_masuk);
        $kolom4 = strval($map->jam_pulang);
        $kolom5 = strval($map->telat);
        $kolom6 = strval($map->hadir);
        $kolom7 = strval($map->sakit);
        $kolom8 = strval($map->ijin);
        $kolom9 = strval($map->cuti);
        return [
            $kolom1,
            $kolom2,
            $kolom3,
            $kolom4,
            $kolom5,
            $kolom6,
            $kolom7,
            $kolom8,
            $kolom9,
        ] ;
    }

    public function headings(): array
    {
        return 
        [
            'TANGGAL',
            'NAMA KARYAWAN',
            'JAM MASUK',
            'JAM PULANG',
            'TELAT',
            'HADIR',
            'SAKIT',
            'IJIN',
            'CUTI',
        ];
    }
}
