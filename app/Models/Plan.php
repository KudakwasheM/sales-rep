<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'battery_type',
        'installments',
        'paid_installments',
        'deposit',
        'balance',
        'client_id',
        'created_by'
    ];

    function client()
    {
        return $this->belongsTo(Client::class);
    }

    function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
