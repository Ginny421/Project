<x-app-layout>
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
<h2 class="text-center text-2xl font-semibold mb-6">แก้ไขข้อมูลลูกค้า</h2>

<form action="{{ route('customers.update', $customer->customer_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2 ">ชื่อ:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
        </div>

        <div class="form-group ">
            <label for="phone_number" class="block text-gray-700 font-bold mb-2">เบอร์โทร:</label>
            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $customer->phone_number) }}" required>
        </div>

        <div class="form-group">
            <label for="address" class="block text-gray-700 font-bold mb-2">ที่อยู่:</label>
            <textarea name="address" class="form-control">{{ old('address', $customer->address) }}</textarea>
        </div>

        <div class="flex justify-between">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">บันทึกการเปลี่ยนแปลง</button>
        <a href="{{ route('customers.index') }}" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">ยกเลิก</a>
        </div>

    </form>
    </div>

</x-app-layout>