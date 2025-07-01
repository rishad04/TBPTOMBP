<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['status' => __($status)]);
    }

    public function checkUser(Request $request)
    {
        // my code
        $country_code=env('FIXED_COUNTRY_CODE')?? $this->input('country_code');
        $auth_index_name=env('AUTH_PHONE_SUPPORT')? 'email_or_phone':'email';
        $email_or_phone=$request->$auth_index_name;

        $user = \App\Models\User::where(function ($query1) use($email_or_phone,$country_code) {
                        $query1->where(function ($query2) use($email_or_phone) {
                            $query2->whereIn('signup_by', ['email','both'])
                                  ->where('email',$email_or_phone);
                        })
                        ->orWhere(function ($query3) use($email_or_phone,$country_code) {
                            $query3->whereIn('signup_by', ['phone','both'])
                                  ->where('country_code',$country_code)
                                  ->where('phone',$email_or_phone);
                        });
                    })
                    ->first();

        if (!$user) {
            return apiResponse(false, 'No User Found With This Credentials', [], 404);
        }

        return apiResponse(true, 'User Found!', $user, 200);
    }


    public function sendForgotPassOtpToEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid email format.'], 422);
        }

        $email = $request->email;

        // Delete old OTPs for this email
        DB::table('otps')->where('email', $email)->where('type', 'password-recovery')->delete();


        // Generate 6 digit OTP
        $otp = rand(100000, 999999);

        // Save to DB
       DB::table('otps')->insert([
            'country_code' => env('FIXED_COUNTRY_CODE') ?? '+88',
            'phone' => '',
            'email' => $email,
            'otp' => $otp,
            'type' => 'password-recovery',
            'send_to' => $email,
            'created_at' => \Carbon\Carbon::now(),
        ]);


        // TODO: You can customize the mail template
        // Mail::raw("Your OTP for password recovery is: $otp", function ($message) use ($email) {
        //     $message->to($email)->subject('Password Recovery OTP');
        // });

        return apiResponse(true, 'OTP sent to email.', [], 200 );
    }

    public function sendForgotPassOtpToPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid phone or country code.'], 422);
        }

        $phone = $request->phone;
        $countryCode = env('FIXED_COUNTRY_CODE') ?? '+88';

        // Delete old OTPs for this phone
        DB::table('otps')->where('phone', $phone)->where('type', 'password-recovery')->delete();

        // Generate 6 digit OTP
        $otp = rand(100000, 999999);

        // Save to DB
        DB::table('otps')->insert([
            'country_code' => $countryCode,
            'phone' => $phone,
            'email' => '',
            'otp' => $otp,
            'type' => 'password-recovery',
            'send_to' => $phone,
            'created_at' => Carbon::now()
        ]);

        // TODO: Send SMS here using your preferred provider (e.g. Twilio, Nexmo)
        // Example placeholder:
        // SmsService::send($countryCode . $phone, "Your OTP for password recovery is: $otp");

       return apiResponse(true, 'OTP sent to phone.', [], 200 );
    }

    public function verifyResetPasswordOtp (Request $request) {
        // check in otps table that the incoming otp is matching or not if mathing allow to next step showing password rest form
        // dd($request->all());
         $request->validate([
            'otp'      => 'required|string|digits:6', // Assuming a 6-digit OTP
            'send_to'  => 'required|string', // This will be the email or phone number
            'type'     => 'required|string|in:password-recovery', // Ensure it's for password recovery
        ]);

        $otpValue = $request->input('otp');
        $sendTo = $request->input('send_to'); // The email or phone number that received the OTP
        $type = $request->input('type');     // The type of OTP, e.g., 'password-recovery'

        // 2. Find the OTP record in the database
        $otpRecord = DB::table('otps')->where('otp', $otpValue)
                        ->where('send_to', $sendTo)
                        ->where('type', $type)
                        // Add an expiration check (e.g., OTP valid for 10 minutes)
                        ->where('created_at', '>=', now()->subMinutes(10))
                        ->first();

        // 3. Check if the OTP record was found and is valid
        if ($otpRecord) {
            // OTP is valid. Delete it to prevent reuse (important for security).
            DB::table('otps')
                ->where('id', $otpRecord->id) // Use the ID of the found record to delete it
                ->delete();

            return response()->json([
                'result'  => true,
                'code'    => 200,
                'message' => 'OTP verified successfully. Proceed to password reset.'
            ]);
        } else {
            // OTP is invalid, expired, or doesn't match the provided 'send_to'/'type'.
            return response()->json([
                'result'  => false,
                'code'    => 400,
                'message' => 'Invalid or expired OTP. Please try again.'
            ], 400);
        }

    }

    public function resetPassword (Request $request) {

        // dd($request->all());
       // send the user here 
       // validate the user exist
       // update the users pass word with request password and password_confirm

       // 1. Validate the incoming request data
        // $request->validate([
        //     'userId'           => 'required|numeric|exists:users,id', // Ensure user ID exists in the 'users' table
        //     'new_password'     => 'required|string|min:6|confirmed', // 'confirmed' checks for 'new_password_confirmation' field
        //     // The 'confirmed' rule automatically looks for a field named 'new_password_confirmation'.
        //     // If your frontend sends 'confirm_password', you need to adjust this rule or rename the field.
        //     // Let's assume your frontend sends 'confirm_password', so we'll use a custom rule or manual check.
        //     'confirm_password' => 'required|string|same:new_password', // Manually check if confirm_password matches new_password
        // ], [
        //     'new_password.min' => 'The new password must be at least 6 characters long.',
        //     'confirm_password.same' => 'The new password and confirm password do not match.',
        // ]);

        $userId = $request->input('userId');
        $newPassword = $request->input('new_password');

        // 2. Find the user
        $user = User::find($userId);


        // This check is already done by 'exists:users,id' validation rule,
        // but it's good practice to have it explicitly before using $user.
        if (!$user) {
            return response()->json([
                'result'  => false,
                'code'    => 404,
                'message' => 'User not found.'
            ], 404);
        }

        // 3. Update the user's password
        try {
            $user->password = Hash::make($newPassword); // Hash the new password
            $user->save(); // Save the updated user record

            return response()->json([
                'result'  => true,
                'code'    => 200,
                'message' => 'Your password has been successfully reset!'
            ]);
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            Log::error("Password reset failed for user ID {$userId}: " . $e->getMessage());

            return response()->json([
                'result'  => false,
                'code'    => 500,
                'message' => 'Failed to reset password. Please try again.'
            ], 500);
        }

    }
}
