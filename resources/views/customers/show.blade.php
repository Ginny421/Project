<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-center text-2xl font-semibold mb-6">ข้อมูลลูกค้า</h2>

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">ชื่อ:</label>
            <p class="text-gray-800">{{ $customer->name }}</p>
        </div>

        <div class="mb-4">
            <label for="phone_number" class="block text-gray-700 font-bold mb-2">เบอร์โทร:</label>
            <p class="text-gray-800">{{ $customer->phone_number }}</p>
        </div>

        <div class="mb-4">

            <label for="address" class="block text-gray-700 font-bold mb-2">ที่อยู่:</label>
            <p class="text-gray-800">{{ $customer->address ?? 'ไม่มีข้อมูล' }}</p>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('customers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">กลับสู่รายการลูกค้า</a>
            <a href="{{ route('customers.edit', $customer->customer_id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-700">แก้ไขข้อมูล</a>
            </div>
    </div>
</x-app-layout>
