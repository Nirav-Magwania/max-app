<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdmin;
use App\Traits\UserTrait;
use App\Enums\UserStatusEnum;
use Illuminate\Support\Str;
use App\Http\Helper;

class AdminController extends Controller
{
    use UserTrait;

    // Display a listing of the users
    public function index(Request $request)
    {
        try {
            $users = User::when($request->has('name'), function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->input('name')}%");
                })
                ->when($request->has('email'), function ($query) use ($request) {
                    $query->where('email', 'like', "%{$request->input('email')}%");
                })
                ->paginate();

            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong']);
        }
    }

    // Update the specified user
    public function update(Request $request, User $user)
    {
        try {
            $updateUserData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email',
                'password' => 'nullable|min:8'
            ]);

            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->password) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            Helper::Activities(auth()->user(), 'user/admin', 'Account', 'Updated', "Account updated $user");

            return response()->json([
                'user' => $user,
                'message' => 'User updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong']);
        }
    }

    // Display the specified user
    public function show(Request $request, User $user)
    {
        try {
            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong']);
        }
    }

    // Store a newly created user
    public function create(Request $request)
    {
        try {
            $createUserData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email',
                'password' => 'required|min:8'
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->status = UserStatusEnum::Active;
            $user->save();

            return response()->json([
                'message' => 'User created successfully.',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong']);
        }
    }

    // Remove the specified user
    public function delete(Request $request, User $user)
    {
        try {
            $user->delete();

            Helper::Activities(auth()->user(), 'user', 'Account', 'Deleted', "Account deleted $user");

            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong']);
        }
    }
}
