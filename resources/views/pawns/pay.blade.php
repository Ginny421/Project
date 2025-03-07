<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white py-8">
        <div class="max-w-3xl mx-auto p-8 bg-white shadow-lg rounded-lg">
            <h2 class="text-3xl font-semibold text-center text-[#D43F00] mb-6">ชำระเงินค่าจำนำ</h2>

            @if(session('success'))
                <div class="bg-green-500 text-white p-4 mb-6 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6">
                <h3 class="text-xl font-semibold text-[#D43F00]">รายละเอียดการจำนำ</h3>
                <p class="text-black mt-2"><strong>รหัสตั๋วจำนำ:</strong> {{ $pawn->ticket_id }}</p>
                <p class="text-black"><strong>ชื่อลูกค้า:</strong> {{ $pawn->customer->name }}</p>
                <p class="text-black"><strong>ชื่อสินค้า:</strong> {{ $pawn->product_name }}</p>
                <p class="text-black"><strong>ยอดจำนำ:</strong> {{ number_format($pawn->amount, 2) }} บาท</p>
                <p class="text-black"><strong>ดอกเบี้ย:</strong> {{ $pawn->interest_rate }}%</p>
                <p class="text-black"><strong>ยอดคงเหลือ:</strong> {{ number_format($remainingBalance, 2) }} บาท</p>
            </div>
            

            <form action="{{ route('pawns.processPayment', $pawn->id) }}" method="POST">
    @csrf
    <label for="payment_amount" class="text-[#D43F00] font-semibold">จำนวนเงินที่จ่าย</label>
    <input type="number" name="payment_amount" id="payment_amount" min="1" step="0.01" 
        value="{{ number_format($pawn->monthly_payment, 2) }}" 
        class="w-full p-3 mt-2 mb-4 border border-gray-300 rounded-md text-black"
        required>

    <button type="submit" class="w-full bg-[#D43F00] text-white py-3 px-6 rounded-md hover:bg-[#FF9800]">
        ยืนยันการชำระเงิน
    </button>
</form>





            <div class="mt-6 text-center">
                <a href="{{ route('pawns.index') }}" class="text-[#D43F00] hover:underline">🔙 กลับไปหน้ารายการจำนำ</a>
            </div>
        </div>
    </div>
</x-app-layout>

