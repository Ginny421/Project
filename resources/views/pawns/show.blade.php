<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold text-center mb-6">รายละเอียดการจำนำทอง</h2>

        <!-- แสดงข้อความแสดงความสำเร็จ -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4">

 
            <div>
                <strong class="block text-lg">หมายเลขตั๋วจำนำ:</strong>
                <p>{{ $pawn->ticket_id }}</p> <!-- Use ticket_id directly -->
            </div>

            <div>
                <strong class="block text-lg">คำอธิบายสินค้าที่จำนำ:</strong>
                <p>{{ $pawn->item_description ?? 'ไม่ระบุ' }}</p>
            </div>

            <div>
                <strong class="block text-lg">มูลค่าสินค้าที่ประเมิน:</strong>
                <p>{{ number_format($pawn->amount, 2) }} บาท</p>
            </div>

            <div>
                <strong class="block text-lg">อัตราดอกเบี้ย:</strong>
                <p>{{ $pawn->interest_rate }}%</p>
            </div>

            <div>
                <strong class="block text-lg">วันที่ทำการจำนำ:</strong>
                <p>{{ \Carbon\Carbon::parse($pawn->pawn_date)->format('d/m/Y') }}</p>
            </div>

            <div>
                <strong class="block text-lg">วันที่ครบกำหนด:</strong>
                <p>{{ \Carbon\Carbon::parse($pawn->due_date)->format('d/m/Y') }}</p>
            </div>

            <div>
                <strong class="block text-lg">ระยะเวลาการจำนำ:</strong>
                <p>{{ $pawn->pawn_duration }} เดือน</p>
            </div>

                <div>
                    <strong class="block text-lg">ข้อมูลเจ้าของตั๋วจำนำ:</strong>
                    <p>
                        @foreach ($customers as $customer)
                                @if ($customer->customer_id == $pawn->customer_id)
                                    {{ $customer->name }}
                                @endif
                            @endforeach
                    </p>
                </div>
            
        </div>

        <!-- ปุ่มกลับไปที่รายการ -->
        <div class="mt-6">
            <a href="{{ route('pawns.index') }}" class="text-blue-500 hover:text-blue-700">ย้อนกลับ</a>
            <a href="{{ route('pawns.receipt', $pawn->id) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">ดูใบเสร็จ</a>
        </div>
    </div>
</x-app-layout>
