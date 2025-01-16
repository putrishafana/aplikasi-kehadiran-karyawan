<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttandanceController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KonfigurasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Middleware after login karyawan
Route::middleware(['guest:karyawan'])->group(function(){
    // halaman login
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    // Login Proses
    Route::post('/gologin', [AuthController::class, 'go_login']);
});

Route::middleware(['guest:user'])->group(function(){
    // halaman login
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/admin/login', [AuthController::class, 'login_admin']);
});


// Middleware before login
Route::middleware(['auth:karyawan'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Logout Proses
    Route::get('/gologout', [AuthController::class, 'go_logout']);

    Route::get('/attandance/create', [AttandanceController::class, 'create']);
    Route::post('/attandance/store', [AttandanceController::class, 'store']);
    Route::get('/get-location/{id}', [AttandanceController::class, 'getLoc']);

    Route::get('/editprofil', [AttandanceController::class, 'editProfil']);
    Route::post('/attandance/{nik}/update', [AttandanceController::class, 'update']);

    Route::get('/attandance/histori', [Attandancecontroller::class, 'history']);
    Route::post('/getHistory', [Attandancecontroller::class, 'getHistory']);

    Route::get('/attandance/izin', [AttandanceController::class, 'izin']);
    Route::get('/attandance/createIzin', [AttandanceController::class, 'createIzin']);
    Route::post('/attandance/submitizin', [AttandanceController::class, 'submitIzin']);
    Route::post('/attandance/{id}/batalkanPengajuan', [AttandanceController::class, 'batalPengajuan']);
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('/panel/admindashboard', [DashboardController::class, 'admin']);
    Route::get('/panel/update', [DashboardController::class, 'editProfil']);
    Route::post('/panel/{id}/update', [DashboardController::class, 'update']);

    Route::get('/logoutadmin', [AuthController::class, 'logout_admin']);

    // CRUD Karyawan
    Route::get('/panel/listkaryawan', [KaryawanController::class, 'index']);
    Route::post('/panel/simpan-karyawan', [KaryawanController::class, 'store']);
    Route::post('/panel/update-karyawan', [KaryawanController::class, 'update']);
    Route::post('/panel/{nik}/update', [KaryawanController::class, 'save_update']);
    Route::post('/panel/view-karyawan', [KaryawanController::class, 'view']);
    Route::post('/panel/{nik}/delete', [KaryawanController::class, 'delete']);

    // CRUD Divisi
    Route::get('/panel/list-divisi', [DivisiController::class, 'index']);
    Route::post('/panel/simpan-divisi', [DivisiController::class, 'store']);
    Route::post('/panel/update-divisi', [DivisiController::class, 'update']);
    Route::post('/panel/{kd_divisi}/update-div', [DivisiController::class, 'save_update']);
    Route::post('/panel/view-divisi', [DivisiController::class, 'view']);
    Route::post('/panel/{kd_divisi}/delete-div', [DivisiController::class, 'delete']);

    // Monitoring Attandance
    Route::get('/panel/monitor-att', [AttandanceController::class, 'monitoring']);
    Route::post('/panel/get-data', [AttandanceController::class, 'getData']);
    Route::post('/panel/show-maps', [AttandanceController::class, 'viewMaps']);

    // Laporan
    Route::get('/panel/lap-kehadiran', [AttandanceController::class, 'lap_kehadiran']);
    Route::get('/panel/rekap-kehadiran', [AttandanceController::class, 'rekap_kehadiran']);
    Route::post('/panel/print-lap', [AttandanceController::class, 'print']);
    Route::post('/panel/print-rekap', [AttandanceController::class, 'rekap']);

    // Konfigurasi Lokasi
    Route::get('/panel/config-loc', [KonfigurasiController::class, 'index']);
    Route::post('/panel/simpan-loc', [KonfigurasiController::class, 'store']);
    Route::post('/panel/update-loc', [KonfigurasiController::class, 'update']);
    Route::post('/panel/{id}/update-loc', [KonfigurasiController::class, 'save_update']);
    Route::post('/panel/view-loc', [KonfigurasiController::class, 'view']);
    Route::post('/panel/{id}/delete-loc', [KonfigurasiController::class, 'delete']);



    Route::get('/getDivisiId/{id}', [KaryawanController::class, 'getDivisiId']);

    // Approval Izin / Sakit
    Route::get('/panel/approval', [AttandanceController::class, 'approvalIzin']);
    Route::post('/panel/approve', [AttandanceController::class, 'approve']);
    Route::get('/panel/{id}/batal-approve', [AttandanceController::class, 'batalApprove']);

    // CRUD User Admin
    Route::get('/panel/admin', [AdminController::class, 'index']);
    Route::post('/panel/simpan-user', [AdminController::class, 'store']);
    Route::post('/deactivate-account', [AdminController::class, 'deactivateAccount']);
    Route::post('/toggle-status', [AdminController::class, 'toggleStatus']);
    Route::post('/reset-password', [AdminController::class, 'resetPassword']);
    Route::post('/panel/{id}/delete-akun', [KonfigurasiController::class, 'delete']);


});

