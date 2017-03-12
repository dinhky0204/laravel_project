<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Symfony\Component\Console\Input\Input;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function register(Request $request) {
        $input = $request->all();
        $validator = $this->validator($input);
        if($validator->fails()) {
            return redirect()->back()->withInput()->with('register_error', $validator->messages());
//            return redirect(route('login'))->with('login_error', $validator->messages());
        }
        else
        {
            User::where('email', $input['email'])->where('confirmed', 0)->delete();
            $data = $this->create($input)->toArray();
            $minutes = 120;
            $random_token = str_random(30);
            $data['token'] = $random_token;
            Cache::add($random_token, $data['email'], $minutes);
            Mail::send('mails.confirmation', $data, function ($message) use($data) {
                $message->to($data['email']);
                $message->subject('Registration Confirmation');
            });
            return redirect(route('login'))->with('status', 'Confirmation email has been send. Please check your email.');
        }

    }
    public function confirmation($token) {
        $value = Cache::get($token);
        if (!is_null($value)) {
            $user = User::where('email', $value)->first();
            $user->confirmed = 1;
            $user->save();
            return redirect(route('home'))->with('status', 'Your activation is completed.');
        }
        return redirect(route('login'))->with('status', 'Something went wrong.');
    }

}
