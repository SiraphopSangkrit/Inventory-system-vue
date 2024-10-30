<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Models\Goods;


class GoodsController extends Controller
{
    public function index()
    {
        return Inertia::render('databasepage/goods', [
            'goods' => Goods::all(),
        ]);

    }
    public function StoreGoods(Request $request): RedirectResponse
    {
        $request->validate([
            'goods_id' => 'required|unique:goods_name|max:10',
            'goods_name' => 'required|max:30',
            'cost_unit' => 'required|numeric|max_digits:12',],[
                // Custom error messages
                'goods_id.required' => 'กรุณาใส่รหัสสินค้า.',
                'goods_id.unique' => 'รหัสสินค้าซ้ำ กรุณาใส่รหัสสินค้าใหม่',
                'goods_id.max' => 'ใส่รหัสสินค้าได้ไม่เกิน 10 ตัว',
                'goods_name.required' => 'กรุณาใส่รายละเอียดสินค้า',
                'goods_name.max' => 'ใส่รายละเอียดสินค้าได้ไม่เกิน 30 ตัว',
                'cost_unit.required' => 'กรุณาใส่ราคาสินค้า',
                'cost_unit.numeric' => 'ราคาสินค้าต้องเป็นตัวเลขเท่านั้น',
                'cost_unit.max_digits' => 'ราคาสินค้าต้องไม่เกิน 12 หลัก',
        ]);
        $goods = Goods::create([
            'goods_id' => $request->goods_id,
            'goods_name' => $request->goods_name,
            'cost_unit' => $request->cost_unit,
        ]);

        return redirect()->back();
    }
    public function UpdateGoods(Request $request): RedirectResponse
    {
        $request->validate([
            'goods_name_Edit' => 'required|max:30',
            'goods_cost_unit_Edit' => 'required|numeric|max_digits:12'],[

                'goods_name_Edit.required' => 'กรุณาใส่รายละเอียดสินค้า',
                'goods_name_Edit.max' => 'ใส่รายละเอียดสินค้าได้ไม่เกิน 30 ตัว',
                'cost_unit_Edit.required' => 'กรุณาใส่ราคาสินค้า',
                'cost_unit_Edit.numeric' => 'ราคาสินค้าต้องเป็นตัวเลขเท่านั้น',
                'cost_unit_Edit.max_digits' => 'ราคาสินค้าต้องไม่เกิน12หลัก',
        ]);
        $goodsId= $request->goods_id_Edit;


       $goods = Goods::find($goodsId);

        $goods->goods_name = $request->goods_name_Edit;
        $goods->cost_unit = $request->goods_cost_unit_Edit;
        $goods->save();
        return redirect()->back();
    }

    public function GoodsDestroy($id)
    {

        $goods = Goods::findOrFail($id);
        $goods->delete();
        return redirect()->back();
    }

    public function CusSearch(Request $request)
    {
        $query = $request->get('query', '');
    try {
        $results = Customers::where('cus_id', 'like', '%' . $query . '%')
                            ->get();

        return response()->json($results);
    } catch (\Exception $e) {
        \Log::error('Error in CusSearch: ' . $e->getMessage());
        return response()->json(['error' => 'Server error'], 500);
    }
    }
}
