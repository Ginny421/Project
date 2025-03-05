@php
    $interest = $pawn->amount * ($pawn->interest_rate / 100); // คำนวณดอกเบี้ย
    $total = $pawn->amount + $interest; // คำนวณยอดรวม
    $receiptDate = \Carbon\Carbon::now()->format('d-m-Y'); // วันที่ออกใบเสร็จ
@endphp

<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-center text-2xl font-semibold mb-6">ใบเสร็จการจำนำ</h2>

        <div class="mb-4 text-right">
            <p><strong>วันที่ออกใบเสร็จ:</strong> {{ now()->format('d-m-Y') }}</p>
        </div>

        <!-- ข้อมูลลูกค้า -->
        <div class="mb-4">
            <p>
                <strong>ลูกค้าชื่อ:</strong> 
                @foreach ($customers as $customer)
                    @if ($customer->customer_id == $pawn->customer_id)
                        {{ $customer->name }}
                    @endif
                    @endforeach</p>
            <p><strong>รหัสตั๋วจำนำ:</strong> {{ $pawn->ticket_id }}</p>
        </div>
        

        <!-- ตารางข้อมูลการจำนำ -->
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left border-b">รายละเอียด</th>
                    <th class="px-4 py-2 border-b">ประเภทสินค้า</th>
                    <th class="px-4 py-2 border-b">มูลค่าสินค้าที่ประเมิน</th>
                    <th class="px-4 py-2 border-b">ดอกเบี้ย</th>
                    <th class="px-4 py-2 border-b">วันที่จำนำ</th>
                    <th class="px-4 py-2 border-b">วันที่ครบกำหนด</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2 border-b">{{ $pawn->product_name }}</td>
                    <td class="px-4 py-2 border-b">{{ $pawn->product_name }}</td>
                    <td class="px-4 py-2 border-b">{{ number_format($pawn->amount, 2) }} บาท</td>
                    <td class="px-4 py-2 border-b">{{ number_format($pawn->interest_rate, 2) }} %</td>
                    <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($pawn->pawn_date)->format('d-m-Y') }}</td>
                    <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($pawn->due_date)->format('d-m-Y') }}</td>

                </tr>
            </tbody>
        </table>

        <div class="mb-4 text-right">
            <p><strong>จำนวนมูลค่าสินค้าที่ประเมิน :</strong> {{ number_format($pawn->amount, 2) }} บาท </p>
            <p><strong>ดอกเบี้ย :</strong> {{ number_format($interest, 2) }} บาท</p>
            <p><strong>รวมทั้งหมด :</strong> {{ number_format($total, 2) }} บาท</p>
        </div>


        <!-- ปิดท้ายใบเสร็จ -->
        <div class="mt-6 text-center">
            <p>ขอบคุณที่ใช้บริการ!</p>
        </div>
    </div>
</x-app-layout>




