<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\User;

class SocialAuthController extends Controller
{
    public function webSignIn($provider=null)
    {
        if(isNull($provider)) 
        {
            return apiResponse($result=false,$message="Provider is required",$data=null,$code=400);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        try 
        {
            if ($provider == 'twitter') 
            {
                $user = Socialite::driver('twitter')->user();
            } 
            else 
            {
                $user = Socialite::driver($provider)->stateless()->user();
            }
        } 
        catch (\Exception $e) 
        {
            flash("Something Went wrong. Please try again.")->error();
            return redirect(env('FRONTEND_URL', 'http://127.0.0.1:3000') . '/callback?result=false');
        }

        //check if provider_id exist
        // return $user->id;
        $existing_user_by_provider_id = User::where('provider_id', $user->id)->first();
        // return $existingUserByProviderId;

        if ($existing_user_by_provider_id) {
            //proceed to login
            return loginUsingUser($existing_user_by_provider_id,'Logged In Successful');
        } 
        else 
        {
            //check if email exist
            $existing_user = User::where('email', $user->email)->first();

            if ($existing_user) {
                //update provider_id
                $existing_user = $existingUser;
                $existing_user->provider_id = $user->id;
                $existing_user->save();

                //proceed to login
                return loginUsingUser($existing_user,'Logged In Successful');
            } 
            else 
            {
                //create a new user
                $newUser = new User;
                $newUser->signup_by = $provider;
                $newUser->name = $user->name;
                $newUser->email = $user->email;
                $newUser->email_verified_at = date('Y-m-d Hms');
                $newUser->provider_id = $user->id;
                $newUser->save();


                //proceed to login
                auth()->signIn($newUser, true);
            }
        }

    }

    public function appSignIn(Request $request)
    {
        $validation_rules=[
            'provider' => 'required|string|in:facebook,google,apple',

            'access_token' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) 
        {
            $error_arr=$validator->errors()->toArray();
            $firstValue = reset($error_arr)[0];
            return apiResponse($result=false,$message=$firstValue,$data=$error_arr,$code=200);
        }

        $name = 'Guest';
        $email = '';
        $avatar = '';
        $providerId = null;

        switch ($request->provider) 
        {
            case 'facebook':
                $socialUser = Socialite::driver('facebook')
                    ->fields(['name', 'first_name', 'last_name', 'email','picture'])
                    ->userFromToken($request->access_token);
                if ($socialUser) 
                {
                    $name = $socialUser->getName();
                    $email = $socialUser->getEmail();
                    $providerId = $socialUser->getId(); 
                    $avatar = $socialUser->getAvatar();
                }
                break;
            case 'google':
                $socialUser = Socialite::driver('google')
                    ->userFromToken($request->access_token);
                if ($socialUser) 
                {
                    $name = $socialUser->getName();
                    $email = $socialUser->getEmail();
                    $providerId = $socialUser->getId(); 
                    $avatar = $socialUser->getAvatar();
                }
                break;
            case 'apple':
                $idToken = $request->access_token;
                $idTokenParts = explode('.', $idToken);
                $idTokenPayload = json_decode(base64_decode($idTokenParts[1]), true);
                $providerId = $idTokenPayload['sub'];
                $email = $idTokenPayload['email'] ?? ''; 
                $name = $idTokenPayload['name'] ?? 'Guest';
                $avatar = '';
                break;
            default:
                return response()->json([
                    'result' => false,
                    'message' => translate('No social provider matches'),
                    'user' => null
                ]);
        }

        $existingUserByProviderId = User::where('provider_id', $providerId)->first();


        if ($existingUserByProviderId) 
        {
            return loginUsingUser($existingUserByProviderId,"Logged In");
            
        } 
        else 
        {
            if($email != '')
            {
                $old_user = User::where('email',$email)->first();
                if($old_user!='')
                {
                    return loginUsingUser($old_user,"Logged In");
                }
                else
                {
                    $user = new User;
                    $user->signup_by = $request->provider;
                    $user->name = $name;
                    $user->email = $email;
                    $user->provider_id = $providerId;
                    $user->avatar = $avatar;
                    $user->email_verified_at = Carbon::now();
                    $user->save();
                }
            }
            else
            {
                $user = new User;
                $user->name = $name;
                $user->signup_by = $request->provider;
                $user->provider_id = $providerId;
                $user->avatar = $avatar;
                $user->email_verified_at = Carbon::now();
                $user->save();
            }
            
            return loginUsingUser($user,"Logged In");
        }
    }


}
