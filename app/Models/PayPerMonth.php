<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayPerMonth extends Model
{
    use HasFactory;

    protected $table = 'pay_per_month';
    
    protected $fillable = [
        'pawned_item_id',
        'interest',
        'total_monthly_payment',
    ];

    // ความสัมพันธ์กับตาราง PawnedItem
    public function pawnedItem()
    {
        return $this->belongsTo(PawnedItem::class);
    }
}
