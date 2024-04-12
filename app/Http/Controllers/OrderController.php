<?php

namespace App\Http\Controllers;
use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function placeorder(Request $request)
    {
        $user = auth()->user();

        $orderDetails = [
            'name' => $user->name,
            'email' => $user->email,
        ];
        $order = new Order($orderDetails);
        $order->save();
    
        event(new OrderPlaced ($order));
        return response()->json(['message'=>'Order placed successfully!']);
    }
}