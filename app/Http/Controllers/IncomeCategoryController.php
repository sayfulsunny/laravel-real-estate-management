<?php

namespace App\Http\Controllers;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;

class IncomeCategoryController extends Controller
{
    public function index()
    {
       $categories = IncomeCategory::latest()->paginate(20); 
        return view('pages.income_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.income_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:income_categories,name',
        ]);

        IncomeCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('income-categories.index')->with('success', 'Category added successfully!');
    }

    public function edit(IncomeCategory $income_category)
    {
        return view('pages.income_categories.edit', compact('income_category'));
    }

    public function update(Request $request, IncomeCategory $income_category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:income_categories,name,' . $income_category->id,
        ]);

        $income_category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('income-categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(IncomeCategory $income_category)
    {
        $income_category->delete();
        return redirect()->route('income-categories.index')->with('success', 'Category deleted successfully!');
    }
}
