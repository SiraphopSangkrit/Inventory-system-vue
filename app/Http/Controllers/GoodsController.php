<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
            'cost_unit' => 'required|numeric|max_digits:12'
        ]);
        $goods = Goods::create([
            'goods_id' => $request->goods_id,
            'goods_name' => $request->goods_name,
            'cost_unit' => $request->cost_unit,
        ]);

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
