<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

use Validator;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $this->apiArray['state'] = 'login';
        try {
            $credentials = request(['email', 'password']);

            if (! $token = auth()->attempt($credentials)) {
                throw new \Exception("Email or password is incorrect.");
            }

            $user = auth()->user();

            if (!$user->status) {
                throw new \Exception("Your account has been blocked. Please contact with administrator.");
            }
            // $token = JWTAuth::fromUser($user);
            $this->apiArray['status'] = true;
            $this->apiArray['message'] = "You have logged in successfully.";
            $this->apiArray['data'] = $user;
            $this->apiArray['data']['access_token'] = $token;
        } catch (\Exception $e) {
            $this->apiArray['message'] = $e->getMessage();
        }
        
        return response()->json($this->apiArray);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->apiArray['state'] = 'logout';
        try {
            auth()->logout();
            $this->apiArray['status'] = true;
            $this->apiArray['message'] = "Successfully logged out";
        } catch (\Exception $e) {
            $this->apiArray['message'] = $e->getMessage();
        }
        
        return response()->json($this->apiArray);
    }

    public function register(RegisterRequest $request)
    {
        $this->apiArray['state'] = 'register';
        try {
            $user = new User();
            $user->email = $request->email;
            $user->password = app('hash')->make($request->password);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->mobile_number = $request->mobile_number;
            $user->gender = $request->gender;
            $user->birthday = $request->birthday;
            $user->status = 1;

            if ($user->save()) {
                $token = auth()->login($user);
                $this->apiArray['status'] = true;
                $this->apiArray['message'] = "You have logged in successfully.";
                $this->apiArray['data'] = $user;
                $this->apiArray['data']['access_token'] = $token;
            }
        } catch (\Exception $e) {
            $this->apiArray['message'] = $e->getMessage();
        }
        
        return response()->json($this->apiArray);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
