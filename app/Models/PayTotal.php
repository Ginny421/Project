<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayTotal extends Model
{
    use HasFactory;

    protected $table = 'pay_total';

    protected $fillable = [
        'pawned_item_id',
        'total_paid',
    ];

    public function pawnedItem()
    {
        return $this->belongsTo(PawnedItem::class);
    }
}
