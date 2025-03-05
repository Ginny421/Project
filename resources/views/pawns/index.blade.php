<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h2 class="text-2xl font-semibold text-center mb-6">รายการจำนำทอง</h2>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- ฟอร์มการเลือกการเรียงลำดับเป็นปุ่ม -->
        <div class="mb-4 flex justify-end space-x-4">
            <form action="{{ route('pawns.index') }}" method="GET">
                <button type="submit" name="sort_by" value="due_date" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    วันที่ครบกำหนด
                </button>
                <button type="submit" name="sort_by" value="pawn_date" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    วันที่ทำการจำนำ
                </button>
                <button type="submit" name="sort_by" value="ticket_id" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    รหัสตั๋วจำนำ
                </button>
                <button type="submit" name="sort_by" value="amount" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    จำนวนเงิน
                </button>
            </form>
        </div>

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ลำดับ</th>
                    <th class="py-2 px-4 border-b">รหัสตั๋วจำนำ</th>
                    <th class="py-2 px-4 border-b">ชื่อลูกค้า</th>
                    <th class="py-2 px-4 border-b">ชื่อสินค้า</th>
                    <th class="py-2 px-4 border-b">จำนวนเงิน</th>
                    <th class="py-2 px-4 border-b">ดอกเบี้ย</th>
                    <th class="py-2 px-4 border-b">วันที่ทำการจำนำ</th>
                    <th class="py-2 px-4 border-b">วันที่ครบกำหนด</th>
                    <th class="py-2 px-4 border-b">รายละเอียด</th>
                    <th class="py-2 px-4 border-b">แจ้งเตือน</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pawns as $pawn)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $pawn->id }}</td>
                        <td class="py-2 px-4 border-b font-bold text-blue-600">{{ $pawn->ticket_id }}</td>
                        
                        <td class="py-2 px-4 border-b">
                            @php
                                // หา customer ที่ตรงกับ customer_id ของ pawn
                                $customer = $customers->firstWhere('customer_id', $pawn->customer_id);
                            @endphp
                            {{ $customer ? $customer->name : 'ไม่พบข้อมูลลูกค้า' }}
                        </td>
                        
                        <td class="py-2 px-4 border-b">{{ $pawn->product_name }}</td>
                        <td class="py-2 px-4 border-b">{{ number_format($pawn->amount, 2) }}</td>
                        <td class="py-2 px-4 border-b">{{ $pawn->interest_rate }}%</td>
                        <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($pawn->pawn_date)->format('d/m/Y') }}</td>
                        <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($pawn->due_date)->format('d/m/Y') }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('pawns.show', $pawn->id) }}" class="text-blue-500 hover:text-blue-700">ดูเพิ่มเติม</a> 
                        </td>
                        <td><form action="{{ route('sendNotification') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
                            ส่งแจ้งเตือนลูกค้า
                            </button>
                            </form>
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
