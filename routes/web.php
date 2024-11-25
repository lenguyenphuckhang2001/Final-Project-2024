<?php

use App\Http\Controllers\Frontend\LoginOAuthController;
use App\Http\Controllers\Frontend\UserChatController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\GuestBlogController;
use App\Http\Controllers\Frontend\GuestListingController;
use App\Http\Controllers\Frontend\GuestPagesController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\UserListingController;
use App\Http\Controllers\Frontend\UserListingEvaluateController;
use App\Http\Controllers\Frontend\UserListingImageGalleryController;
use App\Http\Controllers\FrontEnd\UserListingScheduleController;
use App\Http\Controllers\Frontend\UserListingVideoGalleryController;
use App\Http\Controllers\Frontend\UserOrderController;
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

Route::get('/auth/google', [LoginOAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [LoginOAuthController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook', [LoginOAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [LoginOAuthController::class, 'handleFacebookCallback']);

/* HOME */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/checkout/{id}', [HomeController::class, 'checkout'])->name('checkout.index');

/* LISTING */
Route::get('/listings', [GuestListingController::class, 'listings'])->name('listings');
Route::get('/listing-modal/{id}', [GuestListingController::class, 'listingModal'])->name('listing-modal');
/* LISTING DETAIL */
Route::get('/listing/{slug}', [GuestListingController::class, 'detailListing'])->name('listing.detail');
Route::post('/listing-support', [GuestListingController::class, 'supportListing'])->name('listing-support');
Route::post('/listing-evaluate', [GuestListingController::class, 'evaluateListing'])->name('listing-evaluate.store')->middleware('auth');

/* BLOG */
Route::get('/blogs', [GuestBlogController::class, 'blogIndex'])->name('blogs');
Route::get('/blog-detail/{slug}', [GuestBlogController::class, 'blogDetail'])->name('blog.detail');
Route::post('/blog-comment', [GuestBlogController::class, 'blogComment'])->name('blog-comment')->middleware('auth');

/* PAGES */
Route::get('/about-us', [GuestPagesController::class, 'aboutUsIndex'])->name('about-us');
Route::get('/contact-us', [GuestPagesController::class, 'contactUsIndex'])->name('contact-us');
Route::post('/contact-us', [GuestPagesController::class, 'sendContactEmail'])->name('contact-us.send');
Route::get('/privacy-policy', [GuestPagesController::class, 'privacyPolicyIndex'])->name('privacy-policy');
Route::get('/terms-and-conditions', [GuestPagesController::class, 'termAndConditionIndex'])->name('terms-and-conditions');
Route::get('/personal-profile/{id}', [GuestPagesController::class, 'personalProfileIndex'])->name('personal-profile');
Route::get('/listing-categories', [GuestPagesController::class, 'listingCategoriesIndex'])->name('listing-categories');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*------------------------------------------ DASHBOARD ------------------------------------------*/
Route::group(['middleware' => 'auth', 'prefix' => 'user', 'as' => 'user.'], function () {
    /* DASHBOARD */
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    /* PROFILE */
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [UserProfileController::class, 'updateInfo'])->name('profile.update');
    Route::put('/profile-change-password', [UserProfileController::class, 'changePassword'])->name('profile-change-password.update');
    Route::put('/profile-change-banner', [UserProfileController::class, 'changeBanner'])->name('profile-change-banner.update');

    /* LISTING CRUD */
    Route::resource('/listing', UserListingController::class);

    /* LISTING IMAGE AND VIDEO CRUD */
    Route::resource('/image-gallery', UserListingImageGalleryController::class);
    Route::resource('/video-gallery', UserListingVideoGalleryController::class);

    /* LISTING SCHEDULES CRUD */
    Route::get('/schedule/{listing_id}', [UserListingScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/{listing_id}/create', [UserListingScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule/{listing_id}', [UserListingScheduleController::class, 'store'])->name('schedule.store');
    Route::get('/schedule/{id}/edit', [UserListingScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('/schedule/{id}', [UserListingScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{id}', [UserListingScheduleController::class, 'destroy'])->name('schedule.destroy');

    /* ORDER PAYMENT LIST */
    Route::get('/order', [UserOrderController::class, 'index'])->name('order.index');
    Route::get('/order/{id}', [UserOrderController::class, 'show'])->name('order.show');

    /* ORDER PAYMENT LIST */
    Route::get('/messages', [UserChatController::class, 'index'])->name('messages.index');
    Route::post('/new-message', [UserChatController::class, 'newMessage'])->name('new-message');
    Route::get('/store-messages', [UserChatController::class, 'storeMessages'])->name('store-messages');

    Route::get('/evaluate', [UserListingEvaluateController::class, 'index'])->name('evaluate.index');
    Route::delete('/evaluate/{id}', [UserListingEvaluateController::class, 'destroy'])->name('evaluate.destroy');
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
