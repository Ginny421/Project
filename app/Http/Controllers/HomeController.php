<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class HomeController extends Controller
{
    public function index()
    {
        $customers = Customer::all(); // ดึงข้อมูลลูกค้าทั้งหมดจากฐานข้อมูล
        return view('home', compact('customers'));
    }
}
