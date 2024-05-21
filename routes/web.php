<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\DataController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [BeritaController::class, 'index'])->name('show.berita');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'is_admin'])->group(function(){
    // Route::get('/admin/dashboard',[AdminController::class,'showDashboard'])->name('admin.dashboard');
    // Route::get('/admin/post',[PostController::class,'showDashboard'])->name('admin.post');
    Route::get('/dashboard', [PostController::class, 'dashboard'])->name('posts.dashboard');

    Route::get('/provinsi', [ProvinsiController::class, 'index'])->name('provinsi.index');
    Route::get('/provinsi/tambah', [ProvinsiController::class, 'create'])->name('provinsi.tambah');
    Route::post('/provinsi/tambah', [ProvinsiController::class, 'store'])->name('provinsi.store');
    Route::get('/provinsi/edit/{id}', [ProvinsiController::class, 'edit'])->name('provinsi.edit');
    Route::put('/provinsi/edit/{id}', [ProvinsiController::class, 'update'])->name('provinsi.update');
    Route::delete('/provinsi/hapus/{id}', [ProvinsiController::class, 'destroy'])->name('provinsi.destroy');


    Route::get('/dataaktual', [DataController::class, 'index'])->name('data.index');
    Route::get('/data/tambah', [DataController::class, 'create'])->name('data.tambah');
    Route::post('/data/tambah', [DataController::class, 'store'])->name('data.store');
    Route::get('/data/edit/{id}', [DataController::class, 'edit'])->name('data.edit');
    Route::put('/data/edit/{id}', [DataController::class, 'update'])->name('data.update');
    Route::delete('/data/hapus/{id}', [DataController::class, 'destroy'])->name('data.destroy');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/prediksiprovinsi', [PostController::class, 'getDataByProvinsi'])->name('posts.provinsi');

    Route::get('/smoothing', [PrediksiController::class, 'index'])->name('prediksi.index');
    Route::get('/smoothingprovinsi', [PrediksiController::class, 'getDataByProvinsi'])->name('prediksi.provinsi');
    Route::get('/rekap/provinsi', [PrediksiController::class, 'getRekap'])->name('prediksi.getrekap');
    Route::get('/rekap', [PrediksiController::class, 'rekap'])->name('prediksi.rekap');

    Route::get('/posts/show/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/create', [PostController::class, 'create'])->name('create');
    // Rute untuk menangani form tambah post
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Rute untuk menangani form edit post
    Route::get('/posts/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::patch('/posts/{id}', [PostController::class, 'update']); // Opsional untuk patch request

    // Rute untuk menghapus post
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
// Route::middleware('admin')->group(function () {
//     Route::resource('posts', 'PostController');
// });
require __DIR__.'/auth.php';
