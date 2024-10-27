<?php

use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\FrontendProfileController;
use App\Http\Controllers\Frontend\ListingAgentController;
use App\Http\Controllers\Frontend\ListingAgentImageGalleryController;
use App\Http\Controllers\FrontEnd\ListingAgentScheduleController;
use App\Http\Controllers\Frontend\ListingAgentVideoGalleryController;
use App\Http\Controllers\Frontend\OrderListController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
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

//HOME PAGES ROUTE
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/listings', [FrontendController::class, 'listings'])->name('listings');
Route::get('/listing-modal/{id}', [FrontendController::class, 'listingModal'])->name('listing-modal');
Route::get('/listing/{slug}', [FrontendController::class, 'detailListing'])->name('listing.detail');
Route::get('checkout/{id}', [FrontendController::class, 'checkout'])->name('checkout.index');

Route::post('/listing-report', [FrontendController::class, 'reportListing'])->name('listing-report');
Route::post('/listing-evaluate', [FrontendController::class, 'evaluateListing'])->name('listing-evaluate.store')->middleware('auth');

//PROFILE PAGES ROUTE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//DASHBOARD PAGES ROUTE
Route::group(['middleware' => 'auth', 'prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [FrontendProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [FrontendProfileController::class, 'updateInfo'])->name('profile.update');
    Route::put('/profile-change-password', [FrontendProfileController::class, 'changePassword'])->name('profile-change-password.update');
    Route::put('/profile-change-banner', [FrontendProfileController::class, 'changeBanner'])->name('profile-change-banner.update');

    Route::resource('/listing', ListingAgentController::class);
    Route::resource('/image-gallery', ListingAgentImageGalleryController::class);
    Route::resource('/video-gallery', ListingAgentVideoGalleryController::class);

    Route::get('/schedule/{listing_id}', [ListingAgentScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/{listing_id}/create', [ListingAgentScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule/{listing_id}', [ListingAgentScheduleController::class, 'store'])->name('schedule.store');
    Route::get('/schedule/{id}/edit', [ListingAgentScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('/schedule/{id}', [ListingAgentScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{id}', [ListingAgentScheduleController::class, 'destroy'])->name('schedule.destroy');

    Route::get('/order', [OrderListController::class, 'index'])->name('order.index');
    Route::get('/order/{id}', [OrderListController::class, 'show'])->name('order.show');
});

//PAYMENT PAGES ROUTE
Route::group(['middleware' => 'auth'], function () {
    //Payment
    Route::get('payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('payment/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');

    //Paypal
    Route::get('paypal/payment', [PaymentController::class, 'paypalPay'])->name('paypal.payment');
    Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');

    //Stripe
    Route::get('stripe/payment', [PaymentController::class, 'stripePay'])->name('stripe.payment');
    Route::get('stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');
    Route::get('stripe/cancel', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');
});

require __DIR__ . '/auth.php';
