<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = ['name'];

    public function generateTicket($ticket_id)
    {
        return str_pad($ticket_id, 6, '0', STR_PAD_LEFT);
    }

    // ในโมเดล Ticket
public function pawnedItems()
{
    return $this->hasMany(PawnedItem::class);
}

}
