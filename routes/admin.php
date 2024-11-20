<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\HomeFeaturesController;
use App\Http\Controllers\Admin\HomeHeroController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\BlogCommentController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogTopicController;
use App\Http\Controllers\Admin\ListingEvaluateController;
use App\Http\Controllers\Admin\HomeFeedbackController;
use App\Http\Controllers\Admin\MainListingController;
use App\Http\Controllers\Admin\ListingFacilityController;
use App\Http\Controllers\Admin\ListingCategoryController;
use App\Http\Controllers\Admin\ListingImageGalleryController;
use App\Http\Controllers\Admin\ListingLocationController;
use App\Http\Controllers\Admin\ListingPendingController;
use App\Http\Controllers\Admin\ListingScheduleController;
use App\Http\Controllers\Admin\ListingVideoGalleryController;
use App\Http\Controllers\Admin\MenuBuilderSectionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PageAboutUsController;
use App\Http\Controllers\Admin\PageContactUsController;
use App\Http\Controllers\Admin\PagePrivacyPolicyController;
use App\Http\Controllers\Admin\PageTermAndConditionsController;
use App\Http\Controllers\Admin\SettingPaymentController;
use App\Http\Controllers\Admin\ListingSupportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\HomeStatisticalController;
use App\Http\Controllers\Admin\PermissionUserRoleController;
use Illuminate\Support\Facades\Route;

// Admin Authentication
Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login')->middleware('guest');
Route::get('/admin/password-request', [AdminAuthController::class, 'passwordRequest'])->name('admin.password.request')->middleware('guest');

// Admin Routes Group
Route::group(['middleware' => ['auth', 'user.type:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');

    // Profile
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update'); //Update information admin
    Route::put('/profile-change-password', [AdminProfileController::class, 'changePassword'])->name('profile-change-password.update'); //Update password admin

    //Hero Section
    Route::get('/hero-section', [HomeHeroController::class, 'index'])->name('hero-section.index');
    Route::put('/hero-section', [HomeHeroController::class, 'update'])->name('hero-section.update');
    //Feature Section
    Route::resource('/features', HomeFeaturesController::class);
    //Statistical Section
    Route::get('/statistical', [HomeStatisticalController::class, 'index'])->name('statistical.index');
    Route::put('/statistical', [HomeStatisticalController::class, 'update'])->name('statistical.update');
    //Feedback Section
    Route::resource('/feedback', HomeFeedbackController::class);

    // Listings Sections
    Route::resource('/listing', MainListingController::class);
    // Category Listings
    Route::resource('/category', ListingCategoryController::class);
    // Location Listings
    Route::resource('/location', ListingLocationController::class);
    // Facility Listings
    Route::resource('/facility', ListingFacilityController::class);
    // Image Gallery Listings
    Route::resource('/image-gallery', ListingImageGalleryController::class);
    // Video Gallery Listings
    Route::resource('/video-gallery', ListingVideoGalleryController::class);

    //Schedule Listing
    Route::get('/schedule/{listing_id}', [ListingScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/{listing_id}/create', [ListingScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule/{listing_id}', [ListingScheduleController::class, 'store'])->name('schedule.store');
    Route::get('/schedule/{id}/edit', [ListingScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('/schedule/{id}', [ListingScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{id}', [ListingScheduleController::class, 'destroy'])->name('schedule.destroy');

    // Pending Listings
    Route::get('/pending', [ListingPendingController::class, 'index'])->name('pending.index');
    Route::post('/pending', [ListingPendingController::class, 'update'])->name('pending.update');

    //Evaluate Listings
    Route::get('/evaluate', [ListingEvaluateController::class, 'index'])->name('evaluate.index');
    Route::get('/evaluate/{id}', [ListingEvaluateController::class, 'update'])->name('evaluate.update');
    Route::delete('/evaluate/{id}', [ListingEvaluateController::class, 'destroy'])->name('evaluate.destroy');

    //Support Listings
    Route::get('/supports', [ListingSupportController::class, 'index'])->name('supports.index');
    Route::delete('/supports/{id}', [ListingSupportController::class, 'destroy'])->name('supports.destroy');

    //Packages and Orders
    Route::resource('/packages', PackageController::class);
    Route::resource('/orders', OrderController::class);

    //Settings Management
    Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/general-settings', [SettingController::class, 'updateGeneralSettings'])->name('general-settings.update');
    Route::post('/pusher-settings', [SettingController::class, 'updatePusherSettings'])->name('pusher-settings.update');

    //Payment Settings
    Route::get('/payment-settings', [SettingPaymentController::class, 'index'])->name('payment-settings.index');
    Route::post('/paypal-settings', [SettingPaymentController::class, 'updatePaypal'])->name('paypal-settings.update');
    Route::post('/stripe-settings', [SettingPaymentController::class, 'updateStripe'])->name('stripe-settings.update');

    //Chat
    Route::get('/messages', [AdminChatController::class, 'index'])->name('message.index');
    Route::get('/store-messages', [AdminChatController::class, 'storeMessages'])->name('store-messages');
    Route::post('/new-message', [AdminChatController::class, 'newMessage'])->name('new-message');

    //Blog
    Route::resource('/blog', BlogController::class);
    Route::resource('/blog-topic', BlogTopicController::class);
    Route::get('/blog-comment', [BlogCommentController::class, 'index'])->name('blog-comment.index');
    Route::get('/blog-comment-status', [BlogCommentController::class, 'updateStatus'])->name('blog-comment.update');
    Route::delete('/blog-comment/{id}', [BlogCommentController::class, 'destroy'])->name('blog-comment.destroy');

    //About Us
    Route::get('/about-us', [PageAboutUsController::class, 'index'])->name('about-us.index');
    Route::put('/about-us', [PageAboutUsController::class, 'update'])->name('about-us.update');

    //Contact Us
    Route::get('/contact-us', [PageContactUsController::class, 'index'])->name('contact-us.index');
    Route::put('/contact-us', [PageContactUsController::class, 'update'])->name('contact-us.update');

    //Privacy Policy
    Route::get('/privacy-policy', [PagePrivacyPolicyController::class, 'index'])->name('privacy-policy.index');
    Route::put('/privacy-policy', [PagePrivacyPolicyController::class, 'update'])->name('privacy-policy.update');

    //Terms And Conditions
    Route::get('/terms-and-conditions', [PageTermAndConditionsController::class, 'index'])->name('terms-and-conditions.index');
    Route::put('/terms-and-conditions', [PageTermAndConditionsController::class, 'update'])->name('terms-and-conditions.update');

    //Menu Builder
    Route::get('/menu-builder-section', [MenuBuilderSectionController::class, 'index'])->name('menu-builder-section.index');

    //Permission
    Route::resource('/permission', PermissionController::class);
    Route::resource('/user-role', PermissionUserRoleController::class);
});
