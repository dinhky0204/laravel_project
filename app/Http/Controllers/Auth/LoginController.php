<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    public function username() {
        return 'username';
    }
    public function guard() {
//        return Auth::guard('guard-name');
        Auth::logout();
        return redirect(route('home'));
    }
    public function authenticate() {
        if (Auth::attempt(['email' => $email, 'password' => $password, 'confirmed' => 1 ])) {
            // Authentication passed...
//            return redirect()->intended('dashboard');
            return redirect(route('login'))->with('login_error','Login successfull');
        }
        else {
            return redirect(route('login'))->with('login_error','Email or Password missing.');
        }
    }
    public function login(Request $request) {
        $input = $request->all();
//        var_dump($input); die();
        $email = $input['email'];
        $password = $input['password'];
        if (Auth::attempt(['email' => $email, 'password' => $password, 'confirmed' => 1 ])) {
            return view('login')->with('login_error','Email or Password missing.');
        }
        else
            return redirect()->back()->with('login_error','Email or Password missing.');

    }
    public function logout() {
        Auth::logout();
//        return redirect(route('home'));
        return view('auth/passwords/reset');
    }

}

