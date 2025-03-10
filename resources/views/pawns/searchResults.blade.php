@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-r from-[#D43F00] to-[#FFC107] text-white">
        <div class="content-container max-w-4xl mx-auto py-10 px-6">
            <!-- Header for search results -->
            <div class="bg-white p-8 rounded-lg shadow-xl text-center mb-6">
                <h1 class="text-3xl font-semibold text-[#D43F00] mb-2">ผลการค้นหาสำหรับ: "{{ $search }}"</h1>
                <p class="text-lg text-[#FFC107]">แสดงผลลัพธ์ที่เกี่ยวข้องกับชื่อหรือตั๋วจำนำ</p>
            </div>

            <!-- Search Results Table -->
            <div class="bg-white p-8 rounded-lg shadow-xl">
                @if($pawns->isEmpty())
                    <p class="text-center text-xl text-[#D43F00]">ไม่พบผลลัพธ์ที่ตรงกัน</p>
                @else
                    <table class="min-w-full bg-white border border-[#D43F00] rounded-lg shadow-md">
                        <thead class="bg-[#D43F00] text-white">
                            <tr>
                                <th class="py-2 px-4 text-left">Ticket ID</th>
                                <th class="py-2 px-4 text-left">Product Name</th>
                                <th class="py-2 px-4 text-left">Customer Name</th>
                                <th class="py-2 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pawns as $pawn)
                                <tr class="border-b hover:bg-[#FFC107]">
                                    <td class="py-2 px-4">{{ $pawn->ticket_id }}</td>
                                    <td class="py-2 px-4">{{ $pawn->product_name }}</td>
                                    <td class="py-2 px-4">{{ $pawn->customer->name }}</td>
                                    <td class="py-2 px-4">{{ $pawn->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
