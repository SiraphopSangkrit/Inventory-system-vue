<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Order/order',[]);

    }
    public function AddOrder()
    {
        return Inertia::render('Order/addCusOrder',[]);

    }
    public function AddOrderDetail()
    {
        return Inertia::render('Order/addOrderDetail',[]);

    }
    public function EditOrderDetail()
    {
        return Inertia::render('Order/EditOrderDetail',[]);

    }
    public function UpdateOrderDetail()
    {
        return Inertia::render('Order/UpdateOrderDetail',[]);

    }
    public function ProcessDate()
    {
        return Inertia::render('Order/ProcessDate',[]);

    }

    public function OrderReport()
    {
        return Inertia::render('Order/report',[]);

    }
}
