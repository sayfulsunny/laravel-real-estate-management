<?php

namespace App\Http\Controllers;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::latest()->paginate(10);
        return view('pages.categories.index', compact('categories'));
    }

    // Show create form
    public function create()
    {
        return view('pages.categories.create');
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:expense_categories,name',
        ]);

        ExpenseCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    // Show edit form
    public function edit(ExpenseCategory $category)
    {
        return view('pages.categories.edit', compact('category'));
    }

    // Update category
    public function update(Request $request, ExpenseCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:expense_categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    // Delete category
    public function destroy(ExpenseCategory $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}
