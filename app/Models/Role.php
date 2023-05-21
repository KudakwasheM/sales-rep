<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
