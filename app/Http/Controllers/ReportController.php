<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\ExpenseEntry;
use App\Models\Investment;
use App\Models\Income;
use App\Models\CommissionWithdrawal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
class ReportController extends Controller
{
    
    public function commissionReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'project_id' => 'nullable|integer|exists:projects,id',
        ]);
    
        $query = \App\Models\Expense::with('project');
    
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
    
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }
    
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }
    
        $allExpenses = $query->get();
        $expenses = $query->orderBy('date', 'desc')
                          ->paginate(20)
                          ->appends($request->except('page'));
    
        $processed = $expenses->getCollection()->map(function($row) {
            return (object)[
                'id' => $row->id,
                'project_id' => $row->project_id,
                'project_name' => $row->project?->name ?? 'Unknown Project',
                'date' => $row->date,
                'description' => $row->description,
                'amount' => $row->amount,
                'commission' => $row->amount * 0.08,
            ];
        });
    
        $expenses->setCollection($processed);
        $totalExpense = $allExpenses->sum('amount');
        $totalCommission = $totalExpense * 0.08;
    
        return view('pages.reports.commission', [
            'commissions' => $expenses,
            'totalExpense' => $totalExpense,
            'totalCommission' => $totalCommission,
        ]);
    }



    public function withdraw(Request $request)
    {
        CommissionWithdrawal::create([
            'project_id' => $request->project_id,
            'commission_date' => $request->commission_date,
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Commission withdrawn successfully!');
    }

    public function withdrawalHistory()
    {
        $withdrawals = CommissionWithdrawal::with('project')
            ->orderBy('created_at', 'desc')
            ->paginate(15); // Optional: Paginate

        return view('pages.reports.withdrawal-history', compact('withdrawals'));
    }

    public function projectSummary($id)
    {
        $project = Project::with('realExpenses')->findOrFail($id);

        // Total Expense
        $totalExpense = $project->realExpenses->sum('amount');

        // Total Commission = 8% of expense
        $totalCommission = $totalExpense * 0.08;

        // Withdrawn Commission
        $withdrawnCommission = CommissionWithdrawal::where('project_id', $project->id)->sum('amount');

        // Remaining Commission
        $remainingCommission = $totalCommission - $withdrawnCommission;

        return view('pages.reports.project-summary', compact(
            'project',
            'totalExpense',
            'totalCommission',
            'withdrawnCommission',
            'remainingCommission'
        ));
    }

    public function expenseReport(Request $request)
    {
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'expense_category_id' => 'nullable|integer|exists:expense_categories,id',
            'project_id' => 'nullable|integer|exists:projects,id',
        ]);

        $query = \App\Models\Expense::query();

        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        if ($request->filled('expense_category_id')) {
            $query->where('expense_category_id', $request->expense_category_id);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $totalExpense = $query->sum('amount');
        $expenses = $query->paginate(20)->appends($request->except('page'));

        return view('pages.reports.expens-report', compact('totalExpense', 'expenses'));
    }

    public function categoryExpenseReport(Request $request)
    {
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'project_id' => 'nullable|integer|exists:projects,id',
        ]);

        $query = \App\Models\Expense::query()->with('category');

        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Get category-wise totals
        $categoryExpenses = $query
            ->select('expense_category_id', \DB::raw('SUM(amount) as total_amount'))
            ->groupBy('expense_category_id')
            ->with('category')
            ->get()
            ->map(function($item) {
                return [
                    'category_name' => $item->category?->name ?? 'Unknown',
                    'total_amount' => $item->total_amount,
                ];
            });

        // Total expense across all categories
        $totalExpense = $categoryExpenses->sum('total_amount');

        return view('pages.reports.category-expense-report', [
            'categoryExpenses' => $categoryExpenses,
            'totalExpense' => $totalExpense,
        ]);
    }

   public function yearlyReport(Request $request)
    {
        // Validate optional date inputs
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
    
        // Get start and end dates, default to full year if not provided
        $startDate = $request->start_date ?? now()->startOfYear()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->endOfYear()->format('Y-m-d');
    
        // Opening balance = sum of all previous investments & incomes - expenses before start date
        $previousInvestment = Investment::whereDate('date', '<', $startDate)->sum('amount');
        $previousIncome = Income::whereDate('date', '<', $startDate)->sum('amount');
        $previousExpense = Expense::whereDate('date', '<', $startDate)->sum('amount');
    
        $openingBalance = ($previousInvestment + $previousIncome) - $previousExpense;
    
        // Total received = investments in the period
        $totalReceived = Investment::whereBetween('date', [$startDate, $endDate])->sum('amount');
    
        // Others received = incomes in the period
        $othersReceived = Income::whereBetween('date', [$startDate, $endDate])->sum('amount');
    
        // Total receivable amount
        $totalReceivable = $openingBalance + $totalReceived + $othersReceived;
    
        // Total expenses in the period
        $totalExpense = Expense::whereBetween('date', [$startDate, $endDate])->sum('amount');
    
        // Closing balance
        $closingBalance = $openingBalance + $totalReceived + $othersReceived - $totalExpense;
    
        // Pass all data to Blade
        return view('pages.reports.yearly', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'openingBalance' => $openingBalance,
            'totalReceived' => $totalReceived,
            'othersReceived' => $othersReceived,
            'totalReceivable' => $totalReceivable,
            'totalExpense' => $totalExpense,
            'closingBalance' => $closingBalance,
        ]);
    }

    public function customerSummaryReport()
    {
        $customers = Customer::withSum('investments', 'amount')
            ->orderBy('serial_no', 'asc')
            ->get();
    
        $customers = $customers->map(function ($customer) {
    
            $currentDeposited = $customer->investments_sum_amount ?? 0;
            $totalWillBePaid = $customer->total_will_be_paid ?? 0;
            $balance = $totalWillBePaid - $currentDeposited;
    
            if ($balance > 0) {
                $status = 'Due';
            } elseif ($balance < 0) {
                $status = 'Advance';
            } else {
                $status = 'Settled';
            }
    
            return [
                'id' => $customer->id,
                'serial_no' => $customer->serial_no,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'totalWillBePaid' => $totalWillBePaid,
                'currentDeposited' => $currentDeposited,
                'balance' => abs($balance),
                'status' => $status,
            ];
        });
    
        $totalWillBeDeposited = $customers->sum('totalWillBePaid');
        $totalCurrentDeposited = $customers->sum('currentDeposited');
        $totalAmount = $customers->sum('balance');
    
        return view('pages.reports.customer_summary', compact(
            'customers',
            'totalWillBeDeposited',
            'totalCurrentDeposited',
            'totalAmount'
        ));
    }

}
