<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\App;

Route::get('/', function () {
    return redirect('/login');
});

// Dashboard (authenticated & verified users only)

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');;

// Group routes that require authentication
Route::middleware(['auth'])->group(function () {
    
    // Profile routes (edit your account)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // View your own profile (optional)
    Route::get('/my-profile', [UserController::class, 'profile'])->name('users.profile');

    // Admin-only user management routes
    // Route::middleware('can:manage users')->group(function () {
       Route::resource('users', UserController::class)->except(['show']);
    // });

    Route::prefix('roles')->name('roles.')->group(function () {
    Route::get('{role}/permissions', [RolePermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('{role}/permissions', [RolePermissionController::class, 'update'])->name('permissions.update');
    });

    // Customer route
    Route::resource('customers', 'App\Http\Controllers\CustomerController')->except('show');
    Route::get('/customers/{customer}/investments',  'App\Http\Controllers\CustomerController@investmentReport')->name('customers.investments');
    
    Route::post('/installment-store', 'App\Http\Controllers\CustomerController@installment')->name('installment.installment');
    Route::post('/installment/toggle-auto/{customer}', 'App\Http\Controllers\CustomerController@toggleAuto')->name('installment.toggleAuto');
    Route::post('/installment/save-amount',  'App\Http\Controllers\CustomerController@saveAmount')->name('installment.saveAmount');
    
    Route::post('/customers/add-auto-installment', 'App\Http\Controllers\CustomerController@addAutoInstallment')->name('customers.add-auto-installment');
    Route::get('/reports/customer-summary',  'App\Http\Controllers\ReportController@customerSummaryReport')->name('reports.customer.summary');

    //Project route
    Route::resource('projects', 'App\Http\Controllers\ProjectController')->except('show');

    Route::resource('investments', 'App\Http\Controllers\InvestmentController')->except('show');
    Route::get('/projects/{id}/statement', 'App\Http\Controllers\InvestmentController@projectStatement')->name('projects.statement');
    Route::get('/investments/{investment}/invoice', 'App\Http\Controllers\InvestmentController@invoice')->name('investments.invoice');

    Route::get('/project/report', 'App\Http\Controllers\ProjectController@report')->name('report.project');
    Route::post('/project/report',  'App\Http\Controllers\ProjectController@generate')->name('project.report.generate');

    //Expense Route
    Route::resource('expenses', 'App\Http\Controllers\ExpenseController')->except('show');
    Route::resource('categories', 'App\Http\Controllers\ExpenseCategoryController')->except('show');
    Route::get('/expenses/{expense}/invoice', 'App\Http\Controllers\ExpenseController@invoice')->name('expenses.invoice');

    Route::get('/expense-report', 'App\Http\Controllers\ReportController@expenseReport')->name('expense.report');
    Route::get('/category-expense-report', 'App\Http\Controllers\ReportController@categoryExpenseReport')->name('category.expense.report');


    // For approval via POST (optional: use PUT or PATCH)
    Route::post('/expenses/{expense}/approve',  'App\Http\Controllers\ExpenseController@approve')->name('expenses.approve');

    // Report Route
    Route::get('/commission-report',  'App\Http\Controllers\ReportController@commissionReport')->name('commission.report');
    Route::post('/commission-withdraw', 'App\Http\Controllers\ReportController@withdraw')->name('commission.withdraw');
    Route::get('/commission-withdrawals', 'App\Http\Controllers\ReportController@withdrawalHistory')->name('commission.withdrawal.history');
    Route::get('/project/{id}/commission-summary', 'App\Http\Controllers\ReportController@projectSummary')
    ->name('project.commission.summary');
    Route::get('/commission-report/download',  'App\Http\Controllers\ReportController@download')->name('commission.report.download');
     Route::get('/reports/yearly', [ReportController::class, 'yearlyReport'])->name('yearly.report');


    //Income Route
    Route::resource('incomes', 'App\Http\Controllers\IncomeController')->except('show');
    Route::resource('income-categories', 'App\Http\Controllers\IncomeCategoryController')->except('show');
    Route::get('incomes/{income}/invoice', 'App\Http\Controllers\IncomeController@invoice')->name('incomes.invoice');

    /**
     * ****************
     * Promotional SMS
     * ****************
     */
    Route::get('promotional-sms', 'App\Http\Controllers\PromotionController@promotion_sms')->name('promotion.sms');
    Route::post('promotional-sms-send', 'App\Http\Controllers\PromotionController@send_promotion_sms')->name('send.promotion.sms');

});

Route::post('/backup/download', [BackupController::class, 'download'])->name('backup.download');
Route::get('/db_reset', function () {
    // Check the env variable `DB_RESET` in your .env file
    // Must be set to 'true' to allow reset via URL
    if (env('DB_RESET', false) !== true && env('DB_RESET', false) !== 'true') {
        abort(403, 'Forbidden.');
    }

    // Reset database and migrate fresh
    Artisan::call('migrate:fresh');

    // Run seeders
    Artisan::call('db:seed');

    return 'Database reset and seeded successfully!';
});

Route::get('/clear', [BackupController::class, 'cache_clear']);


require __DIR__.'/auth.php';
