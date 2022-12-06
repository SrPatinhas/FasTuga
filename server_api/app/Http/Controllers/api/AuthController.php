<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
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

    public function login(Request $request)
    {
        try {
            request()->request->add($this->passportAuthenticationData($request->username, $request->password));
            $request = Request::create(config('app.passport_url') . '/oauth/token', 'POST');
            $response = Route::dispatch($request);
            $errorCode = $response->getStatusCode();
            $auth_server_response = json_decode((string) $response->content(), true);
            return response()->json($auth_server_response, $errorCode);
        }
        catch (\Exception $e) {
            return response()->json('Authentication has failed!', 401);
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

    public function register(RegisterValidationForm $request)
    {
        $registration = $request->only('name', 'password', 'email', 'photo_url', 'password_confirmation', 'type');

        $transation_result = DB::transaction(function () use ($registration) {
            $user = User::create([
                'name' => $registration['name'],
                'password' => Hash::make($registration['password']),
                'email' => $registration['email'],
                'photo_url' => isset($registration['photo_url']) ? $registration['photo_url'] : null
            ]);
            $customer = Customer::create([
                'id' => $user->id
            ]);
        });

        $user = User::where('email', $registration['email'])->first();
        $avatar = $request->file('photo');

        if($avatar != null){
            $filename = Storage::putFileAs('public/fotos', $request->photo, $user->id . time() . '.' . $avatar->getClientOriginalExtension());
            $filename = substr($filename, strrpos($filename, '/')+1, strlen($filename));
            $user->photo_url = $filename;
            $user->save();
        }

        return response()->json(
            ['msg'=>'Registered with success!'],
            201
        );
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

}
