<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-center text-2xl font-semibold mb-6">เพิ่มลูกค้า</h2>

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">ชื่อ:</label>
                <input type="text" name="name" id="name" class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            <div class="mb-4">
                <label for="phone_number" class="block text-gray-700 font-bold mb-2">เบอร์โทรศัพท์:</label>
                <input type="text" name="phone_number" id="phone_number" class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-bold mb-2">ที่อยู่:</label>
                <textarea name="address" id="address" class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"></textarea>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('customers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">ยกเลิก</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">บันทึก</button>
            </div>
        </form>
    </div>
</x-app-layout>
