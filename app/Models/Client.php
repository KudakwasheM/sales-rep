<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'id_number',
        'dob',
        'ec_number',
        'type',
        'battery_number',
        'docs',
        'created_by'
    ];


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