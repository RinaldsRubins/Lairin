<?php

use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pakalpojumi', [ServiceController::class, 'index'])->name('services.index');
Route::get('/pakalpojumi/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/nozares', [IndustryController::class, 'index'])->name('industries.index');

Route::get('/projekti', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projekti/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/blogs', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/par-mums', [PageController::class, 'about'])->name('pages.about');
Route::get('/buj', [PageController::class, 'faq'])->name('pages.faq');

Route::get('/kontakti', [ContactController::class, 'index'])->name('contact.index');

Route::get('/konsultacija', [BookingController::class, 'index'])->name('booking.index');
Route::get('/konsultacija/{token}', [BookingController::class, 'manage'])->name('booking.manage');
Route::post('/konsultacija/{token}/atcelt', [BookingController::class, 'cancel'])->name('booking.cancel');
Route::match(['get', 'post'], '/konsultacija/{token}/parcelt', [BookingController::class, 'reschedule'])->name('booking.reschedule');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('service-categories', ServiceCategoryController::class);
    Route::resource('blog-posts', AdminBlogPostController::class);
    Route::resource('projects', AdminProjectController::class);

    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update-status');

    Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('contact-messages/{contact_message}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
    Route::delete('contact-messages/{contact_message}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

    Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
    Route::put('seo', [SeoController::class, 'update'])->name('seo.update');

    Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');

    Route::get('google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
