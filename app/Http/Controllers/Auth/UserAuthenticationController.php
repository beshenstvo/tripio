<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthenticationController extends Controller
{
    // use AuthenticatesUsers;

    // protected $redirectTo = '/';

    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }
    
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Неверный логин или пароль',
                'success' => false
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        if($user->role != 'user') {
            return response()->json([
                'message' => "Ваша роль: ".$user->role.", ссылка для авторизации иная",
                'success' => false
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User login successfully',
            'success' => true,
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8'],
            'confirm_password' => 'required|same:password'
        ]);
        
        $userDetails = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];
        
        $user = User::create($userDetails);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User register successfully',
            'success' => true,
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function isAdmin()
    {
        return $this->user()->role === 'admin';
    }

    public function isUser()
    {
        return $this->user()->role === 'user';
    }

    public function isGuide()
    {
        return $this->user()->role === 'guide';
    }
}
