<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white py-8">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-center text-3xl font-semibold text-[#D43F00] mb-6">เพิ่มลูกค้า</h2>

            <form action="{{ route('customers.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block text-[#D43F00] font-bold mb-2">ชื่อ:</label>
                    <input type="text" name="name" id="name" class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-[#FFC107] text-[#000000]" required>               
                 </div>

                <div class="mb-6">
                    <label for="phone_number" class="block text-[#D43F00] font-bold mb-2">เบอร์โทรศัพท์:</label>
                    <input type="text" name="phone_number" id="phone_number" class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-[#FFC107] text-[#000000]" required>
                </div>

                <div class="mb-6">
                    <label for="address" class="block text-[#D43F00] font-bold mb-2">ที่อยู่:</label>
                    <textarea name="address" id="address" class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-[#FFC107] text-[#000000]"></textarea>
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('customers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300">ยกเลิก</a>
                    <button type="submit" class="bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white px-4 py-2 rounded-lg hover:bg-gradient-to-l focus:ring-4 focus:ring-[#FFC107] transition-all duration-300 ease-in-out">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
