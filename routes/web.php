<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CustinstalationKategoriController;
use App\Http\Controllers\SimulationController;

Route::get('/', function () {
    $portfolios = \App\Models\Portfolio::latest()->take(3)->get();
    return view('landingpage', compact('portfolios'));
});

Route::get('/simulasibiaya', [SimulationController::class, 'form']);
Route::post('/simulasibiaya', [SimulationController::class, 'runWeb']);
Route::get('/simulasihasil', fn() => view('simulasi.simulasihasil'));
Route::get('/contactus', fn() => view('contactus'));

Route::get('/portofolio', [PortfolioController::class, 'showPublic'])->name('portofolio.public');

// USER VIEW KATALOG
Route::get('/katalog', [CatalogController::class, 'publicView'])->name('katalog.public');
Route::get('/katalog/search', [CatalogController::class, 'search'])->name('katalog.search');


/*
|--------------------------------------------------------------------------
| FIX FOR AUTH REDIRECT ISSUE
|--------------------------------------------------------------------------
| Laravel membutuhkan route bernama "login" untuk redirect auth.
| Tanpa ini, update catalog menghasilkan error 500.
*/
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // ---------- AUTH ----------
    Route::get('/login', fn() => view('admin.auth.login'))->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/resetpassword', fn() => view('admin.auth.resetpassword'))->name('resetpassword');
    Route::get('/insertcode', fn() => view('admin.auth.masukankode'))->name('insertcode');
    Route::get('/ubahpassword', fn() => view('admin.auth.ubahpassword'))->name('ubahpassword');

    // ---------- DASHBOARD ----------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ---------- PEMESANAN ----------
    Route::get('/pemesanan', [OrderController::class, 'create'])->name('pemesanan');
    Route::post('/pemesanan', [OrderController::class, 'store'])->name('pemesanan.store');

    // ---------- ORDER DATA ----------
    Route::get('/orderdata', [OrderController::class, 'index'])->name('orderdata.index');
    Route::post('/orderdata', [OrderController::class, 'store'])->name('orderdata.store');
    Route::get('/orderdata/{id}/edit', [OrderController::class, 'edit'])->name('orderdata.edit');
    Route::put('/orderdata/{id}', [OrderController::class, 'update'])->name('orderdata.update');
    Route::delete('/orderdata/{id}', [OrderController::class, 'destroy'])->name('orderdata.destroy');

   // ================================
// ADMIN — KATALOG
// ================================
Route::get('/catalogue', [CatalogController::class, 'adminView'])->name('catalogue.view');
Route::get('/catalogue/list', [CatalogController::class, 'adminList'])->name('catalogue.list');
Route::post('/catalogue', [CatalogController::class, 'store'])->name('catalogue.store');
Route::post('/catalogue/{id}', [CatalogController::class, 'update'])->name('catalogue.update'); 
Route::delete('/catalogue/{id}', [CatalogController::class, 'destroy'])->name('catalogue.destroy');
Route::get('/catalogue/{id}/edit', [CatalogController::class, 'edit'])->name('catalogue.edit');


    // ================================
// ADMIN — PORTOFOLIO (PENGGANTI COMPRO)
// ================================
Route::get('/portofolio', [PortfolioController::class, 'adminIndex'])->name('portofolio');
Route::post('/portofolio', [PortfolioController::class, 'store'])->name('portofolio.store');
Route::post('/portofolio/{id}', [PortfolioController::class, 'adminUpdate'])->name('portofolio.update');
Route::delete('/portofolio/{id}', [PortfolioController::class, 'destroy'])->name('portofolio.destroy');
Route::get('/portofolio/{id}/show', [PortfolioController::class, 'adminShow'])->name('portofolio.show');

});
