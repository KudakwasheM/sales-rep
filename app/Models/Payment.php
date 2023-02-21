<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'reference',
        'client_id',
        'created_by'
    ];

    function client()
    {
        return $this->belongsTo(Client::class);
    }

    function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
