@extends('layouts.app')

@section('content')
<div class="container">
    <h1>อัปเดตดอกเบี้ยสำหรับทุกการจำนำ</h1>

    <!-- ฟอร์มอัปเดตดอกเบี้ย -->
    <form action="{{ route('pawns.updateInterestRate') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="interest_rate">ดอกเบี้ย (Rate)</label>
            <input type="number" name="interest_rate" id="interest_rate" class="form-control" value="{{ old('interest_rate') }}" step="0.01" min="0" required>
        </div>

        <button type="submit" class="btn btn-primary">อัปเดตดอกเบี้ยให้ทุกคน</button>
    </form>
</div>
@endsection
