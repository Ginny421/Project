<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white py-8">
        <div class="max-w-3xl mx-auto p-8 bg-white shadow-lg rounded-lg">
            <h2 class="text-3xl font-semibold text-center text-[#D43F00] mb-6">เพิ่มข้อมูลการจำนำทอง</h2>

            @if(session('success'))
                <div class="bg-green-500 text-white p-4 mb-6 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ✅ ฟอร์มเดียวสำหรับ PawnedItem + Transaction -->
            <form action="{{ route('pawns.store') }}" method="POST">
                @csrf

                <!-- 🟢 ข้อมูล PawnedItem -->
                <div class="mb-6">
                    <label for="customer_id" class="block text-sm font-medium text-[#D43F00]">ชื่อลูกค้า</label>
                    <select id="customer_id" name="customer_id" class="w-full mt-1 p-3 border border-[#D43F00] rounded-md focus:ring-2 focus:ring-[#FFC107] text-[#000000]" required>
                        <option value="">เลือกชื่อลูกค้า</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->customer_id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="product_name" class="block text-sm font-medium text-[#D43F00]">ชื่อสินค้าที่จำนำ</label>
                    <select id="product_name" name="product_name" class="w-full mt-1 p-3 border border-[#D43F00] rounded-md focus:ring-2 focus:ring-[#FFC107] text-[#000000]" required>
                        <option value="ทองแท่ง">ทองแท่ง</option>
                        <option value="ทองรูปพรรณ">ทองรูปพรรณ</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-[#D43F00]">คำอธิบาย</label>
                    <input id="description" name="description" rows="4" class="w-full mt-1 p-3 border border-[#D43F00] rounded-md focus:ring-2 focus:ring-[#FFC107] text-[#000000]" placeholder="กรุณากรอกคำอธิบายเกี่ยวกับสินค้าที่จำนำ"></input>
                </div>


                <div class="mb-6">
                    <label for="amount" class="block text-sm font-medium text-[#D43F00]">มูลค่าสินค้าที่ประเมิน</label>
                    <input type="number" id="amount" name="amount" class="w-full mt-1 p-3 border border-[#D43F00] rounded-md focus:ring-2 focus:ring-[#FFC107] text-[#000000]" required>
                </div>

                <div class="mb-6">
                    <label for="interest_rate" class="block text-sm font-medium text-[#D43F00]">ดอกเบี้ย</label>
                    <input type="number" id="interest_rate" name="interest_rate" step="0.01" value="1.5" class="w-full mt-1 p-3 border border-[#D43F00] rounded-md focus:ring-2 focus:ring-[#FFC107] text-[#000000]" required>
                </div> 

                <div class="mb-6">
                    <label for="pawn_date" class="block text-sm font-medium text-[#D43F00]">วันที่ทำการจำนำ</label>
                    <input type="date" id="pawn_date" name="pawn_date" class="w-full mt-1 p-3 border border-[#D43F00] rounded-md focus:ring-2 focus:ring-[#FFC107] text-[#000000]" required>
                </div>

               

                <div class="mb-6">
                    <label class="block text-sm font-medium text-[#D43F00] mb-2">เลือกระยะเวลาขาดส่งดอกเบี้ย</label>
                    <div class="flex items-center space-x-6 text-[#000000]">
                        <label class="flex items-center">
                            <input type="radio" name="pawn_duration" value="1" class="mr-2"> 1 เดือน
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="pawn_duration" value="4" class="mr-2"> 4 เดือน
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="due_date_" class="block text-sm font-medium text-[#D43F00]">วันที่ครบกำหนดการจำนำ</label>
                    <input type="date" id="due_date" name="due_date_pawn" class="w-full mt-1 p-3 border border-[#D43F00] rounded-md focus:ring-2 focus:ring-[#FFC107] text-[#000000]" required>
                </div>

                <!-- 🟢 ข้อมูล Transaction -->
              

                <div class="mb-6">
                    <label for="backup_interest_rate" class="block text-sm font-medium text-[#D43F00]">ดอกเบี้ยสำรอง (กรณีเกิดวิกฤต)</label>
                    <input type="number" id="backup_interest_rate" name="backup_interest_rate" step="0.01" value="0.5" class="w-full mt-1 p-3 border border-[#D43F00] rounded-md focus:ring-2 focus:ring-[#FFC107] text-[#000000]" required>
                </div>

               


                <button type="submit" class="w-full bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white p-3 rounded-md hover:bg-gradient-to-l focus:ring-2 focus:ring-[#FFC107] transition-all duration-300 ease-in-out">
                    เพิ่มข้อมูลการจำนำ
                </button>
            </form>
        </div>
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
