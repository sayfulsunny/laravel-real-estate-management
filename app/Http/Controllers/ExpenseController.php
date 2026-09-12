<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\Project;
use App\Models\User;
use App\Models\ExpenseCategory;
use App\Models\ExpenseEntry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NumberToWords;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('project')->latest()->paginate(20);
        return view('pages.expenses.index', compact('expenses'));
    }

    public function create()
    {
        $projects = Project::all();
        $categories = ExpenseCategory::all();

        return view('pages.expenses.create', compact('projects', 'categories'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'expense_name' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'check_no' => 'nullable|string|max:255',
            'date' => 'required|date',
            'voucher_no' => 'required|string|max:100|unique:expenses,voucher_no',
            'description' => 'nullable|string',
        ]);

        Expense::create([
            'project_id' => $request->project_id,
            'expense_category_id' => $request->expense_category_id,
            'expense_name' => $request->expense_name,
            'amount' => $request->amount,
            'check_no' => $request->check_no,
            'date' => $request->date,
            'voucher_no' => $request->voucher_no,
            'description' => $request->description,
            'is_approved' => false, // default — pending approval
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense created and awaiting approval.');
    }

    public function invoice(Expense $expense)
    {
        $amountInWords = NumberToWords::convert($expense->amount) . ' Taka only';
        return view('pages.expenses.invoice', compact('expense', 'amountInWords'));
    }




    public function edit(Expense $expense)
    {
        $projects = Project::all();
        $categories = ExpenseCategory::all();
        return view('pages.expenses.edit', compact('expense', 'projects', 'categories'));
    }

    // Update expense (no re-approval required here)
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
        'project_id' => 'required|exists:projects,id',
        'expense_category_id' => 'required|exists:expense_categories,id',
        'expense_name' => 'required|string|max:255',
        'amount' => 'required|string|max:255',
        'check_no' => 'nullable|string|max:255',
        'date' => 'required|date',
        'voucher_no' => 'required|string|max:100|unique:expenses,voucher_no',
        'description' => 'nullable|string',
         ]);

        $expense->update([
        'project_id' => $request->project_id,
        'expense_category_id' => $request->expense_category_id,
        'expense_name' => $request->expense_name,
        'amount' => $request->amount,
        'check_no' => $request->check_no,
        'date' => $request->date,
        'voucher_no' => $request->voucher_no,
        'description' => $request->description,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense updated.');
    }

    // Delete an expense
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted.');
    }

    // Approve pending expense (by admin password)
    // Approve expense (admin only)
    public function approve(Request $request, Expense $expense)
    {
        $request->validate([
            'admin_password' => 'required|string',
        ]);

        $user = Auth::user();

        // Check if user is admin and password is correct
        if (!$user || !$user->is_admin || !Hash::check($request->admin_password, $user->password)) {
            return back()->withErrors(['admin_password' => 'Incorrect admin password or unauthorized.']);
        }

        // Prevent double approval
        if ($expense->is_approved) {
            return back()->withErrors(['expense' => 'This expense has already been approved.']);
        }

        // Mark expense as approved
        $expense->update(['is_approved' => true]);

        // Create the accounting entry
        $this->postExpenseEntry($expense);

        return redirect()->route('expenses.index')->with('success', 'Expense approved and posted successfully.');
    }

    protected function postExpenseEntry(Expense $expense)
    {
        ExpenseEntry::create([
            'project_id' => $expense->project_id,
            'expense_id' => $expense->id,
            'description' => $expense->expense_name,
            'amount' => ($expense->amount), 
            'type' => 'expense',
        ]);
    }

}
