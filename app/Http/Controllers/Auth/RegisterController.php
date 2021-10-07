<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Events\Auth\UserActivation;
use GuzzleHttp\Client;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_telp' => ['required', 'unique:users'],
            'role' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'no_telp' => $data['no_telp'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
            'activation_code' => substr(str_shuffle(123456789), 0, 6),
            'isVerified' => false,
        ]);
    }

    /**
     * Ketika user sudah melakukan registrasi
     * 
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user) {
        event(new UserActivation($user));
        $this->guard()->logout();
        $client = new Client(['base_uri' => 'https://sendtalk-api.taptalk.io']);
        $response = $client->request('POST', '/api/v1/message/send_whatsapp', [
            'headers' => [
                'Content-Type' => 'application/json',
                'API-Key' => '1811c01c2cf1baac13e5df4162fa8721d5f02bdbab2b3d722f639b7f7fb8bdfe'
            ],
            'json' => [
            'phone' => $user->no_telp,
            'messageType' => "otp",
            'body' => "Terimakasih telah melakukan registrasi LANDPRO.\n\nKode OTP kamu adalah ".$user->activation_code."\n\n"."Jangan berikan kode ini pada siapapun."
        ]]);
        return view('auth.otp', ['user' => $user]);
    }
}
