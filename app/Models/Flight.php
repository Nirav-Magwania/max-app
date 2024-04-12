<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Databade\Eloquent\Collection;

class Flight extends Model
{
    use HasFactory;
    protected $table = 'flights';
    protected $fillable=['name','international','image'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}