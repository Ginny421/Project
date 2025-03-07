<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllPay extends Model
{
    use HasFactory;

    protected $table = 'all_pay';

    protected $fillable = [
        'pawned_item_id',
        'total_amount_due',
    ];

    public function pawnedItem()
    {
        return $this->belongsTo(PawnedItem::class);
    }
}
