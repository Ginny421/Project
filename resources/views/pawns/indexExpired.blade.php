<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white py-8">
        <div class="max-w-7xl mx-auto p-8 bg-white shadow-lg rounded-lg">
            <h2 class="text-3xl font-semibold text-center text-[#D43F00] mb-6">รายการจำนำทอง</h2>

            @if(session('success'))
                <div class="bg-green-500 text-white p-4 mb-6 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            
            <table class="min-w-full bg-white border border-[#D43F00] rounded-lg">
                <thead>
                    <tr class="bg-[#D43F00] text-white">
                        <th class="py-3 px-6 border-b">ลำดับ</th>
                        <th class="py-3 px-6 border-b">รหัสตั๋วจำนำ</th>
                        <th class="py-3 px-6 border-b">ชื่อลูกค้า</th>
                        <th class="py-3 px-6 border-b">ชื่อสินค้า</th>
                        <th class="py-3 px-6 border-b">จำนวนเงิน</th>
                        <th class="py-3 px-6 border-b">ดอกเบี้ย</th>
                        <th class="py-3 px-6 border-b">วันที่ทำการจำนำ</th>
                        <th class="py-3 px-6 border-b">วันที่ครบกำหนด</th>
                        <th class="py-3 px-6 border-b">รายละเอียด</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pawns as $pawn)
                        @if ($pawn->status == 'expired')
                            <tr class="hover:bg-gray-100">
                                <td class="py-3 px-6 border-b text-[#000000]">{{ $pawn->id }}</td>
                                <td class="py-3 px-6 border-b text-[#000000]">{{ $pawn->ticket_id }}</td>
                                <td class="py-3 px-6 border-b text-[#000000]">
                                    @php
                                        $customer = $customers->firstWhere('customer_id', $pawn->customer_id);
                                    @endphp
                                    {{ $customer ? $customer->name : 'ไม่พบข้อมูลลูกค้า' }}
                                </td>
                                <td class="py-3 px-6 border-b text-[#000000]">{{ $pawn->product_name }}</td>
                                <td class="py-3 px-6 border-b text-[#000000]">{{ number_format($pawn->amount, 2) }}</td>
                                <td class="py-3 px-6 border-b text-[#000000]">{{ $pawn->interest_rate }}%</td>
                                <td class="py-3 px-6 border-b text-[#000000]">{{ \Carbon\Carbon::parse($pawn->pawn_date)->format('d/m/Y') }}</td>
                                <td class="py-3 px-6 border-b text-[#000000]">{{ \Carbon\Carbon::parse($pawn->due_date)->format('d/m/Y') }}</td>

                                <td class="py-3 px-6 border-b text-[#000000]">
                                    <a href="{{ route('pawns.show', $pawn->id) }}" class="text-[#D43F00] hover:text-[#FF9800]">ดูเพิ่มเติม</a>
                                </td>
                               
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
