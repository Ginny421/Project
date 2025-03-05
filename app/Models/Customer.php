<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id'; // กำหนด PK ตาม Data Dictionary
    protected $fillable = ['name', 'phone_number', 'address'];
}
