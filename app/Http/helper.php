<?php
namespace App\Http;

use Illuminate\Support\Str;
use App\Models\Activity;
use App\Models\User;
use App\Models\Member;
use DB;


class Helper
{

    public static function RandomApiStr($length = 32, $tableName = null, $columnName = null)
    {
        $token = Str::random($length);

        if ($tableName && $columnName) {
            while (DB::table($tableName)->where($columnName, $token)->exists()) {
                Helper::RandomApiStr($length);
            }
        }

        return $token;
    }

    public static function activities($user, $type,$on,$action,$content)
    {
    $user->activities()->create([
            'ip' => request()->ip(),
            'type' => $type,
            'on' => $on,
            'action' => $action,
            'content' => $content,
        ]);
    } 
}