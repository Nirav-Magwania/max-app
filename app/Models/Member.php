<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\User;

class Member extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['user_id','email','designation','invitation_token'];

    protected $hidden = ['pivot'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
