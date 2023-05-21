<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Token extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';


    protected $fillable = [
        'number',
        'client_id'
    ];

    function client()
    {
        return $this->belongsTo(Client::class);
    }
}
