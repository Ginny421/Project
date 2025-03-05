<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $table = 'transactions';

    protected $fillable = [
        'pawned_item_id',
        'transaction_date',
        'backup_interest_rate',
        'amount_paid',
    ];


    // เชื่อมโยงกับ PawnedItem
    public function pawnedItem()
    {
        return $this->belongsTo(PawnedItem::class);
    }
}

