<?php

namespace App\Http\Controllers;

use App\Models\Pawn;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function generateReceipt($pawnId)
    {
        // ดึงข้อมูลการจำนำจากฐานข้อมูล
        $pawn = Pawn::findOrFail($pawnId);
        
        // ส่งข้อมูลไปยัง View เพื่อแสดงใบเสร็จ
        return view('receipt', compact('pawn'));
    }
}
