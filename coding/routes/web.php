<?php

use App\Http\Controllers\{
    DashboardController,
    SettingController,
    UserController,
    AreaController,
    JadwalController,
    AbsensiController,
    RekapAbsenController,
    SikController,
    DealerController,
    JenisPekerjaanController,
    TransaksiServiceController,
    InvoiceController,
    SettlementController,
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::group(['middleware' => 'level:admin'], function () {
        // user route //
        Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
        Route::resource('/user', UserController::class);
        // area route //
        Route::get('/area/data', [AreaController::class, 'data'])->name('area.data');
        Route::resource('/area', AreaController::class);
        // jadwal route //
        Route::get('/jadwal/data', [JadwalController::class, 'data'])->name('jadwal.data');
        Route::resource('/jadwal', JadwalController::class);
        // rekap route //
        Route::get('/rekap_absen/data', [RekapAbsenController::class, 'data'])->name('rekap_absen.data');
        Route::get('/rekap_absen/data_bulanan', [RekapAbsenController::class, 'data_bulanan'])->name('rekap_absen.data_bulanan');
        Route::get('/rekap_absen/bulanan', [RekapAbsenController::class, 'index2'])->name('rekap_absen.bulanan');
        Route::post('/rekap_absen/download', [RekapAbsenController::class, 'download'])->name('rekap_absen.download');
        Route::resource('/rekap_absen', RekapAbsenController::class);
        // dealer //
        Route::get('/dealer', [DealerController::class, 'index'])->name('dealer.index');
        Route::get('/dealer/data', [DealerController::class, 'data'])->name('dealer.data');
        Route::resource('/dealer', DealerController::class);
        // jenis_pekerjaan //
        Route::get('/jenis_pekerjaan', [JenisPekerjaanController::class, 'index'])->name('jenis_pekerjaan.index');
        Route::get('/jenis_pekerjaan/data', [JenisPekerjaanController::class, 'data'])->name('jenis_pekerjaan.data');
        Route::resource('/jenis_pekerjaan', JenisPekerjaanController::class);
        // setting route //
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

    });

    Route::group(['middleware' => 'level:karyawan,admin,admininvoice'], function () {
        Route::get('/absensi', [DashboardController::class, 'absensi'])->name('absensi');
        Route::resource('/absen', AbsensiController::class);
        Route::get('/check_in', [AbsensiController::class, 'check_in'])->name('check_in');
        Route::get('/check_out', [AbsensiController::class, 'check_out'])->name('check_out');
        Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
        Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
        Route::get('/karyawan_area', [JadwalController::class, 'karyawan_area'])->name('karyawan_area');
        // sik route //
        Route::get('/sik/data', [SikController::class, 'data'])->name('sik.data');
        Route::get('/sik_karyawan', [SikController::class, 'sik_karyawan'])->name('sik_karyawan');
        Route::get('/verifikasi_sik/{id}', [SikController::class, 'verifikasi_sik'])->name('verifikasi_sik');
        Route::resource('/sik', SikController::class);
        Route::get('/rekap_karyawan', [AbsensiController::class, 'rekap_karyawan'])->name('rekap_karyawan');
        Route::get('/data_absen_karyawan', [AbsensiController::class, 'data_absen_karyawan'])->name('data_absen_karyawan');
        Route::get('/absensi_karyawan', [AbsensiController::class, 'absensi_karyawan'])->name('absensi_karyawan');
    });
    // transaksi_service //
    Route::get('/transaksi_service', [TransaksiServiceController::class, 'index'])->name('transaksi_service.index');
    Route::get('/transaksi_service/data', [TransaksiServiceController::class, 'data'])->name('transaksi_service.data');
    Route::post('/transaksi_service/updatefinish/{id_transaksi_service}', [TransaksiServiceController::class, 'updatefinish'])->name('transaksi_service.updatefinish');
    Route::resource('/transaksi_service', TransaksiServiceController::class);
    // invoice //
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/data', [InvoiceController::class, 'data'])->name('invoice.data');
    Route::get('/invoice/view_pdf', [InvoiceController::class, 'view_pdf'])->name('invoice.view_pdf');
    Route::get('/invoice/cetak_pdf', [InvoiceController::class, 'cetak_pdf'])->name('invoice.cetak_pdf');
    Route::resource('/invoice', InvoiceController::class);
    // settlement //
    Route::get('/settlement', [SettlementController::class, 'index'])->name('settlement.index');
    Route::get('/settlement/data', [SettlementController::class, 'data'])->name('settlement.data');
    Route::post('/settlement/updatefinish/{id}', [SettlementController::class, 'updatefinish'])->name('settlement.updatefinish');
    Route::post('/settlement/updateStatus/{id}', [SettlementController::class, 'updateStatus'])->name('settlement.updateStatus');
    Route::get('/settlement/view_pdf/{id}', [SettlementController::class, 'view_pdf'])->name('settlement.view_pdf');
    Route::get('/settlement/view_pdf_full/{id}', [SettlementController::class, 'view_pdf_full'])->name('settlement.view_pdf_full');
    Route::resource('/settlement', SettlementController::class);
});
