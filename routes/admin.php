<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminHeroSectionController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\MainListingController;
use App\Http\Controllers\Admin\ListingAmenityController;
use App\Http\Controllers\Admin\ListingCategoryController;
use App\Http\Controllers\Admin\ListingLocationController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login')->middleware('guest');
Route::get('/admin/password-request', [AdminAuthController::class, 'passwordRequest'])->name('admin.password.request')->middleware('guest');

Route::group(['middleware' => ['auth', 'user.type:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update'); //Update information admin
    Route::put('/profile-change-password', [AdminProfileController::class, 'changePassword'])->name('profile-change-password.update'); //Update password admin

    Route::get('/hero', [AdminHeroSectionController::class, 'index'])->name('hero.index');
    Route::put('/hero', [AdminHeroSectionController::class, 'update'])->name('hero.update');

    Route::resource('/listing', MainListingController::class);
    Route::resource('/category', ListingCategoryController::class);
    Route::resource('/location', ListingLocationController::class);
    Route::resource('/amenity', ListingAmenityController::class);
});
