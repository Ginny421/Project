<x-app-layout>
@livewire('navigation-menu')
    <div class="min-h-screen bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white py-8">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-center text-3xl font-semibold text-[#D43F00] mb-6">ข้อมูลลูกค้า</h2>

            <div class="mb-6">
                <label for="name" class="block text-[#D43F00] font-bold mb-2">ชื่อ:</label>
                <p class="text-[#333333]">{{ $customer->name }}</p>
            </div>

            <div class="mb-6">
                <label for="phone_number" class="block text-[#D43F00] font-bold mb-2">เบอร์โทร:</label>
                <p class="text-[#333333]">{{ $customer->phone_number }}</p>
            </div>

            <div class="mb-6">
                <label for="address" class="block text-[#D43F00] font-bold mb-2">ที่อยู่:</label>
                <p class="text-[#333333]">{{ $customer->address ?? 'ไม่มีข้อมูล' }}</p>
            </div>

            <div class="flex justify-between mt-8">
                <a href="{{ route('customers.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-all duration-300 ease-in-out">กลับสู่รายการลูกค้า</a>
                <a href="{{ route('customers.edit', $customer->customer_id) }}" class="bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white px-6 py-3 rounded-lg hover:bg-gradient-to-l transition-all duration-300 ease-in-out">แก้ไขข้อมูล</a>
            </div>
        </div>
    </div>
</x-app-layout>
