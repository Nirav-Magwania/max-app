<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    public function update(Request $request)
    {
        $token = Str::random(32);

        $request->user()->forceFill([
            'api_token'=>($token),
        ])->save();

        return ['token'=>$token];
    }
}