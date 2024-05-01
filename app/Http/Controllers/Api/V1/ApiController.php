<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\RegistrationMail;
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
            $token = $user->createToken("myToken")->accessToken;

            return response()->json([
                "status" => true,
                "message" => "Login successful",
                "access_token" => $token
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Invalid credentials"
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
    public function logout(){

        // Revoke all tokens...
        $user->tokens()->delete();

        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();
 
        // Revoke a specific token...
        $user->tokens()->where('id', $tokenId)->delete();

        return response()->json([
            "status" => true,
            "message" => "User logged out"
        ]);
    }
}
