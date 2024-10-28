<?php

namespace App\Http\Controllers;

use App\Models\H_order;
use App\Models\D_order;
use App\Models\M_order;
use App\Models\Goods;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
class OrderController extends Controller
{
    public function index()
    {
        $orders = H_order::with(['customers'])->withCount('d_order')->withSum('d_order', 'amount')->get();

        return Inertia::render('Order/order', [
            'orders' => $orders,
        ]);

    }
    public function AddOrder()
    {
        return Inertia::render('Order/addCusOrder', []);

    }
    public function AddOrderDetail(Request $request)
    {
        $orderId = $request->order_id;

        $orderHeader = H_order::where('Order_no', $orderId)->with('customers')->first();
        $orderHeader->Order_date = Carbon::parse($orderHeader->Order_date)
            ->locale('th')
            ->translatedFormat('d F Y');
        $orderDetails = D_order::where('Order_no', $orderId)->with('h_order', 'goods')->get();

        foreach ($orderDetails as $detail) {
            $detail->formatted_ord_date = Carbon::parse($detail->Ord_date)
                ->locale('th')
                ->translatedFormat('d F Y');  // Format example: "อาทิตย์, 28 ตุลาคม 2024"

            $detail->formatted_fin_date = $detail->Fin_date
                ? Carbon::parse($detail->Fin_date)->locale('th')->translatedFormat('d F Y')
                : null; // Handle nullable Fin_date
        }

        return Inertia::render('Order/addOrderDetail', [
            'order' => $orderHeader,
            'orderDetails' => $orderDetails,
        ]);

    }

    public function OrderDetailStore(Request $request)
    {
        $goods = D_order::create([
            'Order_no' => $request->Order_no,
            'goods_id' => $request->goods_id,
            'Ord_date' => $request->Ord_date,
            'Fin_date' => $request->Fin_date,
            'amount' => $request->amount,
            'cost_unit' => $request->cost_unit,
            'tot_prc' => $request->tot_prc,
        ]);

        return redirect()->back();
    }
    public function GoodsSearch(Request $request)
    {

        $query = $request->get('query', '');


        try {
            $results = Goods::where('goods_id', 'like', '%' . $query . '%')
                ->get();

            return response()->json($results);
        } catch (\Exception $e) {
            \Log::error('Error in CusSearch: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
    public function OrderDetail(Request $request)
    {
        $orderId = $request->order_id;
        $orderHeader = H_order::where('Order_no', $orderId)->with('customers')->first();

        $orderHeader->Order_date = Carbon::parse($orderHeader->Order_date)
            ->locale('th')
            ->translatedFormat('d F Y');

        $orderDetails = D_order::where('Order_no', $orderId)->with('h_order', 'goods')->get();

        foreach ($orderDetails as $detail) {
            $detail->formatted_ord_date = Carbon::parse($detail->Ord_date)
                ->locale('th')
                ->translatedFormat('d F Y');

            $detail->formatted_fin_date = $detail->Fin_date
                ? Carbon::parse($detail->Fin_date)->locale('th')->translatedFormat('d F Y')
                : null;
        }
        return Inertia::render('Order/OrderDetail', [
            'orderHeader' => $orderHeader,
            'orderDetails' => $orderDetails,
        ]);

    }
    public function EditOrderDetail(Request $request)
    {

        $orderId = $request->order_id;
        $orderHeader = H_order::where('Order_no', $orderId)->with('customers')->first();

        $orderHeader->Order_date = Carbon::parse($orderHeader->Order_date)
            ->locale('th')
            ->translatedFormat('d F Y');
        $orderDetailId = $request->order_detail_id;
        $orderDetail = D_order::with('h_order', 'goods')->find($orderDetailId);

        return Inertia::render('Order/EditOrderDetail', [
            'orderHeader' => $orderHeader,
            'orderDetail' => $orderDetail,
        ]);

    }

    public function UpdateOrderDetail(Request $request)
    {

        $orderDetailId = $request->order_detail_id;
        $orderDetail = D_order::find($orderDetailId);
        $orderDetail->amount = $request->amount;
        $orderDetail->Ord_date = $request->delivery_date;
        $orderDetail->Fin_date = $request->actual_delivery_date;
        $orderDetail->tot_prc = $request->tot_prc;
        $orderDetail->save();
        return redirect()->route('order.detail', [
            'cus_id' => $request->cus_id,
            'order_id' => $request->order_id,
        ]);
    }

    public function ProcessDatePage()
    {
        return Inertia::render('Order/ProcessDate', []);

    }
    public function ProcessDate(Request $request)
    {
        $gdoc_1 = Carbon::parse($request->gdoc_1)->startOfDay();
        $gdoc_2 = Carbon::parse($request->gdoc_2)->endOfDay();
        $orderDetails = D_order::whereBetween('Fin_date', [$gdoc_1, $gdoc_2])->with('h_order', 'h_order.customers')
            ->get();
        foreach ($orderDetails as $detail) {
            M_order::create([
                'cus_id' => $detail->h_order->cus_id,
                'goods_id' => $detail->goods_id,
                'Doc_date' => $detail->h_order->Order_date,
                'Ord_date' => $detail->Ord_date,
                'Fin_date' => $detail->Fin_date,
                'Sys_date' => now(),
                'amount' => $detail->amount,
                'cost_tot' => $detail->tot_prc,
            ]);

        $orderHeaderId = $detail->Order_no;
        $detail->delete();
        $remainingDetails = D_order::where('Order_no', $orderHeaderId)->count();
        if ($remainingDetails === 0) {

            H_order::where('Order_no', $orderHeaderId)->delete();
        }
    }



        return redirect()->route('dashboard');
    }
    public function OrderReport()
    {
        return Inertia::render('Order/report', []);

    }

    public function OrderHeaderStore(Request $request): RedirectResponse
    {
        $OrderHeader = H_order::create([
            'cus_id' => $request->cus_id,
            'Order_date' => $request->Order_date,
        ]);



        return redirect()->route('order.create.detail', [
            'cus_id' => $OrderHeader->cus_id,
            'order_id' => $OrderHeader->Order_no,
        ])->with([
                    'cus_id' => $OrderHeader->cus_id,
                    'order_id' => $OrderHeader->Order_no,
                ]);

    }
}
