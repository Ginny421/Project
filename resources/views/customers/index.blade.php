<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-center text-2xl font-semibold mb-6">รายการลูกค้า</h2>

        <!-- ปุ่มเพิ่มลูกค้า -->
        <a href="{{route('customers.create') }}" class="mb-4 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">
            เพิ่มลูกค้า
        </a>

        <!-- ตารางแสดงลูกค้า -->
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border-b">ลำดับ</th>
                    <th class="px-4 py-2 border-b">ชื่อ</th>
                    <th class="px-4 py-2 border-b">เบอร์โทรศัพท์</th>
                    <th class="px-4 py-2 border-b">ที่อยู่</th>
                    <th class="px-4 py-2 border-b">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $index => $customer)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border-b">{{ $customer->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $customer->phone_number }}</td>
                        <td class="px-4 py-2 border-b">{{ $customer->address }}</td>
                        <td class="px-4 py-2 border-b">
                        <a href="{{ route('customers.show', $customer->customer_id) }}">View Customer</a>
                        <a href="{{ route('customers.edit', $customer->customer_id) }}">แก้ไขข้อมูลลูกค้า</a>
                        <form action="{{ route('customers.destroy', $customer->customer_id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?');" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-black px-4 py-2 rounded hover:bg-red-700">ลบข้อมูล</button>
                        </form>


                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
