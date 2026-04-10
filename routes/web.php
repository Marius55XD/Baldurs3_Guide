<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuidePaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuideController as AdminGuideController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

// ── Public ────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'AboutUs')->name('about');
Route::view('/faq', 'Faq')->name('faq');
Route::view('/phone-support', 'PhoneSupport')->name('phone.support');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/guides', [GuideController::class, 'index'])->name('guides.index');
Route::get('/guides/{slug}', [GuideController::class, 'show'])->name('guides.show');
Route::get('/guides/{slug}/checkout', [GuidePaymentController::class, 'show'])->name('guides.checkout');
Route::post('/guides/{slug}/checkout', [GuidePaymentController::class, 'pay'])->name('guides.checkout.pay')->middleware('auth');

// ── Auth ──────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class,    'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class,    'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('home')->with('success', 'Your email address has been verified.');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        try {
            $request->user()->sendEmailVerificationNotification();
        } catch (TransportExceptionInterface $exception) {
            report($exception);

            return back()->with('error', 'We could not send the verification email right now. Check your Gmail SMTP settings and try again.');
        }

        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
});

// ── Admin ─────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('guides',     AdminGuideController::class);
    Route::resource('categories', AdminCategoryController::class);

    Route::get('/contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');
});
