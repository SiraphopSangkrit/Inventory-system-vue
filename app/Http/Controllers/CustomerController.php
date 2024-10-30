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
            'cus_name' => 'required|max:30'],[

                'cus_id.required' => 'กรุณาใส่รหัสลูกค้า.',
                'cus_id.unique' => 'รหัสลูกค้าซ้ำ กรุณาใส่รหัสลูกค้าใหม่',
                'cus_id.max' => 'ใส่รหัสลูกค้าได้ไม่เกิน 10 ตัว',
                'cus_name.required' => 'กรุณาใส่ชื่อลูกค้า.',
                'cus_name.max' => 'ใส่ชื่อลูกค้าได้ไม่เกิน 30 ตัว',
        ]);

        $customer = Customers::create([
            'cus_id' => $request->cus_id,
            'cus_name' => $request->cus_name,
        ]);

        return redirect()->back();
    }

    public function UpdateCus(Request $request): RedirectResponse {
        $request->validate([
            'cus_name_Edit' => 'required|max:30',
        ]);
        $customer = Customers::find($request->id);
        $customer->cus_name = $request->cus_name_Edit;
        $customer->save();
        return redirect()->back();
    }
    public function CusDestroy($id) {

        $customer = Customers::findOrFail($id);
        $customer->delete();
        return redirect()->back();
    }
}
