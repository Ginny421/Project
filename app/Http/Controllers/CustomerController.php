<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        Customer::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return redirect()->route('customers.index')->with('success', 'เพิ่มลูกค้าเรียบร้อย!');
    }

    public function show($id)
    {
        $customer = Customer::where('id', $id)->first();
    
        if (!$customer) {
            abort(404, 'ไม่พบลูกค้าในระบบ');
        }
    
        return view('customers.show', compact('customer'));
    }
    
    



public function edit(Customer $customer)
{
    return view('customers.edit', compact('customer'));
}


public function update(Request $request, Customer $customer)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'address' => 'nullable|string|max:500',
    ]);

    $customer->update([
        'name' => $request->name,
        'phone_number' => $request->phone_number,
        'address' => $request->address,
    ]);

    return redirect()->route('customers.index')->with('success', 'ข้อมูลลูกค้าถูกอัพเดตแล้ว!');
}

public function destroy(Customer $customer)
{
    // Delete the customer record
    $customer->delete();

    // Redirect back to the customer list with a success message
    return redirect()->route('customers.index')->with('success', 'ข้อมูลลูกค้าถูกลบแล้ว!');
}

}
