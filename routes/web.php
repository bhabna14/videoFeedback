<?php

use App\Http\Livewire\Index;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\BusinessLoginController;
use App\Http\Controllers\Admin\BusinessUnitController;
use App\Http\Controllers\Admin\AdminController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('sign-up');
});

Route::prefix('admin')->group(function () {
    Route::get('/business-login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/dash-board', [AdminController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::prefix('admin')->middleware('auth:admins')->group(function () {
    Route::get('/dash-board', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
    
    Route::controller(BusinessUnitController::class)->group(function() {
        Route::get('/add-business-unit', 'showBusinessUnit')->name('addBusinessUnit');
        Route::post('/save-business-unit','saveBusinessUnit')->name('admin.save-business-unit');
        Route::get('/manage-business-unit', 'manageBusinessUnit')->name('manageBusinessUnit');
        Route::post('/delete-business-unit/{id}',  'deleteBusinessUnit')->name('admin.deleteBusinessUnit');
        Route::get('/edit-business-unit/{id}', 'editBusinessUnit')->name('admin.edit-business-unit');
        Route::put('/update-business-unit/{id}', 'updateBusinessUnit')->name('admin.update-business-unit');
    });
});

Route::get('/sign-up', [SuperAdminController::class, 'businessRegister'])->name('businessRegister');

Route::post('/save-business-register', [SuperAdminController::class, 'saveBusinessRegister'])->name('saveBusinessRegister');

