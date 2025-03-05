<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold text-center mb-6">เพิ่มข้อมูลการจำนำทอง</h2>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- ✅ ฟอร์มเดียวสำหรับ PawnedItem + Transaction -->
        <form action="{{ route('pawns.store') }}" method="POST">
            @csrf

            <!-- 🟢 ข้อมูล PawnedItem -->
            <div class="mb-4">
                <label for="customer_id" class="block text-sm font-medium text-gray-700">ชื่อลูกค้า</label>
                    <select id="customer_id" name="customer_id" class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
                        <option value="">เลือกชื่อลูกค้า</option>
                            @foreach ($customers as $customer)
                            <option value="{{ $customer->customer_id }}">{{ $customer->name }}</option> <!-- ดึงชื่อจากตาราง customers -->
                            @endforeach
                </select>
    </div>

            <div class="mb-4">
                <label for="product_name" class="block text-sm font-medium text-gray-700">ชื่อสินค้าที่จำนำ</label>
                <select id="product_name" name="product_name" class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
                    <option value="ทองแท่ง">ทองแท่ง</option>
                    <option value="ทองรูปพรรณ">ทองรูปพรรณ</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">มูลค่าสินค้าที่ประเมิน</label>
                <input type="number" id="amount" name="amount" class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="interest_rate" class="block text-sm font-medium text-gray-700">ดอกเบี้ย</label>
                <input type="number" id="interest_rate" name="interest_rate" step="0.01" class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="pawn_date" class="block text-sm font-medium text-gray-700">วันที่ทำการจำนำ</label>
                <input type="date" id="pawn_date" name="pawn_date" class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="due_date_" class="block text-sm font-medium text-gray-700">วันที่ครบกำหนดการจำนำ</label>
                <input type="date" id="due_date" name="due_date_pawn" class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">เลือกระยะเวลาการจำนำ</label>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="pawn_duration" value="1" class="mr-2"> 1 เดือน
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="pawn_duration" value="4" class="mr-2"> 4 เดือน
                    </label>
                </div>
            </div>

            <!-- 🟢 ข้อมูล Transaction -->
            <div class="mb-4">
                <label for="transaction_date" class="block text-sm font-medium text-gray-700">วันที่ทำการธุรกรรม</label>
                <input type="date" id="transaction_date" name="transaction_date" class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="backup_interest_rate" class="block text-sm font-medium text-gray-700">ดอกเบี้ยเดิม</label>
                <input type="number" id="backup_interest_rate" name="backup_interest_rate" step="0.01" class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="amount_paid" class="block text-sm font-medium text-gray-700">มูลค่าสินค้าที่ชำระ</label>
                <input type="number" id="amount_paid" name="amount_paid" class="w-full mt-1 p-2 border border-gray-300 rounded-md" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">
                เพิ่มข้อมูลการจำนำ
            </button>
        </form>
    </div>
</x-app-layout>

<script>
   document.querySelectorAll('input[name="pawn_duration"]').forEach((radio) => {
    radio.addEventListener('change', function () {
        const dueDateInput = document.getElementById('due_date');
        const pawnDateInput = document.getElementById('pawn_date');
        
        // ตรวจสอบว่าผู้ใช้เลือกวันที่ทำการจำนำหรือไม่
        if (!pawnDateInput.value) {
            alert("กรุณาเลือกวันที่ทำการจำนำก่อน");
            this.checked = false; // ไม่ให้เลือก radio button ถ้าไม่มีวันที่
            return;
        }

        // ตรวจสอบว่าเลือกระยะเวลาจำนำหรือไม่
        if (!this.checked) {
            alert("กรุณาเลือกระยะเวลาการจำนำ");
            return;
        }

        // คำนวณวันที่ครบกำหนดตามระยะเวลา
        const pawnDate = new Date(pawnDateInput.value);
        const monthsToAdd = parseInt(this.value, 10);
        pawnDate.setMonth(pawnDate.getMonth() + monthsToAdd);
        
        dueDateInput.value = pawnDate.toISOString().split('T')[0];
    });
});
</script>