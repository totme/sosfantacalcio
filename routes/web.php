<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\QuestionController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
Auth::routes(['register' => false, 'login' => false]);

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('welcome');
    })->name('logout');

    Route::get('dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('personal', [QuestionController::class, 'my'])->name('my');

    Route::get('create', [DashboardController::class, 'create'])->middleware('questionCount')->name('create');

    Route::post('create', [DashboardController::class, 'store'])->middleware('questionCount')->name('store');

    Route::get('/users', [UserController::class, 'show'])->middleware(['auth:sanctum', 'verified'])->name('manage.user.list');
    Route::get('/schedule', [ScheduleFetch::class, 'show'])->middleware(['auth:sanctum', 'verified'])->name('manage.schedule.fetch');
    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('manage.logs');
});


Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('create', [AdminController::class, 'store'])->name('admin.store');

    Route::get('/import-players', [AdminController::class, 'playerImport'])->name('admin.player.import');
    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('admin.logs');
});

Route::get('/q/{uuid?}', [QuestionController::class, 'show'])->name('question.show');



Route::get('/error', function () {
    return view('error');
})->name('error.page');

Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);
