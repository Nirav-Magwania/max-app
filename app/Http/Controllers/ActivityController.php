<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Helper;
use app\Models\Activity;

class ActivityController extends Controller
{
    public function Activitylog(Request $request)
    {
        

        $type = $request->input('type');
        $on = $request->input('on');
        $action = $request->input('action');
        $content = $request->input('content');

        Helper::Activities(auth()->user(),$type, $on, $action, $content);
        
        return response()->json(['message' => 'Activity logged successfully'], 200);
    }
}