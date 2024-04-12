<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\User;
use App\Http\Helper;

class FlightUserController extends Controller
{
    /**
     * Attach a user to a flight.
     */
    public function attachUserToFlight(User $user, Flight $flight)
    {  
        try {
            if ($flight->users()->where('user_id', $user->id)->exists()) {
                return response()->json(['error' => "User $user->id is already attached to this flight $flight->id"], 400);
            }

            $flight->users()->attach($user->id);

            Helper::activities(auth()->user(), 'Admin', 'User', 'User attach to flight', "User $user->id has been attached to flight $flight->id");

            return response()->json(['message' => 'User attached to Flight'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Detach a user from a flight.
     */
    public function detachUserFromFlight(User $user, Flight $flight)
    {
        try {
            if (!$flight->users()->where('user_id', $user->id)->exists()) {
                return response()->json(['error' => "User $user->id is already detached from this flight $flight->id"], 400);
            }

            $flight->users()->detach($user->id);

            Helper::activities(auth()->user(), 'Admin', 'User', 'User detach from flight', "User $user->id has been detached from flight $flight->id");

            return response()->json(['message' => 'User detached from flight successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get users attached to a flight.
     */
    public function getUsersOfFlight(Flight $flight)
    {
        try {
            $users = $flight->users;

            return response()->json(['users' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get flights associated with a user.
     */
    public function getFlightsOfUser(User $user)
    { 
        try {
            $flights = $user->flights;

            return response()->json(['flights' => $flights], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get flights associated with a user (no auth).
     */
    public function getFlightsOfUserAll(User $user)
    {    
        try {
            $flights = $user->flights;

            return response()->json(['flights' => $flights], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
