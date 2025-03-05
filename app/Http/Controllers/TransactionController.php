<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function create()
{
    $pawnedItems = PawnedItem::all(); // ดึงข้อมูลสินค้าทั้งหมด
    return view('pawns.create', compact('pawnedItems'));
}

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pawned_item_id' => 'required|exists:pawned_items,id',
            'transaction_date' => 'required|date',
            'backup_interest_rate' => 'required|numeric',
            'amount_paid' => 'required|numeric',
        ]);

        Transaction::create($validated);

        return redirect()->back()->with('success', 'เพิ่มข้อมูลการจำนำสำเร็จ!');
    }
}



