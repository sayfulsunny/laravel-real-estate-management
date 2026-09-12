<?php

namespace App\Http\Controllers;
use App\Models\IncomeCategory;
use App\Models\Income;
use App\Models\Project;
use Illuminate\Http\Request;


class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $incomes = Income::with('category','project')->latest()->paginate(20);
         return view('pages.incomes.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = IncomeCategory::all();
        $projects = Project::all();
        return view('pages.incomes.create', compact('categories', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
        'name' => 'required|string|max:255',
        'project_id' => 'required|exists:projects,id',
        'income_category_id' => 'required|exists:income_categories,id',
        'amount' => 'required|numeric',
        'date' => 'required|date',
        'description' => 'nullable|string',
    ]);

    Income::create($validated);

    return redirect()->route('incomes.index')->with('success', 'Income added successfully!');
    }
    
    /**
     * Display the income invoice.
     */
    public function invoice($id)
    {
        // Retrieve the income record by ID
        $income = Income::with('category', 'project')->findOrFail($id);

        // Convert the income amount to words
        $amountInWords = $this->convertNumberToWords($income->amount);

        // Return the view with the income data
        return view('pages.incomes.invoice', compact('income', 'amountInWords'));
    }

    /**
     * Convert number to words (for currency).
     */
    protected function convertNumberToWords($number)
    {
        // Create a number formatter for your locale (e.g., English)
        $formatter = new \NumberFormatter('en_IN', \NumberFormatter::SPELLOUT);
        
        // Format the number to words
        return ucfirst($formatter->format($number));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $income = Income::findOrFail($id);
    $categories = IncomeCategory::all();
     $projects = Project::all();
    return view('pages.incomes.edit', compact('income', 'categories','projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $validated = $request->validate([
        'name' => 'required|string|max:255',
        'project_id' => 'required|exists:projects,id',
        'income_category_id' => 'required|exists:income_categories,id',
        'amount' => 'required|numeric',
        'date' => 'required|date',
        'description' => 'nullable|string',
        ]);

        $income = Income::findOrFail($id);
        $income->update($validated);

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $income = Income::findOrFail($id);
    $income->delete();

    return redirect()->route('incomes.index')->with('success', 'Income deleted successfully!');
    }
}
