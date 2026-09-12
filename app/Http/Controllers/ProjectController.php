<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Investment;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
     public function index()
    {
        $projects = Project::latest()->paginate(20);
        return view('pages.projects.index', compact('projects'));
    }

    // Show form to create a project
    public function create()
    {
        return view('pages.projects.create');
    }

    // Store new project
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        Project::create($request->all());

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    // Show form to edit a project
    public function edit(Project $project)
    {
        return view('pages.projects.edit', compact('project'));
    }

    // Update project
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    // Delete project
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    public function report()
    {
        $projects = Project::all();
        $project = null;
        $investments = collect();
        $expenses = collect();
        $incomes = collect();
        $previousBalance = 0;
        $currentBalance = 0;
        $totalBalance = 0;
        // Summary totals
        $totalInvestment = 0;
        $totalExpense = 0;
        $totalIncome = 0;

        return view('pages.reports.project', compact(
            'projects',
            'project',
            'investments',
            'expenses',
            'incomes',
            'previousBalance',
            'currentBalance',
            'totalBalance',
            'totalInvestment',
            'totalExpense',
            'totalIncome'
        ));
    }



    public function generate(Request $request)
    {
        $projectId = $request->project_id;
        $start = $request->start_date;
        $end = $request->end_date;

        $project = Project::findOrFail($projectId);

        $projects = Project::all();

        if (!$start || !$end) {

            $investments = Investment::with('customer')
                            ->where('project_id', $projectId)
                            ->get();
            $expenses = Expense::where('project_id', $projectId)->get();
            $incomes  = Income::where('project_id', $projectId)->get();
            // Totals
            $totalInvestment = $investments->sum('amount');
            $totalExpense    = $expenses->sum('amount');
            $totalIncome     = $incomes->sum('amount');
            // Current balance = full balance
            $currentInvestment = $totalInvestment;
            $currentExpense    = $totalExpense;
            $currentIncome     = $totalIncome;
            $currentBalance = ($totalInvestment + $totalIncome) - $totalExpense;
            // No previous balance
            $previousBalance = 0;
            // Total = only current
            $totalBalance = $currentBalance;

            return view('pages.reports.project', compact(
                'projects',
                'project',
                'investments',
                'expenses',
                'incomes',
                'currentInvestment',
                'currentExpense',
                'currentIncome',
                'previousBalance',
                'currentBalance',
                'totalBalance',
                'totalInvestment',
                'totalExpense',
                'totalIncome'
            ));
        }

        $investments = Investment::with('customer')
                        ->where('project_id', $projectId)
                        ->whereBetween('date', [$start, $end])
                        ->get();

        $expenses = Expense::where('project_id', $projectId)
                            ->whereBetween('date', [$start, $end])
                            ->get();

        $incomes = Income::where('project_id', $projectId)
                            ->whereBetween('date', [$start, $end])
                            ->get();

        // Current period totals
        $currentInvestment = $investments->sum('amount');
        $currentExpense    = $expenses->sum('amount');
        $currentIncome     = $incomes->sum('amount');

        $currentBalance = ($currentInvestment + $currentIncome) - $currentExpense;
        // Previous balance
        $previousInvestment = Investment::where('project_id', $projectId)
                                        ->where('date', '<', $start)
                                        ->sum('amount');
        $previousExpense = Expense::where('project_id', $projectId)
                                ->where('date', '<', $start)
                                ->sum('amount');
        $previousIncome = Income::where('project_id', $projectId)
                                ->where('date', '<', $start)
                                ->sum('amount');
        $previousBalance = ($previousInvestment + $previousIncome) - $previousExpense;
        // Final total
        $totalBalance = $previousBalance + $currentInvestment + $currentIncome - $currentExpense;
        $totalInvestment = $currentInvestment;
        $totalExpense = $currentExpense;
        $totalIncome = $currentIncome;

        return view('pages.reports.project', compact(
            'projects',
            'project',
            'investments',
            'expenses',
            'incomes',
            'currentInvestment',
            'currentExpense',
            'currentIncome',
            'previousBalance',
            'currentBalance',
            'totalBalance',
            'totalInvestment',
            'totalExpense',
            'totalIncome'
        ));
    }



}
