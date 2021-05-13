<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HoursController;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [DashboardController::class, 'viewHome'])->name('home');

// Employee
Route::get('/add_new_employee', [EmployeeController::class, 'addNewEmployee'])->name('add_new_employee');
Route::post('/add_new_employee', [EmployeeController::class, 'storeNewEmployee'])->name('store_new_employee');
//Route::get('/view_all_employees', [EmployeeController::class, 'viewAllEmployees'])->name('view_all_employees');
//Route::post('/employee_hours', [EmployeeController::class, 'storeEmployeeHours'])->name('store_employee_hours');
//Route::post('/employee_hours_history', [EmployeeController::class, 'employeeHoursHistory'])->name('employee_hours_history');

Route::get('/employee/{action}', [HoursController::class, 'allEmployeesView'])->name('view_all_employees');

// hours
Route::any('/add_employee_hours/{id}', [HoursController::class, 'addHours'])->name('add_employee_hours');
Route::any('/view_employee_hours/{id}', [HoursController::class, 'hoursHistoryView'])->name('view_employee_hours');

// Employer
Route::get('/profile', [EmployerController::class, 'viewProfile'])->name('profile');
Route::post('/profile', [EmployerController::class, 'updateProfile'])->name('update_profile');


