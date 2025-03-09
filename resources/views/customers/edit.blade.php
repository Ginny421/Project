<x-app-layout>
@livewire('navigation-menu')
    <div class="min-h-screen bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white py-8">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-center text-3xl font-semibold text-[#D43F00] mb-6">แก้ไขข้อมูลลูกค้า</h2>

            <form action="{{ route('customers.update', $customer->customer_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="name" class="block text-[#D43F00] font-bold mb-2">ชื่อ:</label>
                    <input type="text" name="name" id="name" class="w-full border-2 border-[#FFC107] rounded-lg px-4 py-2 focus:ring focus:ring-[#FFC107]" value="{{ old('name', $customer->name) }}" required>
                </div>

                <div class="mb-6">
                    <label for="phone_number" class="block text-[#D43F00] font-bold mb-2">เบอร์โทร:</label>
                    <input type="text" name="phone_number" id="phone_number" class="w-full border-2 border-[#FFC107] rounded-lg px-4 py-2 focus:ring focus:ring-[#FFC107]" value="{{ old('phone_number', $customer->phone_number) }}" required>
                </div>

                <div class="mb-6">
                    <label for="address" class="block text-[#D43F00] font-bold mb-2">ที่อยู่:</label>
                    <textarea name="address" id="address" class="w-full border-2 border-[#FFC107] rounded-lg px-4 py-2 focus:ring focus:ring-[#FFC107]">{{ old('address', $customer->address) }}</textarea>
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white px-6 py-2 rounded-lg hover:bg-gradient-to-l focus:ring-4 focus:ring-[#FFC107] transition-all duration-300 ease-in-out">บันทึกการเปลี่ยนแปลง</button>
                    <a href="{{ route('customers.index') }}" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-all duration-300 ease-in-out">ยกเลิก</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
