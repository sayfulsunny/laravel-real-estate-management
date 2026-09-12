<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Project;
use App\Models\Investment;
use Illuminate\Http\Request;
use App\Helpers\NumberToWords;

class InvestmentController extends Controller
{
    // Show all investments
    public function index()
    {
        $investments = Investment::with(['customer', 'project'])->orderBy('id', 'desc')->paginate(20);

        return view('pages.investments.index', compact('investments'));
    }

    // Show form to create investment
    public function create()
    {
        $customers = Customer::all();
        $projects = Project::all();

        return view('pages.investments.create', compact('customers', 'projects'));
    }

    // Store new investment
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:0',
            'invoice_no' => 'nullable|string|max:255',
            'purpose' => 'nullable|string|max:255',
            // 'flat_no' => 'nullable|string|max:255',
            'check_no' => 'nullable|string|max:255',
            'date' => 'nullable|date',
        ]);

        $customer = Customer::findOrFail($request->customer_id);
        $customer->projects()->attach($request->project_id, [
            'amount' => $request->amount,
            'invoice_no' => $request->invoice_no,
            'purpose' => $request->purpose,
            // 'flat_no' => $request->flat_no,
            'check_no' => $request->check_no,
            'date' => $request->date,
        ]);

        $date = $request->date ?? now()->format('Y-m-d');
        $amount = $request->amount;
        $customer = Customer::withSum('investments', 'amount')->findOrFail($request->customer_id);
        $balance = $customer->investments_sum_amount ?? 0;
        $smsContent = "Dear Flat Holder Your A/C has been deposit with BDT {$amount} on {$date}. Balance TK {$balance}. Darut Tawhid Properties. Thank you for your cooperation.";
        $encodedMessage = str_replace("\n", "%0A", urlencode($smsContent));
        $mobileNo = $customer->phone;
        if (!str_starts_with($mobileNo, '+88')) {
            $mobileNo = '+88' . ltrim($mobileNo, '');  // Remove leading zero if any before adding +88
        }

        $apiKey = '$2y$10$r5zU1Ur7/PzTqh4gEud7u.2hp4uscTexiXVYoFJcdQvohwZP7kOfC';
        $maskingID = 'DarutTawhid';
        // Non Masking API URL
        // $url = "http://sms.softghor.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$mobileNo}&smsContent={$encodedMessage}";
        // Masking API URL
        $url = "http://sms.softghor.com/smsapi/masking?api_key={$apiKey}&smsType=unicode&maskingID={$maskingID}&mobileNo={$mobileNo}&smsContent={$encodedMessage}";
        // dd([
        //     'date' => $date,
        //     'amount' => $amount,
        //     'smsContent' => $smsContent,
        //     'mobileNo' => $mobileNo,
        //     'url' => $url,
        // ]);

        $response = file_get_contents($url);

        return redirect()->route('investments.index')->with('success', 'Investment added successfully.');
    }

    // Show form to edit an investment
    public function edit($customerId, $projectId)
    {
        $customer = Customer::findOrFail($customerId);
        $project = $customer->projects()->where('project_id', $projectId)->firstOrFail();

        return view('pages.investments.edit', compact('customer', 'project'));
    }

    // Update investment
    public function update(Request $request, $customerId, $projectId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'invoice_no' => 'nullable|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'check_no' => 'nullable|string|max:255',
            'date' => 'nullable|date',
        ]);

        $customer = Customer::findOrFail($customerId);
        $customer->projects()->updateExistingPivot($projectId, [
            'amount' => $request->amount,
            'invoice_no' => $request->invoice_no,
            'purpose' => $request->purpose,
            'check_no' => $request->check_no,
            'date' => $request->date,
        ]);
       

        return redirect()->route('investments.index')->with('success', 'Investment updated successfully.');
    }

    // Delete investment
    public function destroy($investmentId)
    {
        $investment = Investment::findOrFail($investmentId);
        $investment->delete();
    
        return redirect()->route('investments.index')->with('success', 'Investment deleted successfully.');
    }

    public function projectStatement($id)
    {
        $project = Project::with('customers')->findOrFail($id);

        return view('pages.investments.statements', compact('project'));
    }

    public function invoice($id)
    {
        $investment = Investment::with(['customer', 'project'])->findOrFail($id);
        $amountInWords = NumberToWords::convert($investment->amount) . ' Taka only';
        return view('pages.investments.invoice', compact('investment', 'amountInWords'));
    }



}
