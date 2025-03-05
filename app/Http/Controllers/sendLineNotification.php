<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class sendLineNotification extends Controller
{
    //
    // ฟังก์ชันในการส่งข้อความผ่าน LINE Messaging API
    // ฟังก์ชันในการส่งข้อความไปยังผู้ใช้
    public function sendMessageToLineUser($userId, $message)
    {
        $channelAccessToken = env('2006988877'); // ใช้ Token จาก .env

        // ส่งข้อความไปยัง LINE user
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $channelAccessToken,
        ])->post('https://api.line.me/v2/bot/message/push', [
            'to' => $userId, // User ID ที่ต้องการส่งข้อความ
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $message, // ข้อความที่ต้องการส่ง
                ]
            ],
        ]);

        if ($response->successful()) {
            return 'ข้อความถูกส่งสำเร็จ!';
        } else {
            return 'ไม่สามารถส่งข้อความได้.';
        }
    }
  
}
