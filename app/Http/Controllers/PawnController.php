<?php

namespace App\Http\Controllers;

use App\Models\PawnedItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;
use App\Models\PayPerMonth;
use App\Models\PayTotal;
use App\Models\AllPay;


class PawnController extends Controller
{
    public function index(Request $request)
{
    // รับค่า sort_by จาก request ถ้าไม่มีจะใช้ค่าเริ่มต้นเป็น 'due_date'
    $sortBy = $request->get('sort_by', 'ticket_id'); 

    // จัดเรียงข้อมูลตามตัวเลือกที่เลือก
    $pawns = PawnedItem::orderBy($sortBy, 'asc')->get();

    // ดึงข้อมูลลูกค้า
    $customers = Customer::all();

    // ส่งข้อมูลไปยัง view
    return view('pawns.index', compact('pawns', 'customers'));
}

public function indexComplete(Request $request)
{
    $sortBy = $request->get('sort_by', 'ticket_id');

    // กรองรายการที่สถานะเป็น 'completed'
    $pawns = PawnedItem::where('status', 'completed')
                        ->orderBy($sortBy, 'asc')
                        ->get();

    $customers = Customer::all();

    return view('pawns.indexcomplete', compact('pawns', 'customers'));
}

public function indexExpired(Request $request)
{
    $sortBy = $request->get('sort_by', 'ticket_id');

    // กรองรายการที่สถานะเป็น 'completed'
    $pawns = PawnedItem::where('status', 'expired')
                        ->orderBy($sortBy, 'asc')
                        ->get();

    $customers = Customer::all();

    return view('pawns.indexcomplete', compact('pawns', 'customers'));
}



    // Show pawn details
    public function show($id)
    {
       // ดึงข้อมูล pawned item พร้อมกับข้อมูลของลูกค้า
    $pawn = PawnedItem::with(['customer', 'payPerMonths'])->findOrFail($id);

    // คำนวณยอดที่ลูกค้าจ่ายไปแล้ว
    $totalPaid = $pawn->payPerMonths->sum('monthly_payment');

    // คำนวณยอดที่เหลือ (ยอดที่ต้องชำระทั้งหมด - ยอดที่จ่ายไปแล้ว)
    $totalAmount = $pawn->amount + ($pawn->amount * $pawn->interest_rate / 100);
    $remainingBalance = $totalAmount - $totalPaid;

    // ส่งข้อมูลทั้งหมดไปยัง view
    return view('pawns.show', compact('pawn','totalPaid', 'remainingBalance'));
    }

    public function create()
{
    // ดึงข้อมูลสินค้าจากฐานข้อมูล
    $pawnedItems = PawnedItem::all();
    $customers = Customer::all(); // ดึงข้อมูลลูกค้าทั้งหมด

    // ส่งข้อมูลไปยัง view
    return view('pawns.create', compact('pawnedItems','customers'));
}


    // Store pawn data
    public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'customer_id' => 'required|string|max:255',
        'product_name' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'interest_rate' => 'required|numeric',
        'description' => 'nullable|string',
        'pawn_date' => 'required|date',
        'due_date_pawn' => 'required|date|after_or_equal:pawn_date',
        'pawn_duration' => 'required|integer|min:1',
        'backup_interest_rate' => 'required|numeric',
    ]);

    // คำนวณ interestPerMonth
    $interestPerMonth = ($validated['interest_rate'] / 100) * $validated['amount'] / 12;

    // คำนวณ totalMonthlyPayment
    $totalMonthlyPayment = ($validated['amount'] / $validated['pawn_duration']) + $interestPerMonth;

    // Generate ticket_id
    $latestTicket = PawnedItem::latest('ticket_id')->first();
    $nextTicketId = $latestTicket ? (int)$latestTicket->ticket_id + 1 : 1;
    $ticketId = str_pad($nextTicketId, 6, '0', STR_PAD_LEFT);

    // ✅ สร้าง PawnedItem
    $pawnedItem = PawnedItem::create([
        'ticket_id' => $ticketId,
        'customer_id' => $validated['customer_id'],
        'product_name' => $validated['product_name'],
        'amount' => $validated['amount'],
        'interest_rate' => $validated['interest_rate'],
        'pawn_date' => $validated['pawn_date'],
        'due_date' => $validated['due_date_pawn'],
        'pawn_duration' => $validated['pawn_duration'],
        'description' => $validated['description'],
    ]);

    // ✅ สร้าง Transaction
    Transaction::create([
        'pawned_item_id' => $pawnedItem->id,
        'transaction_date' => $validated['pawn_date'],
        'backup_interest_rate' => $validated['backup_interest_rate'],
    ]);

    // ✅ บันทึกข้อมูลในตาราง pay_per_month
    PayPerMonth::create([
        'pawned_item_id' => $pawnedItem->id,
        'interest' => $interestPerMonth,
        'total_monthly_payment' => $totalMonthlyPayment,
    ]);

    return redirect()->route('pawns.index')->with('success', 'เพิ่มข้อมูลการจำนำและธุรกรรมสำเร็จ!');
}


    


    // In your PawnController
public function receipt($id)
{
    // Find the pawned item by ID
    $pawn = PawnedItem::findOrFail($id);
    $customers = Customer::all();

    // Logic for receipt generation, you might want to return a view or PDF
    return view('receipt', compact('pawn','customers'));
}



public function processPayment(Request $request, $id)
{
    $pawn = PawnedItem::findOrFail($id);

    // รับค่าที่ลูกค้าชำระ
    $paymentAmount = $request->input('payment_amount');

    // คำนวณยอดที่ต้องจ่ายทั้งหมด (เงินต้น + ดอกเบี้ย)
    $totalAmount = $pawn->amount + ($pawn->amount * $pawn->interest_rate / 100);

    // คำนวณยอดที่ชำระไปแล้วจากการบันทึกในฐานข้อมูล
    $totalPaid = $pawn->payPerMonths->sum('total_monthly_payment');

    // คำนวณยอดคงเหลือ (ยอดที่ต้องจ่ายทั้งหมด - ยอดที่ชำระไปแล้ว)
    $remainingBalance = $totalAmount - $totalPaid;

    // ลดยอดที่ลูกค้าชำระออกจากยอดคงเหลือ
    $remainingBalance -= $paymentAmount;

    // บันทึกข้อมูลการชำระเงินลงในฐานข้อมูล
    $totalMonthlyPayment = $paymentAmount;
    $payPerMonth = $pawn->payPerMonths()->create([
        'interest' => $pawn->interest_rate,
        'total_monthly_payment' => $totalMonthlyPayment,
    ]);

    // อัปเดตยอดคงเหลือใน PawnedItem
    $pawn->remaining_balance = $remainingBalance;

    // ตรวจสอบวันที่ครบกำหนด หากเลยกำหนดแล้วแต่ยังไม่ได้ชำระ เปลี่ยนสถานะเป็น 'expired'
    if (now()->greaterThan($pawn->due_date) && $remainingBalance > 0) {
        $pawn->status = 'expired'; // เปลี่ยนสถานะเป็น 'expired' หรือ 'หลุดจำนำ'
    } elseif ($remainingBalance <= 0) {
        // ถ้าชำระเงินหมดแล้ว เปลี่ยนสถานะเป็น 'completed'
        $pawn->status = 'completed';
        $pawn->remaining_balance = 0; // ตั้งยอดคงเหลือเป็น 0 ถ้าชำระครบ
    } else {
        $pawn->status = 'active'; // ถ้ายังไม่ครบยอด เปลี่ยนสถานะเป็น 'active'
    }

    // บันทึกการเปลี่ยนแปลงในฐานข้อมูล
    $pawn->save();

    // แสดงข้อความสำเร็จและส่งข้อมูลไปยังหน้าแรก
// แสดงข้อความสำเร็จและส่งข้อมูลไปยังหน้าใบเสร็จ
return redirect()->route('pawns.receipt', ['id' => $pawn->id]);

;}

// เพิ่มฟังก์ชัน pay() ใน PawnController
public function pay($id)
{
    // ค้นหาข้อมูลจำนำจากฐานข้อมูล
    $pawn = PawnedItem::findOrFail($id);

    // คำนวณยอดคงเหลือ (ยอดทั้งหมดที่ต้องจ่าย - ยอดที่ชำระไปแล้ว)
    $totalAmount = $pawn->amount + ($pawn->amount * $pawn->interest_rate / 100);
    $totalPaid = $pawn->payPerMonths->sum('total_monthly_payment');
    $remainingBalance = $totalAmount - $totalPaid;

    // ส่งข้อมูลไปยัง Blade template
    return view('pawns.pay', compact('pawn', 'remainingBalance'));
}

}