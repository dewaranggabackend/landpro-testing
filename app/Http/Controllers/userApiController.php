<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Validator;
use Auth;
use Hash;
use App\Models\User;
use GuzzleHttp\Client;

class userApiController extends BaseController
{

    public function profile (Request $request) {
        return $this->responseOk($request->user());
    }

    public function sorry () {
        return $this->responseError('Maaf, anda belum login', 400);
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return $this->responseOk('Logged out', 200);
    }

    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'no_telp' => ['required', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->responseError('Registration failed', 422, $validator->errors());
        }

        $kode = substr(str_shuffle(123456789), 0, 6);
        $client = new Client(['base_uri' => 'https://sendtalk-api.taptalk.io']);
        $response = $client->request('POST', '/api/v1/message/send_whatsapp', [
            'headers' => [
                'Content-Type' => 'application/json',
                'API-Key' => '1811c01c2cf1baac13e5df4162fa8721d5f02bdbab2b3d722f639b7f7fb8bdfe'
            ],
            'json' => [
            'phone' => $request->no_telp,
            'messageType' => "otp",
            'body' => "Terimakasih telah melakukan registrasi LANDPRO.\n\nKode OTP kamu adalah ".$kode."\n\nJangan berikan kode ini pada siapapun."
        ]]);

        $params = [
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'role' => 3,
            'password' => Hash::make($request->password),
            'isVerified' => 0,
            'activation_code' => $kode,
        ]; 

        if ($user = User::create($params)) {
            $token = $user->createToken('Token')->accessToken;

            $response = [
                'token' => $token,
                'user' => $user
            ];

            return $this->responseOk($response);
        } else {
            return $this->responseError('Registration failed', 400);
        }
    }

    public function login (Request $request) {
        $data = \App\Models\User::where('email', $request->email)->get();

        return response()->json($data);

        if ($data[0]->isVerified == 0) {
            return response()->json([
                'status' => 'gagal',
                'data' => 'Silahkan verifikasi OTP terlebih dahulu',
                'user'=> $data
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->responseError('Login failed', 422, $validator->errors());
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            
            $response = [
                'token' => $user->createToken('Token')->accessToken,
                'nama' => $user->name,
                'email' => $user->email,
                'no_telp' => $user->no_telp,
                'role' => $user->role
            ];

            return $this->responseOk($response);
        } else {
            return $this->responseError('Wrong email or password!', 401);
        }
    }
}
