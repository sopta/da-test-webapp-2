<?php

declare(strict_types=1);

use CzechitasApp\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use CzechitasApp\Http\Controllers\Admin\ExportController as AdminExportController;
use CzechitasApp\Http\Controllers\Admin\NewsController as AdminNewsController;
use CzechitasApp\Http\Controllers\Admin\OrderController as AdminOrderController;
use CzechitasApp\Http\Controllers\Admin\StudentController as AdminStudentController;
use CzechitasApp\Http\Controllers\Admin\TermController as AdminTermController;
use CzechitasApp\Http\Controllers\Admin\UserController as AdminUserController;
use CzechitasApp\Http\Controllers\ArtisanController;
use CzechitasApp\Http\Controllers\Auth\ConfirmPasswordController;
use CzechitasApp\Http\Controllers\Auth\ForgotPasswordController;
use CzechitasApp\Http\Controllers\Auth\LoginController;
use CzechitasApp\Http\Controllers\Auth\ProfileController;
use CzechitasApp\Http\Controllers\Auth\RegisterController;
use CzechitasApp\Http\Controllers\Auth\ResetPasswordController;
use CzechitasApp\Http\Controllers\HomeController;
use CzechitasApp\Http\Controllers\LogViewerController;
use CzechitasApp\Http\Controllers\OrderController;
use CzechitasApp\Http\Controllers\StaticPageController;
use CzechitasApp\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// phpcs:disable Generic.Files.LineLength.MaxExceeded
// phpcs:disable SlevomatCodingStandard.Functions.RequireMultiLineCall.RequiredMultiLineCall

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

Route::fallback([HomeController::class, 'error404']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/{category}', [HomeController::class, 'category'])->name('home.category')->where('category', '[0-9]+\-[a-z0-9\-]+');

Route::get('/pro-ucitele', [StaticPageController::class, 'teachers'])->name('static.teachers');
Route::get('/pro-rodice', [StaticPageController::class, 'parents'])->name('static.parents');
Route::get('/kontakt', [StaticPageController::class, 'contact'])->name('static.contact');
Route::get('/markdown-napoveda', [StaticPageController::class, 'markdown'])->name('static.markdown');

Route::get('prihlaseni', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('prihlaseni', [LoginController::class, 'login']);
Route::post('odhlaseni', [LoginController::class, 'logout'])->name('logout');

// Registration Routes...
Route::get('registrace', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('registrace', [RegisterController::class, 'register']);

// Password Reset Routes...
Route::get('zapomenute-heslo', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('zapomenute-heslo/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('zapomenute-heslo/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('zapomenute-heslo', [ResetPasswordController::class, 'reset']);
Route::get('overeni-hesla', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('overeni-hesla', [ConfirmPasswordController::class, 'confirm']);

// Orders
Route::post('objednavka/ares', [OrderController::class, 'fromAres'])->name('orders.ares');
Route::get('objednavka', [OrderController::class, 'createRedirect']);
Route::resource('objednavka', OrderController::class)->only(['create', 'store'])->names('orders');

Route::middleware(['auth'])->group(static function (): void {
    // Profile
    Route::post('profil/access-token', [ProfileController::class, 'regenerateAccessToken'])->name('profile.access_token');
    Route::get('profil', [ProfileController::class, 'profileForm'])->name('profile');
    Route::post('profil', [ProfileController::class, 'update']);

    // Parents
    Route::get('zaci/pridat/{category}', [StudentController::class, 'createForm'])->name('students.create_in_category');
    Route::get('zaci/{student}/odhlasit', [StudentController::class, 'logoutForm'])->name('students.logout');
    Route::post('zaci/{student}/odhlasit', [StudentController::class, 'logout']);
    Route::get('zaci/{student}/odeslane-emaily', [StudentController::class, 'sendEmails'])->name('students.send_emails');
    Route::get('zaci/{student}/odeslane-emaily/{send_email}', [StudentController::class, 'showSendEmail'])->name('students.send_emails.show');
    Route::get('zaci/{student}/potvrzeni/prihlaseni', [StudentController::class, 'certificateLogin'])->name('students.certificate.login');
    Route::get('zaci/{student}/potvrzeni/zaplaceni', [StudentController::class, 'certificatePayment'])->name('students.certificate.payment');
    Route::resource('zaci', StudentController::class)->except('destroy')->names('students')->parameters(['zaci' => 'student']);

    // Admin
    Route::prefix('admin')->name('admin.')->middleware(['can:access-admin-routes'])->group(static function (): void {
        // Users
        Route::get('uzivatele/ajaxlist', [AdminUserController::class, 'ajaxList'])->name('users.ajax_list');
        Route::get('uzivatele/{user}/smazat', [AdminUserController::class, 'delete'])->name('users.delete');
        Route::post('uzivatele/{user}/zablokovat', [AdminUserController::class, 'block'])->name('users.block');
        Route::post('uzivatele/{user}/odblokovat', [AdminUserController::class, 'unblock'])->name('users.unblock');
        Route::resource('uzivatele', AdminUserController::class)->names('users')->parameters(['uzivatele' => 'user']);

        // Orders
        Route::get('objednavky/ajaxlist', [AdminOrderController::class, 'ajaxList'])->name('orders.ajax_list');
        Route::put('objednavky/{order}/vlajecka', [AdminOrderController::class, 'updateFlag'])->name('orders.flag_change');
        Route::resource('objednavky', AdminOrderController::class)->except(['create', 'store'])->names('orders')->parameters(['objednavky' => 'order']);

        // Categories
        Route::post('kategorie/{category}/poradi', [AdminCategoryController::class, 'reorder'])->name('categories.reorder');
        Route::resource('kategorie', AdminCategoryController::class)->names('categories')->parameters(['kategorie' => 'category']);

        // Terms
        Route::get('terminy/ajaxlist', [AdminTermController::class, 'ajaxList'])->name('terms.ajax_list');
        Route::put('terminy/{term}/vlajecka', [AdminTermController::class, 'updateFlag'])->name('terms.flag_change');
        Route::resource('terminy', AdminTermController::class)->names('terms')->parameters(['terminy' => 'term']);

        // Students
        Route::get('prihlasky/ajaxlist', [AdminStudentController::class, 'ajaxList'])->name('students.ajax_list');
        Route::post('prihlasky/{student}/pridat-platbu', [AdminStudentController::class, 'addPayment'])->name('students.add_payment');
        Route::get('prihlasky/{student}/odeslane-emaily', [AdminStudentController::class, 'sendEmails'])->name('students.send_emails');
        Route::put('prihlasky/{student}/odhlaseni', [AdminStudentController::class, 'logout'])->name('students.logout');
        Route::put('prihlasky/{student}/zruseni', [AdminStudentController::class, 'cancel'])->name('students.cancel');
        Route::resource('prihlasky', AdminStudentController::class)->except(['destroy'])->names('students')->parameters(['prihlasky' => 'student']);

        // News
        Route::resource('aktuality', AdminNewsController::class)->except(['show'])->names('news')->parameters(['aktuality' => 'news']);

        // Exports
        Route::get('exporty', [AdminExportController::class, 'index'])->name('exports.index');
        Route::post('exporty/termin', [AdminExportController::class, 'fullTerm'])->name('exports.full_term');
        Route::post('exporty/preplatky-nedoplatky', [AdminExportController::class, 'overUnderPaid'])->name('exports.over_under_paid');
    });

    Route::middleware(['can:access-admin-routes'])->group(static function (): void {
        Route::get('logs', [LogViewerController::class, 'index'])->name('logs');
    });
});

// Maintenance
Route::middleware(['artisan'])->prefix('artisan')->group(static function (): void {
    Route::get('deploy', [ArtisanController::class, 'deploy']);
    Route::get('migration-status', [ArtisanController::class, 'migrationStatus']);
    Route::get('down', [ArtisanController::class, 'down']);
    Route::get('up', [ArtisanController::class, 'up']);
    Route::get('run-failed-jobs', [ArtisanController::class, 'runFailedJobs']);

    // Cron jobs
    Route::get('queue-work', [ArtisanController::class, 'queueWork']);
});
