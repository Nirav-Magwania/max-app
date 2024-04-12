<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\Models\Member;
use App\Http\Helper;
use App\Mail\UserMember;
use App\Mail\NewMember;
use Mail;


class MemberController extends Controller
{
    
    public function attachMemberToRole(Request $request)
    {
        try {
            // Retrieve available role IDs
            $availableRoles = Role::pluck('id')->toArray();
    
            // Validate request data
            $request->validate([
                'email' => 'required|email',
                'role_id' => ['required', 'in:' . implode(",", $availableRoles), 'array'],
                'designation' => 'required|string'
            ]);
    
            // Retrieve roles based on provided IDs
            $roles = Role::whereIn('id', $request->post('role_id'))->get();
    
            // Check if member with the provided email already exists
            $existingMember = Member::where('email', $request->email)->first();
            $userWithEmail = User::where('email', $request->email)->first();
    
            if ($existingMember || ($userWithEmail && Member::where('user_id', $userWithEmail->id)->exists())) {
                // Member already exists, return a response indicating that
                return response()->json([
                    'message' => "Member with email $request->email already exists."
                ], 500);
            }
    
            if ($userWithEmail) {
                // Member email exists in User model, create a member for the user
                $member = $userWithEmail->member()->create([
                    'designation' => $request->designation,
                ])->refresh();
    
                // Attach roles to the member
                $member->roles()->attach($roles);
    
                // Send email notification
                Mail::to($request->email)->send(new UserMember($member));
    
                return response()->json(['message' => 'User with this email already exists. Member is created on the same user ID. Mail sent']);
            } else {
                // Create a new member and send invitation email
                $invitation_code = Helper::RandomApiStr(32, 'members', 'invitation_token');
    
                $member = Member::create([
                    'email' => $request->email,
                    'designation' => $request->designation,
                    'invitation_token' => $invitation_code
                ])->refresh();
    
                // Attach roles to the member
                $member->roles()->attach($roles);
    
                // Send email notification
                Mail::to($request->email)->send(new NewMember($member));
    
                return response()->json(['message' => 'Mail has been sent to ' . $member->email]);
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function memberUpdate(Member $member, Request $request)
{
    try {
        // Retrieve available role IDs
        $availableRoles = Role::pluck('id')->toArray();

        // Validate request data
        $request->validate([
            //'name'=>'required|string',
            'role_ids' => ['required', 'in:' . implode(",", $availableRoles), 'array']
        ]);

        // Detach existing roles from the member
        $existingMemberRoles = $member->roles()->get();
        $member->roles()->detach($existingMemberRoles);

        // Retrieve roles based on provided IDs
        $roles = Role::whereIn('id', $request->post('role_ids'))->get();

        // Attach new roles to the member
        $member->roles()->attach($roles);

        return response()->json([
            'message' => 'Member roles updated successfully'
        ]);

    } catch (\Exception $e) {
        // Handle any exceptions
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function memberDelete(Member $member)
{
    try {
        // Retrieve the role of the member
        $role = $member->role;

        // Detach the role from the member
        $member->roles()->detach($role);

        // Delete the member
        $member->delete();

        return response()->json(['message' => "$member->name successfully deleted"]);

    } catch (\Exception $e) {
        // Handle any exceptions
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


}
