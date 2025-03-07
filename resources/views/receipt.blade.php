@php
    $interest = $pawn->amount * ($pawn->interest_rate / 100); // คำนวณดอกเบี้ย
    $total = $pawn->amount + $interest; // คำนวณยอดรวม
    $monthlyPayment = $pawn->monthly_payment + $interest;
    $receiptDate = \Carbon\Carbon::now()->format('d-m-Y'); // วันที่ออกใบเสร็จ
    $receiptNumber = now()->format('d-m-Y') . '-' . $pawn->ticket_id;
    $remainingBalance = $pawn->amount - $pawn->paid_amount; // คำนวณยอดคงเหลือ

@endphp

<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-center text-2xl font-semibold mb-6 text-[#D43F00]">ใบเสร็จการชำระเงิน</h2>

        <div class="mb-4 text-right">
            <p><strong>เลขที่ใบเสร็จ:</strong> {{ $receiptNumber }}</p>
            <p><strong>วันที่ออกใบเสร็จ:</strong> {{ now()->format('d-m-Y') }}</p>
        </div>


        <!-- ข้อมูลลูกค้า -->
        <div class="mb-4">
            <p><strong>รหัสตั๋วจำนำ:</strong> {{ $pawn->ticket_id }}</p>
            <p><strong>ชื่อลูกค้า:</strong> {{ $pawn->customer->name }}</p>
            <p><strong>ชื่อสินค้า:</strong> {{ $pawn->product_name }}</p>
            <p><strong>คำอธิบายสินค้าที่จำนำ:</strong> {{ $pawn->description ?? 'ไม่ระบุ' }}</p>
        </div>

        <!-- ตารางข้อมูลการจำนำ -->
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border-b">ยอดจำนำ</th>
                    <th class="px-4 py-2 border-b">ดอกเบี้ย</th>
                    <th class="px-4 py-2 border-b">จำนวนเงินที่จ่าย</th>
                    <th class="px-4 py-2 border-b">ยอดคงเหลือ</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2 border-b">{{ number_format($pawn->amount, 2) }} บาท</td>
                    <td class="px-4 py-2 border-b">{{ number_format($interest, 2) }} บาท</td>
                    <td class="px-4 py-2 border-b">{{ number_format($monthlyPayment, 2) }} บาท</td>
                    <td class="px-4 py-2 border-b">{{ number_format($remainingBalance, 2) }} บาท</td>
                </tr>
            </tbody>
        </table>

        <!-- ปิดท้ายใบเสร็จ -->
        <div class="mt-6 ">
            <p>ข้าพเจ้าขอรับรองว่า ทรัพย์ที่ขายนี้เป็นกรรมสิทธิ์ของข้าพเจ้าโดยชอบด้วยกฎหมายแต่ผู้เดียว เพื่อเป็นหลักฐานจึงได้ออกใบรับนี้ไว้เป็นหลักฐานต่อหน้าพยาน</p>
        </div>
        <div class="mt-6 text-right">
    <p>
        (ลงชื่อ)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ผู้ขาย)
    </p>
    <p>
        (ลงชื่อ)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (พยาน)
    </p>
    <p>
        (ลงชื่อ)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (พยาน)
    </p>
</div>

        <div class="mt-6 text-center">
            <p>ขอบคุณที่ใช้บริการ!</p>
        </div>
    </div>
</x-app-layout>