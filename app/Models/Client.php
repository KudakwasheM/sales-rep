<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'id_number',
        'dob',
        'ec_number',
        'type',
        'created_by'
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    function payments()
    {
        return $this->hasMany(Payment::class);
    }

    function tokens()
    {
        return $this->hasMany(Token::class);
    }

    function plans()
    {
        return $this->hasMany(Plan::class);
    }
}
