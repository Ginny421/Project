<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = Customer::all(); // ดึงข้อมูลลูกค้าจากฐานข้อมูล
        return view('dashboard', compact('customers'));
    }
}
