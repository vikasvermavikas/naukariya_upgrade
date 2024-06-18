<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontJobseekerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\FrontuserloginController;
use App\Http\Controllers\UserprofileController;
use App\Http\Controllers\JobmanagerController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('guest:jobseeker')->group(function () {


    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/blog', function () {
        return view('blog');
    })->name('blog');

    Route::get('/single-blog', function () {
        return view('single-blog');
    })->name('single-blog');

    Route::get('/elements', function () {
        return view('elements');
    })->name('elements');

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');

    Route::get('/register', function () {
        return view('register');
    })->name('register');

    Route::get('/login', function () {
        return view('login');
    })->name('login');
    
    Route::get('/', [JobmanagerController::class, 'getJobsByCategory'])->name('home');
});

// jobseeker login
Route::post('jobseekerregister', [FrontJobseekerController::class, 'store'])->name('jobseekerregister');
Route::get('/job_details/{id}', [JobmanagerController::class, 'showSingleJob'])->name('job_details');
Route::get('job_listing', [JobmanagerController::class, 'browsejob'])->name('job_listing');
Route::post('jobseekerlogin', [FrontuserloginController::class, 'login'])->name('jobseekerlogin');
Route::post('/jobseeker-logout', [UserprofileController::class, 'logout'])->name('jobseekerlogout');
