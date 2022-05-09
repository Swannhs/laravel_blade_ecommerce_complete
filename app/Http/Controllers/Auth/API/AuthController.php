<?php

namespace App\Http\Controllers\Auth\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Modules\UserActivityLog\Traits\LogActivity;


class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Login

    public function login(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->orWhere('username', 'email')->where('is_active', 1)->first();


        if($user && Hash::check($request->password, $user->password) && $user->role->type == 'customer'){

            $token = $user->createToken('my_token')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
                'message' => 'Successfully logged In'
            ];

            return response($response, 200);
        }else{
            return response([
                'message' => 'Invalid Credintials'
            ],401);
        }

    }

    // Logout user

    public function logout(Request $request){

        $user = $request->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response([
            'message' => 'Logged out successfully'
        ],200);
    }

    // Register Customer

    public function register(Request $request){

        $request->validate([
            'first_name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8|confirmed',
            'user_type' => 'required'
        ]);
        if($request->user_type == 'customer'){
            $user = $this->authService->register($request->all());
            $token = $user->createToken('my_token')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
                'message' => 'Successfully registered'
            ];
            return response()->json($response,201);
        }else{
            $response = [
                'message' => 'invalid Credintials'
            ];

            return response()->json($response, 409);
        }
    }

    // Change Password

    public function changePassword(Request $request){

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = $request->user();
        if($user){
            $response = $this->authService->changePassword($user, $request->only('old_password', 'password'));
            if($response == 1){
                return response()->json([
                    'message' => 'password change successfully'
                ],200);
            }else{
                return response()->json([
                    'message' => 'Invalid Credintials.'
                ],409);
            }
        }else{
            return response()->json([
                'message' => 'user not found'
            ],404);
        }

    }

    // Get user

    public function getUser(Request $request){

        $user = User::with('customerAddresses','currency','language')->where('id', $request->user()->id)->first();

        if($user){
            return response()->json([
                'user' => $user,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'user not found'
            ],404);
        }
    }

    // Forgot Password

    public function forgotPasswordAPI(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->where('role_id', 4)->first();
        if($user){
            return $this->forgot($request->all());
        }else{
            return response()->json([
                'message' => 'Customer not found.'
            ], 404);
        }
    }

    private function forgot($user) {

        Password::sendResetLink($user);

        return response()->json(["message" => 'Reset password link sent on your email id.']);
    }

}
