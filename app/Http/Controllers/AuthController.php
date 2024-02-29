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
            'token' => 'required|string',
        ]);
        $userToken = $request->input('token');
        $applicationToken = 'NP7YODEYB8AWhEwzJuyRdEWA1y4AgSLAiqCeFbbu';
        $applicationSecret = 'GQ8AkwkP0NiJDlT9MgBwvc2eCa9QROnL9oTJET1r';
        $response = Http::get('https://api.mcsplash.ru/api/users/'.$userToken.'/'.$applicationToken.'/'.$applicationSecret);

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
