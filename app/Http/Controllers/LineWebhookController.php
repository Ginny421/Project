<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class LineWebhookController extends Controller
{
    public function handleLineWebhook(Request $request)
    {
        // รับข้อมูลจาก webhoo          k ของ LINE
        $events = $request->input('events');

        foreach ($events as $event) {
            // เช็คประเภทของเหตุการณ์
            if ($event['type'] == 'follow') {
                // ถ้าเหตุการณ์เป็นการติดตาม LINE OA
                $userId = $event['source']['userId'];  // ดึง LINE userId

                // เก็บข้อมูล LINE userId ลงในฐานข้อมูล (ในตาราง customers)
                $customer = Customer::where('line_user_id', $userId)->first();
                if (!$customer) {
                    $customer = new Customer();
                    $customer->line_user_id = $userId;
                    $customer->save();
                }
            }
        }

        // ส่งการตอบกลับให้ LINE (status code 200)
        return response()->json(['status' => 'success']);
    }
}
