<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $res = $this->authUser($request->username, $request->password);
        return response()->json($res['response'], $res['code']);
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => 'C',
                'blocked' => false,
                'photo_url' => null,
                'gender' => $request->gender,
            ]);

            Customer::create([
                'user_id'                       => $user->id,
                'phone'                         => $request->phone,
                'points'                        => 0,
                'nif'                           => $request->nif,
                'default_payment_type'          => $request->pay_type,
                'default_payment_reference'     => $request->pay_reference,
                'custom'                        => ''
            ]);

            $res = $this->authUser($request->email, $request->password);
            return response()->json($res['response'], $res['code']);
        }
        catch (\Exception $e) {
            return response()->json('Registration has failed!', 401);
        }
    }


    public function logout(Request $request)
    {
        $accessToken = $request->user()->token();
        $token = $request->user()->tokens->find($accessToken);
        $token->revoke();
        $token->delete();
        return response(['msg' => 'Token revoked'], 200);
    }

    /*
     * Private Functions
     */

    private function passportAuthenticationData($username, $password) {
        return [
            'grant_type' => 'password',
            'client_id' => config('app.passport_client_id'),
            'client_secret' => config('app.passport_client_secret'),
            'username' => $username,
            'password' => $password,
            'scope' => ''
        ];
    }

    private function authUser($username, $password)
    {
        try {
            request()->request->add($this->passportAuthenticationData($username, $password));
            $request = Request::create(config('app.passport_url') . '/oauth/token', 'POST');
            $response = Route::dispatch($request);
            $errorCode = $response->getStatusCode();
            $auth_server_response = json_decode((string) $response->content(), true);
            return ["response" => $auth_server_response, "code" => $errorCode];
        }
        catch (\Exception $e) {
            return ["response" => 'Authentication has failed!', "code" => 401];
        }
    }
}
