<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FuelLogController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ReportController;
use App\Models\ActivityLog;

/*
|--------------------------------------------------------------------------
| ОТЧЁТЫ
|--------------------------------------------------------------------------
*/

// Затраты
Route::get('/reports/maintenance', [ReportController::class, 'maintenance'])
    ->name('reports.maintenance');

Route::get('/reports/maintenance/pdf', [ReportController::class, 'maintenancePdf'])
    ->name('reports.maintenance.pdf');

// Список автомобилей
Route::get('/reports/vehicles', [ReportController::class, 'vehicles'])
    ->name('reports.vehicles');

Route::get('/reports/vehicles/pdf', [ReportController::class, 'vehiclesPdf'])
    ->name('reports.vehicles.pdf');

// Автомобили, требующие ТО
Route::get('/reports/need-maintenance', [ReportController::class, 'needMaintenance'])
    ->name('reports.needMaintenance');

Route::get('/reports/need-maintenance/pdf', [ReportController::class, 'needMaintenancePdf'])
    ->name('reports.needMaintenance.pdf');


/*
|--------------------------------------------------------------------------
| АВТОРИЗАЦИЯ
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/test-login', function () {

    $user = \App\Models\User::where('email','admin@mail.com')->first();

    if (\Hash::check('password', $user->password)) {
        \Auth::login($user);
        return "LOGIN OK";
    }

    return "PASSWORD FAIL";
});


/*
|--------------------------------------------------------------------------
| Главная → Панель
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('dashboard'));

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Администратор
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'create', 'store']);
    Route::resource('vehicles', VehicleController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'create', 'store']);

    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
        ->name('users.updateRole');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/logs', function () {
        return view('admin.logs', [
            'logs' => ActivityLog::latest()->limit(50)->get()
        ]);
    })->name('admin.logs');

});

/*
|--------------------------------------------------------------------------
| Оператор
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:operator'])->group(function () {
    Route::get('/operator/vehicles', [VehicleController::class, 'index'])
        ->name('operator.vehicles');
});


/*
|--------------------------------------------------------------------------
| Водитель — личная панель
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:driver'])->group(function () {
    Route::get('/my-vehicle', [DashboardController::class, 'index'])
        ->name('driver.myvehicle');
});


/*
|--------------------------------------------------------------------------
| УЧЁТ ТОПЛИВА
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/vehicles/{vehicle}/fuel', [FuelLogController::class, 'index'])
        ->name('fuel.index');

    Route::get('/vehicles/{vehicle}/fuel/add', [FuelLogController::class, 'create'])
        ->name('fuel.create');

    Route::post('/vehicles/{vehicle}/fuel', [FuelLogController::class, 'store'])
        ->name('fuel.store');
});


/*
|--------------------------------------------------------------------------
| ТО
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/vehicles/{vehicle}/maintenance', [MaintenanceController::class, 'index'])
        ->name('maintenance.index');

    Route::get('/vehicles/{vehicle}/maintenance/create', [MaintenanceController::class, 'create'])
        ->name('maintenance.create');

    Route::post('/vehicles/{vehicle}/maintenance', [MaintenanceController::class, 'store'])
        ->name('maintenance.store');
});


/*
|--------------------------------------------------------------------------
| РЕМОНТЫ
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/vehicles/{vehicle}/repairs', [RepairController::class, 'index'])
        ->name('repairs.index');

    Route::get('/vehicles/{vehicle}/repairs/create', [RepairController::class, 'create'])
        ->name('repairs.create');

    Route::post('/vehicles/{vehicle}/repairs', [RepairController::class, 'store'])
        ->name('repairs.store');
});


/*
|--------------------------------------------------------------------------
| ПОЕЗДКИ 
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:driver'])->group(function () {

    // список поездок
    Route::get(
        '/vehicles/{vehicle}/trips',
        [TripController::class, 'index']
    )->name('trips.index');

    // форма создания вручную
    Route::get(
        '/vehicles/{vehicle}/trips/create',
        [TripController::class, 'create']
    )->name('trips.create');

    // сохранить созданную вручную
    Route::post(
        '/vehicles/{vehicle}/trips',
        [TripController::class, 'store']
    )->name('trips.store');

    // начать поездку
    Route::post(
        '/vehicles/{vehicle}/trips/start',
        [TripController::class, 'start']
    )->name('trips.start');

    // завершить поездку
    Route::patch(
        '/trips/{trip}/finish',
        [TripController::class, 'finish']
    )->name('trips.finish');

    // удалить поездку
    Route::delete(
        '/trips/{trip}',
        [TripController::class, 'destroy']
    )->name('trips.destroy');
    
});
