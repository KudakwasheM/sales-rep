<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class ClientFile extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';

    protected $fillable = [
        'file',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
