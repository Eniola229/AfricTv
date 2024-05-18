<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdsPayment;

class AdsPaymentController extends Controller
{  
    public function adsPayment(Request $request)
    {
        // Data Validation
        $request->validate([
            "user_id" => "required",
            "user_name" => "required",
            "user_email" => "required|email",
            "amount" => "required",
            "payment_type" => "required",
            "payment_status" => "required",
            "payment_method" => "required",
            "currency" => "required",
            "ads_type" => "required",
            "duration" => "required",
        ]);

        // Storing payment data
        $payment = AdsPayment::create([
            "user_id" => $request->user_id,
            "user_name" => $request->user_name,
            "user_email" => $request->user_email,
            "amount" => $request->amount,
            "payment_type" => $request->payment_type,
            "payment_status" => $request->payment_status,
            "payment_method" => $request->payment_method,
            "currency" => $request->currency,
            "ads_type" => $request->ads_type,
            "duration" => $request->duration,
        ]);

        return response()->json([
            "status" => true,
            "message" => "Ads Payment Made Successfully"
        ]);
    }
}
