<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\UserController;
use App\Models\User;
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

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/ajax/list/filter', [DashboardController::class, 'ajaxList'])->name('ajax.list.filter');
Route::get('/ajax/fetch/code', [DashboardController::class, 'fetchWholeCode'])->name('ajax.fetch.code');

//FOR NOT AUTH USERS
Route::middleware(['guest'])->group(function () {
    /** LOGIN */
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    /** REG*/
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register'])->name('register.post');
});

//FOR AUTH USERS
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    //CODE CRUD
    Route::get('/codes', [UserController::class, 'showUserCodes'])->name('user.codes');
    Route::get('/codes/create', [UserController::class, 'showCreateCode'])->name('user.code.create.show');
    Route::post('/codes/create', [UserController::class, 'createCode'])->name('user.code.create');
    Route::get('/codes/edit/{code}', [UserController::class, 'editCode'])->name('user.code.edit');
    Route::get('/codes/archive/{code}', [UserController::class, 'archiveCode'])->name('user.code.archive');
    Route::get('/codes/delete/{code}', [UserController::class, 'deleteCode'])->name('user.code.delete');
    Route::post('/codes/update/{code}', [UserController::class, 'updateCode'])->name('user.code.update');
    Route::get('code/archive', [UserController::class, 'showArchive'])->name('user.codes.archive');
    Route::get('code/archive/restore/{code}', [UserController::class, 'restoreCode'])->name('user.code.archive.restore');

    //SNIPPET
    Route::get('/snippets/{snippet}', [UserController::class, 'deleteSnippet'])->name('user.snippet.delete');

    //ROW CATEGORY
    Route::get('/row/category/new', [UserController::class, 'showCreateRowCategory'])->name('user.codeCategory.create.show');
    Route::post('/row/category/new', [UserController::class, 'createRowCategory'])->name('user.codeCategory.create');
});

//FOR ADMIN ROUTES
Route::middleware(['auth', 'check.role:' . User::ROLE_ADMIN])->group(function () {
    Route::get('/admin', [AdminController::class, 'showPendingCodesForApproval'])->name('admin.show.approve');

    Route::post('/admin/approve/{code}', [AdminController::class, 'approveCode'])->name('admin.approve');
});

//LANGUAGE CHANGE
Route::get('/lang/{locale}', function ($local){
    session()->put('locale', $local);

    return redirect()->back();
})->name('lang');
