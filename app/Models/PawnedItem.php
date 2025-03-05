<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PawnedItem extends Model
{
    protected $fillable = [
        'customer_id',
        'product_name',
        'amount',
        'interest_rate',
        'pawn_date',
        'due_date',
        'pawn_duration',
        'ticket_id',
    ];

    // เชื่อมโยงกับ Transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

