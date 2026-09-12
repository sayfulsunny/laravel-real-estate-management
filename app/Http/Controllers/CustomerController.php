<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Investment;
use App\Models\Installment;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        // $customers = $query->withSum('investments', 'amount')->orderBy('id', 'desc')->paginate(20);
           $customers = $query->withSum('investments', 'amount')
        ->orderByRaw('
            CASE WHEN serial_no IS NOT NULL THEN 0 ELSE 1 END, 
            CAST(serial_no AS UNSIGNED) ASC,
            id ASC
        ')
        ->paginate(20);

        return view('pages.customers.index', compact('customers'));
    }


    public function create()
    {
        return view('pages.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|max:5048',
            'flat_quantity' => 'nullable|integer|min:0',
            'serial_no' => 'nullable|integer|unique:customers,serial_no',
        ]);
        

        $imagePath = null;

        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            $imageName = $request->file('profile_image')->getClientOriginalName();
            $request->file('profile_image')->move(public_path('storage/customers'), $imageName);
            $imagePath = 'storage/customers/' . $imageName;
        }

        Customer::create([
            'serial_no' => $request->serial_no,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'flat_quantity' => $request->flat_quantity,
            'profile_image' => $imagePath,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }


    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('pages.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'serial_no' => 'required|integer|unique:customers,serial_no,' . $customer->id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|max:2048',
            'flat_quantity' => 'nullable|integer|min:0',
        ]);

        $imagePath = $customer->profile_image;

        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            // Delete old image file if it exists
            if ($customer->profile_image && file_exists(public_path($customer->profile_image))) {
                unlink(public_path($customer->profile_image));
            }

            $imageName = $request->file('profile_image')->getClientOriginalName();
            $request->file('profile_image')->move(public_path('storage/customers'), $imageName);
            $imagePath = 'storage/customers/' . $imageName;
        }

        $customer->update([
            'serial_no'     => $request->serial_no,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'flat_quantity' => $request->flat_quantity,
            'profile_image' => $imagePath,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }


    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // Check if customer has any investments
        $hasInvestments = $customer->projects()->exists();

        if ($hasInvestments) {
            return redirect()->route('customers.index')
                ->with('error', 'Cannot delete customer with existing investments.');
        }

        // Optionally delete profile image if stored
        if ($customer->profile_image && \Storage::disk('public')->exists($customer->profile_image)) {
            \Storage::disk('public')->delete($customer->profile_image);
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    
    public function investmentReport($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $investments = Investment::where('customer_id', $customerId)
            ->with(['project'])
            ->orderBy('date')
            ->paginate(100)
            ->through(function ($investment) {
                return [
                    'date'    => $investment->date,
                    'amount'  => $investment->amount,
                    'purpose' => $investment->purpose,
                    'project' => $investment->project->name ?? 'N/A',
                ];
            });

        $currentDeposited = Investment::where('customer_id', $customerId)->sum('amount');
        $autoStatus = $customer->auto_installment_status; // 'on' / 'off'
        $autoAmount = ($autoStatus === 'on') ? $customer->auto_installment_amount : 0;
        $totalWillBeDeposited = $customer->total_will_be_paid ?? 0;

        // if ($autoStatus === 'on') {
        //     $totalWillBeDeposited += $autoAmount;
        // }

        $now = \Carbon\Carbon::now();
        $paidThisMonth = Investment::where('customer_id', $customerId)
            ->whereMonth('date', $now->month)
            ->whereYear('date', $now->year)
            ->sum('amount');

        $balance = $totalWillBeDeposited - $currentDeposited;

        // if ($paidThisMonth >= $autoAmount && $autoStatus === 'on') {
        //     $balance = 0;
        //     $totalWillBeDeposited = $currentDeposited;
        // }

        return view('pages.reports.customer_investments', [
            'customer'          => $customer,
            'investments'       => $investments,
            'totalAmount'       => $currentDeposited,
            'autoTotal'         => $autoAmount,
            'totalWillBePaid'   => $totalWillBeDeposited,
            'balance'           => $balance,
            'autoStatus'        => $autoStatus,
        ]);
    }

    public function installment(Request $request)
    {
        $request->validate([
            'auto_installment_amount' => 'required|numeric|min:0',
            'customer_id' => 'required|exists:customers,id'
        ]);

        $customer = Customer::findOrFail($request->customer_id);
        $customer->auto_installment_amount = $request->auto_installment_amount;
        $totalPreviousDeposits = Investment::where('customer_id', $customer->id)->sum('amount');
        $customer->total_will_be_paid = $totalPreviousDeposits + $request->auto_installment_amount;
        $customer->save();

        return back()->with('success', 'Auto installment saved and total updated successfully.');
    }
    
    public function saveAmount(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'total_will_be_paid' => 'required|numeric|min:0',
        ]);
    
        $customer = Customer::findOrFail($request->customer_id);
        $customer->total_will_be_paid = $request->total_will_be_paid;
    
        $customer->save();
    
        return back()->with('success', 'Auto installment amount saved successfully.');
    }

    public function toggleAuto($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $customer->auto_installment_status = ($customer->auto_installment_status === 'on') ? 'off' : 'on';
        $customer->save();

        return back()->with('success', 'Auto Installment status updated!');
    }
    
    
    public function addAutoInstallment()
    {
        Customer::where('auto_installment_status', 'on')
            ->whereNotNull('auto_installment_amount')
            ->update([
                'total_will_be_paid' => DB::raw('total_will_be_paid + auto_installment_amount')
            ]);
    
        return back()->with('success', 'Auto installment added successfully.');
    }

    
   
}
