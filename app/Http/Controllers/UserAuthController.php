<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Str;
use App\Http\Helper;
use App\Models\Member;

class UserAuthController extends Controller
{   
    // Register a new user
    public function register(Request $request)
    {
        try {
            $registerUserData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|confirmed|min:8',
                'invitation_token' => 'string|min:32|max:32'
            ]);

            $member = Member::where('invitation_token', $request->input('invitation_token'))->first();

            if (!$member) 
            {
                return response()->json(['message' => 'Invalid invitation token'], 400);
            }

            $user = User::create([
                'email' => $registerUserData['email'],
                'name' => $registerUserData['name'],
                'password' => bcrypt($registerUserData['password'])
            ]);
    
            Helper::activities($user, 'user', 'Account', 'Create', "Account Created $user->name");

            $member->update([
                'user_id' => $user->id,
                'email' => null,
                'invitation_token' => null
            ]);

            return response()->json([
                'message' => "User Created with name $user->name",
            ]);

        } catch (\Exception $e) {
            report($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // User login
    public function login(Request $request)
    {
        try {
            $loginUserData = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|min:8'
            ]);

            $user = User::where('email', $loginUserData['email'])->first();

            if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
                return response()->json(['message' => 'Invalid Credentials'], 401);
            }

            $user['access_token'] = $user->createToken($user->name . '-AuthToken')->plainTextToken;

            return response()->json([
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Enable or disable API access
    public function apiAccess($status)
    {
        try {
            $user = auth()->user();
        
            if (!in_array($status, ['enable', 'disable'])) {
                return response()->json(['message' => 'invalid input']);
            }

            if ($status == 'enable') {
                $user->update(['api_token' => Helper::RandomApiStr(32)]);
            } else if ($status == "disable") {                         
                $user->update(['api_token' => null]);
            }

            Helper::Activities(auth()->user(), 'user', 'Account', 'Update', "Api access $status");

            return response()->json([
                'message' => "Api access is $status"
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Change user password
    public function changepass(Request $request)
    {
        try {
            $user = auth()->user();
            $updatepassword = $request->validate([
                'password' => 'required|string',
                'new_password' => 'required|confirmed|min:8|max:32'
            ]);

            if (!Hash::check($updatepassword['password'], $user->password)) {
                return response()->json(['message' => 'Please enter your existing password correctly']);
            } elseif ($updatepassword['new_password'] == $updatepassword['password']) {
                return response()->json(['message' => 'New password and old password both are same. Try again']);
            } else {
                $user->update(['password' => bcrypt($updatepassword['new_password'])]);

                Helper::Activities(auth()->user(), 'user', 'Account', 'Update', "Password Changed");

                return response()->json(['message' => 'Password updated successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // User logout
    public function logout()
    {
        try {
            auth()->user()->token()->delete();
            Helper::Activities(auth()->user(), 'user', 'Account', 'logout', "User Logged out ");
            return response()->json(['message' => 'User Logged Out']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Get authenticated user
    public function authUser()
    {
        try {
            return response()->json(['User' => auth()->user()]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Admin home
    public function adminHome()
    {
        try {
            return response()->json(['message' => 'Hello and welcome to admin home']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
