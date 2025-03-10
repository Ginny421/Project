<x-app-layout>
    @livewire('navigation-menu')

    <div class="min-h-screen bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white">
        <div class="content-container max-w-4xl mx-auto py-10 px-6">
            <!-- Content -->
            <div class="bg-white p-8 rounded-lg shadow-xl text-center">
                <h1 class="text-4xl font-semibold text-[#D43F00] mb-6">ตรวจสอบข้อมูลการจำนำสินค้า</h1>
                <p class="text-lg text-[#FFC107] mb-6">คุณสามารถค้นหาทุกอย่างที่เกี่ยวข้องกับทองที่นี่</p>

                <!-- Search Form -->
                <form method="post" action="{{ route('pawns.search') }}" class="flex items-center space-x-4">
                    
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="ค้นหาด้วยชื่อหรือตั๋วจำนำ" 
                        value="{{ request()->get('search') }}" 
                        class="px-4 py-2 rounded-md border border-[#D43F00] focus:outline-none focus:ring-2 focus:ring-[#FFC107] text-[#D43F00] w-full"
                    >
                    <a 
                        href="{{ route('pawns.search') }}?search={{ request()->get('search') }}" 
                        class="px-6 py-2 bg-[#D43F00] text-white font-semibold rounded-md hover:bg-[#FFC107] focus:outline-none focus:ring-2 focus:ring-[#FFC107]"
                    >
                        ค้นหา
                    </a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
