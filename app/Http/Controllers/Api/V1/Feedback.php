<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Feedback extends Controller
{
     public function feedback(Request $request) {
    $request->validate([
        "feature_love" => "required",
        "recommend" => "required",
    ]);

    // Create 
    $user = CardDetails::create([
        "feature_love" => $request->feature_love,
        "recommend" => $request->recommend,
        "user_email" => $request->user_email,
    ]);

    // Mail::to($user->email)->send(new RegistrationMail($user));

    return response()->json([
        "status" => true,
        "message" => "Feedback Sent Successfully"
        ]);
    }
}
