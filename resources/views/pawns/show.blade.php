<x-app-layout>
@livewire('navigation-menu')
    <div class="min-h-screen bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white py-8">
        <div class="max-w-7xl mx-auto p-8 bg-white shadow-lg rounded-lg">
            <h2 class="text-3xl font-semibold text-center text-[#D43F00] mb-6">รายละเอียดการจำนำทอง</h2>

            <!-- แสดงข้อความแสดงความสำเร็จ -->
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 mb-6 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-4 bg-white p-6 rounded-lg ">
                <!-- ข้อมูลการจำนำต่างๆ -->
                <div class="flex items-center">
                    <strong class="block text-lg text-[#D43F00]">หมายเลขตั๋วจำนำ : </strong>
                    <p class="text-lg text-gray-800">{{ $pawn->ticket_id }}</p>
                </div>

                <div class="flex items-center">
                    <strong class="block text-lg text-[#D43F00]">คำอธิบายสินค้าที่จำนำ :</strong>
                    <p class="text-lg text-gray-800">{{ $pawn->description ?? 'ไม่ระบุ' }}</p>
                </div>


                <div class="flex items-center">
                    <strong class="block text-lg text-[#D43F00]">มูลค่าสินค้าที่ประเมิน :</strong>
                    <p class="text-lg text-gray-800">{{ number_format($pawn->amount, 2) }} บาท</p>
                </div>

                <div class="flex items-center">
                    <strong class="block text-lg text-[#D43F00]">อัตราดอกเบี้ย :</strong>
                    <p class="text-lg text-gray-800">{{ $pawn->interest_rate }}%</p>
                </div>

                <div class="flex items-center">
                    <strong class="block text-lg text-[#D43F00]">วันที่ทำการจำนำ :</strong>
                    <p class="text-lg text-gray-800">{{ \Carbon\Carbon::parse($pawn->pawn_date)->format('d/m/Y') }}</p>
                </div>

                <div class="flex items-center">
                    <strong class="block text-lg text-[#D43F00]">วันที่ครบกำหนด :</strong>
                    <p class="text-lg text-gray-800">{{ \Carbon\Carbon::parse($pawn->due_date)->format('d/m/Y') }}</p>
                </div>

                <!-- แสดงยอดที่จ่ายไปแล้ว -->
                <div class="flex items-center">
                    <strong class="block text-lg text-[#D43F00]">ยอดที่ลูกค้าจ่ายไปแล้ว :</strong>
                    <p class="text-lg text-gray-800">{{ number_format($pawn->totalPayment, 2) }} บาท</p>
                </div>

                <!-- แสดงยอดที่เหลือ -->
                <div class="flex items-center">
                    <strong class="block text-lg text-[#D43F00]">ยอดที่เหลือต้องจ่าย :</strong>
                    <p class="text-lg text-gray-800">{{ number_format($pawn->remaining_balance, 2) }} บาท</p>
                </div>

                <!-- ข้อมูลเจ้าของตั๋วจำนำ -->
                <div class="flex items-center">
                    <strong class="block text-lg text-[#D43F00]">ข้อมูลเจ้าของตั๋วจำนำ :</strong>
                    <p class="text-lg text-gray-800">{{ $pawn->customer->name ?? 'ไม่พบข้อมูล' }}</p>
                </div>
            </div>

            <!-- ปุ่มกลับไปที่รายการ -->
            <div class="mt-6 flex justify-between">
                <a href="{{ route('pawns.index') }}" class="text-[#D43F00] hover:text-[#FF9800] text-lg font-semibold">ย้อนกลับ</a>
            </div>
        </div>
    </div>
</x-app-layout>
