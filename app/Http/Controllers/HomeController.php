<?php

namespace App\Http\Controllers;
use App\Models\Investment;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
   public function index()
    {
        // Installment totals
        $todaysTotalInstallments = Investment::whereDate('created_at', Carbon::today())->sum('amount');
        $thisMonthsTotalInstallments = Investment::whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year)->sum('amount');
        $totalInstall = Investment::sum('amount');
        $totalIncome = Income::sum('amount');
        
        // ✅ Income totals (using 'date' column)
        $todaysIncome = Income::whereDate('date', Carbon::today())->sum('amount');
        $thisMonthsIncome = Income::whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year)->sum('amount');
        $totalIncome = Income::sum('amount');

        // Expense totals
        $todaysExpenses = Expense::whereDate('created_at', Carbon::today())->sum('amount');
        $thisMonthsExpenses = Expense::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('amount');
        $totalExpenses = Expense::sum('amount');

        // ✅ Total Customers
        $totalCustomers = Customer::count();
        // $totalInstallments = Investment::count();
        $totalBalance = ($totalInstall + $totalIncome) - $totalExpenses;

        return view('dashboard', compact(
            'todaysTotalInstallments',
            'thisMonthsTotalInstallments',
            'totalInstall',
            'todaysIncome',
            'thisMonthsIncome',
            'totalIncome',
            'todaysExpenses',
            'thisMonthsExpenses',
            'totalExpenses',
            'totalCustomers',
            'totalBalance'
        ));
    }

}
