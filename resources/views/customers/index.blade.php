<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white py-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-center text-3xl font-semibold text-[#D43F00] mb-6">รายการลูกค้า</h2>

            <!-- ปุ่มเพิ่มลูกค้า -->
            <a href="{{ route('customers.create') }}" class="mb-4 inline-block bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white py-2 px-6 rounded-md hover:bg-gradient-to-l focus:ring-4 focus:ring-[#FFC107] transition-all duration-300 ease-in-out">
                เพิ่มลูกค้า
            </a>

            <!-- ตารางแสดงลูกค้า -->
            <table class="min-w-full table-auto border-collapse mt-6 shadow-md rounded-lg">
                <thead>
                    <tr class="bg-[#D43F00] text-white">
                        <th class="px-4 py-2 border-b text-center">ลำดับ</th>
                        <th class="px-4 py-2 border-b text-center">ชื่อ</th>
                        <th class="px-4 py-2 border-b text-center">เบอร์โทรศัพท์</th>
                        <th class="px-4 py-2 border-b text-center">ที่อยู่</th>
                        <th class="px-4 py-2 border-b text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $index => $customer)
                        <tr class=" transition-all duration-200 ease-in-out">
                            <td class="px-4 py-2 border-b text-center text-[#000000]">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border-b text-center text-[#000000]">{{ $customer->name }}</td>
                            <td class="px-4 py-2 border-b text-center text-[#000000]">{{ $customer->phone_number }}</td>
                            <td class="px-4 py-2 border-b text-center text-[#000000]">{{ $customer->address }}</td>
                            <td class="px-4 py-2 border-b text-center flex justify-center space-x-4">
                                <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-all duration-300 ease-in-out">
                                    <a href="{{ route('customers.show', $customer->customer_id) }}">ดูข้อมูล</a>
                                </button>
                                <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-all duration-300 ease-in-out">
                                <a href="{{ route('customers.edit', $customer->customer_id) }}" >แก้ไขข้อมูล</a>
                                </button>
                                <form action="{{ route('customers.destroy', $customer->customer_id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?');" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-all duration-300 ease-in-out">ลบข้อมูล</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
