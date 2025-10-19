<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    public function editCustomer($id) {
        $customers = Customer::orderBy('name')->get();
        $customerToEdit = Customer::find($id);
        return view('pages.customer', compact('customers', 'customerToEdit', 'id'));
    }
}
