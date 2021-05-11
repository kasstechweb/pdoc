<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployerController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/add_new_employee', [EmployeeController::class, 'addNewEmployee'])->name('add_new_employee');
Route::post('/add_new_employee', [EmployeeController::class, 'storeNewEmployee'])->name('store_new_employee');
Route::get('/view_all_employees', [EmployeeController::class, 'viewAllEmployees'])->name('view_all_employees');

Route::get('/add_new_employer', [EmployerController::class, 'addNewEmployer'])->name('add_new_employer');
Route::post('/add_new_employer', [EmployerController::class, 'storeNewEmployer'])->name('store_new_employer');
