<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\RegistrationMail;
use App\Mail\LoginMail;
use App\Mail\MeduimPaymentMail;
use App\Mail\PremuimPaymentMail;
use Illuminate\Support\Facades\Mail;
use MailerSend\MailerSend;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;


class ApiController extends Controller
{
        // Register Api(POST)
        public function register(Request $request)
        {
            // Data Validation
            $request->validate([
                "avatar" => "image|max:2048",
                "name" => "required",
                "email" => "required|email|unique:users",
                "phone_number" => "required",
                "password" => "required|confirmed"
            ]);

            // Handle avatar upload and resizing
            if ($request->hasFile('avatar')) {
                    $avatarFile = $request->file('avatar');
                    $avatarSize = $avatarFile->getSize();

                    // Check if the avatar exceeds 2MB
                    if ($avatarSize > 2048000) { // 2MB in bytes (1 MB = 1024 KB = 1024 * 1024 bytes)
                        // Resize the image to reduce file size
                        $image = Image::make($avatarFile)->resize(500, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        // Store the resized avatar
                        $avatarPath = $image->stream()->store('avatars', 'public');
                    } else {
                        // Avatar is within 2MB size limit, store it as usual
                        $avatarPath = $avatarFile->store('avatars', 'public');
                    }
             } else {
                $avatarPath = null;
             }

            // Create User
            $user = User::create([
                "avatar" => $avatarPath,
                "name" => $request->name,
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "password" => Hash::make($request->password)
            ]);

            Mail::to($user->email)->send(new RegistrationMail($user));

            return response()->json([
                "status" => true,
                "message" => "User Created Successfully"
            ]);
        }

        //Update Profile (PUT)
        public function updateprofile()
        {
            // code...
             $request->validate([
                    "avatar" => "image|max:2048",
                    "name" => "required",
                    "email" => "required|email|unique:users",
                    "phone_number" => "required",
                    "password" => "required|confirmed"
                ]);

            $user = User::find($id)
            if ($user) {
                // code...
                "avatar" => $avatarPath,
                "name" => $request->name,
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "password" => Hash::make($request->password),
                $user = update(),
                return response()->json([
                    "status" => true,
                    "message" => "Profile Updated Successfully"
                ]);

            } else {
                return response()->json([
                    "status" => true,
                    "message" => "User Not Found"
                ]);
            }
                
        }

      // Login Api(POST)
      public function login(Request $request)
          {
        // Data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // Attempt authentication
        if (Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ])) {
            $user = Auth::user();

            // Create a new token for the user
            $accessToken = $user->createToken('myToken')->plainTextToken;

            //To send email after user login in successfully
            Mail::to($user->email)->send(new LoginMail($user));

            return response()->json([
                "status" => true,
                "message" => "Login successful",
                'access_token' => $accessToken,
            ]);


        }

        return response()->json([
            "status" => false,
            "message" => "Invalid credentials"
        ]);
    }

    // Define the mapping logic directly in the controller
    private function mapPaymentTypeToSubscriptionStatus($paymentType) {
    // Example mapping logic, replace this with your actual logic
        switch ($paymentType)
    {
            case '1':
                return '1';
            case '2':
                return '2';
            default:
                return '0';
    }
    }

    //Profile Api(POST);
    public function payment(Request $request)
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
            ]);

           // Storing payment data
            $payment = Payment::create([
                "user_id" => $request->user_id,
                "user_name" => $request->user_name,
                "user_email" => $request->user_email,
                "amount" => $request->amount,
                "payment_type" => $request->payment_type,
                "payment_status" => $request->payment_status,
                "payment_method" => $request->payment_method,
                "currency" => $request->currency,
            ]);   

            // Updating user subscription status based on payment type
           $user = User::find($request->user_id);

            if ($user) {
                // Mapping payment type to subscription status
                $subscriptionStatus = $this->mapPaymentTypeToSubscriptionStatus($request->payment_type);
                
                // Update subscription status
                $user->subscribtion_status = $subscriptionStatus;
                $user->save();
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "User was not found"
                ]);
            }

            if ($request->payment_type == 1) {
                Mail::to($payment->user_email)->send(new MeduimPaymentMail($payment));
            } elseif ($request->payment_type == 2) {
               Mail::to($payment->user_email)->send(new PremuimPaymentMail($payment));
            }

            return response()->json([
                "status" => true,
                "message" => "Payment Made Successfully"
            ]);

        }

    // Profile API (GET)
    public function profile()
    {
        $user = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'Profile data',
            'data' => $user,
    ]);
  }


    // Logout API (GET)
    public function logout(Request $request)
    {
        $user = $request->user(); 

        // Revoke all tokens associated with the user
        $user->tokens()->delete();

        // Return a JSON response indicating successful logout
        return response()->json([
            "status" => true,
            "message" => "User logged out"
        ]);
    }

}
