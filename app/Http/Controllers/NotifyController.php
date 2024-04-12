<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\User;
use app\Notifications\StatusUpdate;


class NotifyController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = $request->user();

        // Replace $order with your actual order data
        $order = $user->orders()->latest()->first();

        // Notify the user with the StatusUpdate notification
        $user->notify(new StatusUpdate($order));

        // You might want to return a response indicating success or redirect somewhere
        return response()->json(['message' => 'Notification sent successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
