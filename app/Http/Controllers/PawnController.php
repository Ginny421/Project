<?php

namespace App\Http\Controllers;

use App\Models\PawnedItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;



class PawnController extends Controller
{
    public function index(Request $request)
{
    // รับค่า sort_by จาก request ถ้าไม่มีจะใช้ค่าเริ่มต้นเป็น 'due_date'
    $sortBy = $request->get('sort_by', 'due_date'); 

    // จัดเรียงข้อมูลตามตัวเลือกที่เลือก
    $pawns = PawnedItem::orderBy($sortBy, 'asc')->get();

    // ดึงข้อมูลลูกค้า
    $customers = Customer::all();

    // ส่งข้อมูลไปยัง view
    return view('pawns.index', compact('pawns', 'customers'));
}


    // Show pawn details
    public function show($id)
    {
        $pawn = PawnedItem::findOrFail($id);
        $customers = Customer::all();
        return view('pawns.show', compact('pawn','customers'));
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
        'pawn_date' => 'required|date',
        'due_date_pawn' => 'required|date|after_or_equal:pawn_date',
        'pawn_duration' => 'required|integer|min:1',
        'transaction_date' => 'required|date',
        'backup_interest_rate' => 'required|numeric',
        'amount_paid' => 'required|numeric',
    ]);

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
]);

    // ✅ สร้าง Transaction
    Transaction::create([
        'pawned_item_id' => $pawnedItem->id,
        'transaction_date' => $validated['transaction_date'],
        'backup_interest_rate' => $validated['backup_interest_rate'],
        'amount_paid' => $validated['amount_paid'],
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


// ฟังก์ชันสำหรับการส่งข้อความแจ้งเตือน
public function sendLineNotification($message, $lineUserId)
{
    $accessToken = '2006988877';  // ใส่ Channel Access Token ของคุณที่นี่

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $accessToken
    ])->post('https://api.line.me/v2/bot/message/push', [
        'to' => $lineUserId,
        'messages' => [
            [
                'type' => 'text',
                'text' => $message
            ]
        ]
    ]);

    // เช็คสถานะการตอบกลับจาก LINE API
    if ($response->successful()) {
        return response()->json(['status' => 'success']);
    } else {
        return response()->json(['status' => 'error', 'message' => $response->body()]);
    }
}

// ฟังก์ชันสำหรับการแจ้งเตือนลูกค้า
public function notifyCustomer($customerId)
{
    // ดึงข้อมูลลูกค้าที่มี line_user_id
    $customer = Customer::find($customerId);

    if ($customer) {
        // สร้างข้อความแจ้งเตือน
        $message = "สวัสดีครับ/ค่ะ, ลูกค้าท่านนี้มีสินค้าที่จำนำและกำลังจะครบกำหนด! กรุณาติดต่อเราสำหรับรายละเอียดเพิ่มเติม.";
        $lineUserId = $customer->line_user_id;  // ดึง line_user_id ของลูกค้า

        // เรียกฟังก์ชันส่งข้อความ
        $this->sendLineNotification($message, $lineUserId);
    }
}

// ฟังก์ชันสำหรับการส่งแจ้งเตือนหาลูกค้าทั้งหมด
public function sendNotification(Request $request)
{
    // ส่งข้อความแจ้งเตือนให้กับลูกค้าทั้งหมด
    $customers = Customer::all();
    foreach ($customers as $customer) {
        // คุณอาจจะใช้ queue สำหรับการทำงานแบบ asynchronous ที่นี่
        $this->notifyCustomer($customer->id);
    }

    return redirect()->route('pawns.index')->with('success', 'ส่งข้อความแจ้งเตือนสำเร็จ!');
}
}


    





