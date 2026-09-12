<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
   public function promotion_sms()
    {
        $apiKey = '$2y$10$r5zU1Ur7/PzTqh4gEud7u.2hp4uscTexiXVYoFJcdQvohwZP7kOfC';
        $balanceUrl = "http://sms.softghor.com/api/balance?api_key={$apiKey}";

        $smsBalance = null;
        $rawResponse = null;

        try {
            // Use curl so we can inspect headers, errors
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $balanceUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Optionally set Accept header if API supports JSON vs XML
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
            ]);
            $rawResponse = curl_exec($ch);
            $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($rawResponse === false) {
                // cURL error
                throw new \Exception("cURL error: " . $curlError);
            }

            // Debug: log or dd raw response and status
            // dd(compact('rawResponse', 'httpStatus'));

            // Try parse JSON
            $data = json_decode($rawResponse, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                // JSON parse succeeded
                // The balance might be in different places
                if (isset($data['balance'])) {
                    $smsBalance = $data['balance'];
                } elseif (isset($data['data']['balance'])) {
                    $smsBalance = $data['data']['balance'];
                } elseif (isset($data['data']['amount'])) {
                    $smsBalance = $data['data']['amount'];
                } else {
                    // Unexpected JSON structure
                    $smsBalance = "Balance not found in JSON response";
                }
            } else {
                // Not JSON: maybe it's XML or plain text
                // Try parse as XML
                libxml_use_internal_errors(true);
                $xml = simplexml_load_string($rawResponse);
                if ($xml !== false) {
                    // Convert to JSON then to array
                    $jsonFromXml = json_encode($xml);
                    $xmlArr = json_decode($jsonFromXml, true);
                    // Try find balance in xmlArr
                    // This depends on how API returns xml structure
                    if (isset($xmlArr['balance'])) {
                        $smsBalance = $xmlArr['balance'];
                    } elseif (isset($xmlArr['data']['balance'])) {
                        $smsBalance = $xmlArr['data']['balance'];
                    } else {
                        $smsBalance = "Balance not found in XML response";
                    }
                } else {
                    // Not JSON or XML: plain text?
                    $smsBalance = $rawResponse;
                }
            }
        } catch (\Exception $e) {
            $smsBalance = "Error: " . $e->getMessage();
        }

        $customers = Customer::all();

        return view('pages.promotion.sms', [
            'customers' => $customers,
            'smsBalance' => $smsBalance,
            'rawResponse' => $rawResponse,  // for debugging if needed
        ]);
    }


    public function send_promotion_sms(Request $request)
    {
        $request->validate([
            'customers' => 'required',
            'sms' => 'required|string|max:159'
        ]);

        foreach ($request->customers as $key => $cId) {
            $customer = Customer::findOrFail($cId);
            $sms_body = "Dear " . $customer->name . ",\n" . $request->sms;
            $mobile_number = "88" . $customer->phone;
            $api_key = '$2y$10$r5zU1Ur7/PzTqh4gEud7u.2hp4uscTexiXVYoFJcdQvohwZP7kOfC';
            $maskingID = 'DarutTawhid';

            if ($mobile_number != null) {
                $url = "http://sms.softghor.com/smsapi/masking?api_key={$api_key}&smsType=unicode&maskingID={$maskingID}&mobileNo={$mobile_number}&smsContent=" . urlencode($sms_body);

                $ch = curl_init($url); // such as http://example.com/example.xml
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $data = curl_exec($ch);
                curl_close($ch);
            }
        }
        
        if(isset($data) && $data != 1003){
            session()->flash('success', 'Promotional SMS send successfully.');
        } else {
            session()->flash('error', 'Something went wrong. Promotional SMS can\'t be send.');
        }

        return back();
    }
}
