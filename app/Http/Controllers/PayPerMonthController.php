<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayPerMonth;
use App\Models\PawnedItem;

class PayPerMonthController extends Controller
{
    // ฟังก์ชันสำหรับแสดงข้อมูล
    public function index()
    {
        // Logic ของการแสดงข้อมูลการจ่ายต่อเดือน
        return view('pay_per_month.index');
    }

    // ฟังก์ชันสำหรับบันทึกข้อมูล
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pawned_item_id' => 'required|exists:pawned_items,id',
            'interest' => 'required|numeric',
            'total_monthly_payment' => 'required|numeric',
        ]);
        PayPerMonth::create($validated);

        return redirect()->back()->with('success', 'เพิ่มข้อมูลการจำนำสำเร็จ!');
      
    }

    // ฟังก์ชันสำหรับแสดงข้อมูลการจ่ายรายเดือนในแบบรายละเอียด
    public function show($id)
    {
        // Logic สำหรับแสดงรายละเอียด
        return view('paypermonth.show', ['id' => $id]);
    }
}
