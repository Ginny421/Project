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

    return view('pawns.indexExpired', compact('pawns', 'customers'));
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
    return view('pawns.show', compact('pawn','totalPaid', 'remainingBalance','totalPaid'));
    }

    
    public function create()
{
    // ดึงข้อมูลสินค้าจากฐานข้อมูล
    $pawnedItems = PawnedItem::all();
    $customers = Customer::all(); // ดึงข้อมูลลูกค้าทั้งหมด

    // ส่งข้อมูลไปยัง view
    return view('pawns.create', compact('pawnedItems','customers'));
}

public function destroy($id)
{
    // ค้นหา PawnedItem ตาม ID
    $pawn = PawnedItem::findOrFail($id);

    // ลบข้อมูล PawnedItem
    $pawn->delete();

    // ส่งข้อความสำเร็จและกลับไปยังหน้าหลัก
    return redirect()->route('pawns.index')->with('success', 'ลบข้อมูลการจำนำสำเร็จ!');
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
    $interestPerMonth = $validated['interest_rate'];
    // คำนวณ totalPayment
    $totalPayment = ((($validated['amount'] * ($interestPerMonth / 100 )) * ($validated['pawn_duration']) )+($validated['amount']));
    // หาตั๋วจำนำล่าสุด
    $latestTicket = PawnedItem::latest('ticket_id')->first();

    // แยก ticket_id ออกเป็นสองส่วน
    if ($latestTicket) {
        $ticketParts = explode('-', $latestTicket->ticket_id);
        $ticketNumber = (int) $ticketParts[0];  // ส่วนที่เป็นตัวเลข 6 หลัก
        $roundNumber = (int) $ticketParts[1];   // ส่วนที่เป็นรอบ

    // ตรวจสอบว่าเลข 6 หลักถึง 999999 แล้วหรือยัง
    if ($ticketNumber == 999999) {
        // ถ้าเลข 6 หลักถึง 999999 ให้เริ่มรอบใหม่
        $ticketNumber = 1;
        $roundNumber++;
    } else {
        // ถ้าไม่ถึง 999999 ให้เพิ่มเลข 6 หลัก
        $ticketNumber++;
    }
    } else {
        // ถ้าไม่มีข้อมูลในฐานข้อมูล ให้เริ่มที่ 000001-1
        $ticketNumber = 1;
        $roundNumber = 1;
    }

// สร้าง ticket_id ในรูปแบบ 000001-1
$ticketId = str_pad($ticketNumber, 6, '0', STR_PAD_LEFT) . '-' . $roundNumber;

// ใช้ $ticketId ในการสร้างหรือลงทะเบียนตั๋วจำนำ


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
        'totalPayment' => $totalPayment,
        'remaining_balance'=> $totalPayment,
    ]);

    // ✅ สร้าง Transaction
    Transaction::create([
        'pawned_item_id' => $pawnedItem->id,
        'transaction_date' => $validated['pawn_date'],
        'backup_interest_rate' => $validated['backup_interest_rate'],
    ]);


    return redirect()->route('pawns.index')->with('success', 'เพิ่มข้อมูลการจำนำและธุรกรรมสำเร็จ!');
}

    // In your PawnController
    public function receipt($id)
{
    // Find the pawned item by ID
    $pawn = PawnedItem::findOrFail($id);
    $pay = PayPerMonth::where('pawned_item_id', $id)->latest()->first();
    // ดึงค่าจากฐานข้อมูลโดยตรง
    if ($pay) {
        $total_monthly_payment = $pay->total_monthly_payment;
    } else {
        $total_monthly_payment = 0; // ถ้าไม่เจอข้อมูล กำหนดให้เป็น 0
    }
    $remaining_balance = $pawn->remaining_balance;

    // ส่งตัวแปรทั้งหมดไปยัง view
    return view('receipt', compact('pawn', 'total_monthly_payment', 'remaining_balance'));
}

public function processPayment(Request $request, $id)
{
    $pawn = PawnedItem::findOrFail($id);
    $pay = PayPerMonth::where('pawned_item_id', $id)->latest()->first();
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
    $totalPayment = $paymentAmount;
    $payPerMonth = $pawn->payPerMonths()->create([
        'interest' => $pawn->interest_rate,
        'total_monthly_payment' => $totalPayment,
    ]);

    $totalPaid += $paymentAmount; 
    // อัปเดตยอดคงเหลือใน PawnedItem
    $pawn->remaining_balance = $remainingBalance;
    $pawn->totalPayment = $totalPaid;


    // ตรวจสอบวันที่ครบกำหนด หากเลยกำหนดแล้วแต่ยังไม่ได้ชำระ เปลี่ยนสถานะเป็น 'expired'
    if (now()->greaterThan($pawn->due_date) && $pawn->$remainingBalance > 0) {
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
    return view('pawns.pay', compact('pawn', 'remainingBalance',));
}



}