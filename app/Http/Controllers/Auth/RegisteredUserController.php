<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)//: Response
    {

        // dd($request->all());
        $auth_index_name=env('AUTH_PHONE_SUPPORT')? 'email_or_phone':'email';
        $fixed_country_code=env('FIXED_COUNTRY_CODE');

        $user = new User;
        $user->name = $request->name;
        $user->country_code = $fixed_country_code;
        $user->signup_by = 'both';
        $user->notify_by = 'both';
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->password = Hash::make($request->password);
        $user->save();


        // event(new Registered($user));

        Auth::login($user);

        // return apiResponse($result=true,$message="Registration Successfull",$data=null,$code=201);
        return redirect('/landing');
    }
}
