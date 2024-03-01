<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'code' => 'required|string',
        ]);
        $code = $request->input('code');
        $applicationToken = 'YOUR_APPLICATION_TOKEN_HERE';
        $applicationSecret = 'YOUR_APPLICATION_SECRET_HERE';
        $response = Http::get('https://api.mcsplash.ru/api/users/token/'.$code.'/'.$applicationToken.'/'.$applicationSecret);
        if ($response->successful()) {
            $userToken = $response['token'];
        }

        if ($response->successful()) {
            $user = User::where('splashid', $userToken)->first();
            if ($user){
                Auth::login($user);
            } else {
                $newUser = new User();
                $newUser->splashid = $userToken;
                $newUser->save();
                Auth::login($newUser);
            }
            return redirect('/');
        } else {
            return 'Token is invalid';
        }
    }
}
