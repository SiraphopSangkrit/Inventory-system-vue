<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\View\View;
use Inertia\Inertia;
use App\Models\Customers;



class CustomerController extends Controller
{
    public function index()
    {

        return Inertia::render('databasepage/customer',[
            'customers' => Customers::all(),
    ]);

    }

    public function StoreCus(Request $request): RedirectResponse  {
      $request->validate([
            'cus_id' => 'required|unique:cus_name|max:5',
            'cus_name' => 'required|max:30',
        ]);

        $customer = Customers::create([
            'cus_id' => $request->cus_id,
            'cus_name' => $request->cus_name,
        ]);

        return redirect()->back();
    }

    public function CusDestroy($id) {

        $customer = Customers::findOrFail($id);
        $customer->delete();
        return redirect()->back();
    }
}
