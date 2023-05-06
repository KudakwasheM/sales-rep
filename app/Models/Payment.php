<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'paid_amount',
        'amount',
        'reference',
        'client_id',
        'plan_id',
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
