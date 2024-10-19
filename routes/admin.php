<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminHeroSectionController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\MainListingController;
use App\Http\Controllers\Admin\ListingAmenityController;
use App\Http\Controllers\Admin\ListingCategoryController;
use App\Http\Controllers\Admin\ListingImageGalleryController;
use App\Http\Controllers\Admin\ListingLocationController;
use App\Http\Controllers\Admin\ListingPendingController;
use App\Http\Controllers\Admin\ListingScheduleController;
use App\Http\Controllers\Admin\ListingVideoGalleryController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PaymentSettingController;
use App\Http\Controllers\Admin\SettingController;
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

    Route::get('/pending', [ListingPendingController::class, 'index'])->name('pending.index');
    Route::post('/pending', [ListingPendingController::class, 'update'])->name('pending.update');

    Route::resource('/listing', MainListingController::class);
    Route::resource('/category', ListingCategoryController::class);
    Route::resource('/location', ListingLocationController::class);
    Route::resource('/amenity', ListingAmenityController::class);
    Route::resource('/image-gallery', ListingImageGalleryController::class);
    Route::resource('/video-gallery', ListingVideoGalleryController::class);

    Route::get('/schedule/{listing_id}', [ListingScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/{listing_id}/create', [ListingScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule/{listing_id}', [ListingScheduleController::class, 'store'])->name('schedule.store');
    Route::get('/schedule/{id}/edit', [ListingScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('/schedule/{id}', [ListingScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{id}', [ListingScheduleController::class, 'destroy'])->name('schedule.destroy');

    Route::resource('/packages', PackageController::class);

    Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/general-settings', [SettingController::class, 'updateGeneralSettings'])->name('general-settings.update');

    Route::get('/payment-settings', [PaymentSettingController::class, 'index'])->name('payment-settings.index');
    Route::post('/payment-settings', [PaymentSettingController::class, 'updatePaypal'])->name('payment-settings.update');
});
