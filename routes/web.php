<?php

use App\Http\Controllers\Frontend\ChatController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\UserListingController;
use App\Http\Controllers\Frontend\UserListingImageGalleryController;
use App\Http\Controllers\FrontEnd\UserListingScheduleController;
use App\Http\Controllers\Frontend\UserListingVideoGalleryController;
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

/*------------------------------------------ GUEST ------------------------------------------*/

Route::group(['prefix' => 'guest', 'as' => 'guest.'], function () {});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/listings', [HomeController::class, 'listings'])->name('listings');
Route::get('/listing-modal/{id}', [HomeController::class, 'listingModal'])->name('listing-modal');
Route::get('/listing/{slug}', [HomeController::class, 'detailListing'])->name('listing.detail');
Route::get('/checkout/{id}', [HomeController::class, 'checkout'])->name('checkout.index');
Route::get('/blogs', [HomeController::class, 'blogSection'])->name('blogs');
Route::get('/blog-detail/{slug}', [HomeController::class, 'blogDetail'])->name('blog.detail');
Route::post('/blog-comment', [HomeController::class, 'blogComment'])->name('blog-comment');
Route::get('/about-us', [HomeController::class, 'aboutUsShow'])->name('about-us');
Route::get('/contact-us', [HomeController::class, 'contactUsShow'])->name('contact-us');
Route::post('/contact-us', [HomeController::class, 'sendContactEmail'])->name('contact-us.send');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicyShow'])->name('privacy-policy');
Route::get('/terms-and-conditions', [HomeController::class, 'termAndConditionShow'])->name('terms-and-conditions');
Route::post('/listing-support', [HomeController::class, 'supportListing'])->name('listing-support');
Route::post('/listing-evaluate', [HomeController::class, 'evaluateListing'])->name('listing-evaluate.store')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*------------------------------------------ DASHBOARD ------------------------------------------*/
Route::group(['middleware' => 'auth', 'prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [UserProfileController::class, 'updateInfo'])->name('profile.update');
    Route::put('/profile-change-password', [UserProfileController::class, 'changePassword'])->name('profile-change-password.update');
    Route::put('/profile-change-banner', [UserProfileController::class, 'changeBanner'])->name('profile-change-banner.update');

    Route::resource('/listing', UserListingController::class);

    Route::resource('/image-gallery', UserListingImageGalleryController::class);
    Route::resource('/video-gallery', UserListingVideoGalleryController::class);

    Route::get('/schedule/{listing_id}', [UserListingScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/{listing_id}/create', [UserListingScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule/{listing_id}', [UserListingScheduleController::class, 'store'])->name('schedule.store');
    Route::get('/schedule/{id}/edit', [UserListingScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('/schedule/{id}', [UserListingScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{id}', [UserListingScheduleController::class, 'destroy'])->name('schedule.destroy');

    Route::get('/order', [OrderListController::class, 'index'])->name('order.index');
    Route::get('/order/{id}', [OrderListController::class, 'show'])->name('order.show');

    Route::get('/messages', [ChatController::class, 'index'])->name('messages.index');
    Route::post('/new-message', [ChatController::class, 'newMessage'])->name('new-message');
    Route::get('/store-messages', [ChatController::class, 'storeMessages'])->name('store-messages');
});

/*----------------------------------------- PAYMENT ROUTE -----------------------------------------*/
Route::group(['middleware' => 'auth'], function () {
    /* PAYMENT STATUS */
    Route::get('payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('payment/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');

    /* PAYPAL METHOD */
    Route::get('paypal/payment', [PaymentController::class, 'paypalPay'])->name('paypal.payment');
    Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');

    /* STRIPE METHOD */
    Route::get('stripe/payment', [PaymentController::class, 'stripePay'])->name('stripe.payment');
    Route::get('stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');
    Route::get('stripe/cancel', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');
});

require __DIR__ . '/auth.php';
