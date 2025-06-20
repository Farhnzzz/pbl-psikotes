<?php

use App\Http\Controllers\Auth\OauthGoogle;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\AdminOrDoctor;
use App\Http\Middleware\Doctor;
use App\Http\Middleware\PersonalInformation;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
   return view('main');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // profile features
    Route::get('/personal-information', [ProfileController::class, 'editPersonal'])->name('personal.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // exam features
    Route::get('/guides', [HomeController::class, 'guides'])->name('guides');
    Route::get('/about-mmpi2', [HomeController::class, 'aboutMmpi2'])->name('about-mmpi2');
    Route::middleware(PersonalInformation::class)->group(function (){
        Route::get('/history', [HomeController::class, 'examHistory'])->name('examHistory');
        Route::get('/mmpi2', [HomeController::class, 'mmpi2'])->name('mmpi2');
        Route::get('/request-mmpi2', [HomeController::class, 'requestMmpi2'])->name('mmpi2.request');
        Route::get('/question-list', [HomeController::class, 'questionList'])->name('question.list');
        Route::get('/exam/{id}', [HomeController::class, 'viewExamResult'])->name('exam.result');
    });

    // admin & doctor features
    Route::middleware(AdminOrDoctor::class)->group(function (){
        // admin features
        Route::middleware(Admin::class)->group(function(){
            Route::get('/user-list', [HomeController::class, 'manageUser'])->name('manageUser');
            Route::get('/edit-user/{id}', [HomeController::class, 'editUser'])->name('edit.user');
            Route::get('/approve-exam/{id}', [HomeController::class, 'approveExam'])->name('exam.approve');
            Route::get('/delete-exam/{id}', [HomeController::class, 'delete'])->name('exam.delete');
            Route::get('/delete-user/{id}', [HomeController::class, 'deleteUser'])->name('delete.user');
        });

        Route::get('/add-user', [HomeController::class, 'addUser'])->name('add-user.frontend');
        Route::get('/add-exam', [HomeController::class, 'enrollment'])->name('exam.enrollment');
        Route::get('/exams', [HomeController::class, 'exam'])->name('exam.manage');
    });
});

Route::get('/oauth/callback', [OauthGoogle::class, 'handleGoogleCallback'])->name('oauth.callback');
Route::get('/oauth/redirect', [OauthGoogle::class, 'redirectToGoogle'])->name('oauth.redirect');


if (env('APP_ENV') === 'local') {
    Route::get('/login-as/{id}', [ProfileController::class, 'loginAs'])->name('login-as');
}


require __DIR__.'/auth.php';
require __DIR__.'/api.php';
