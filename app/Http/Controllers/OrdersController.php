<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrdersController extends Controller
{
    /**
     * Return all orders for products associated to the user.
     */
    public function orders()
    {
        $qry = Order::select('orders.*', 'products.product_name', 'inventories.sku')
            ->join('inventories', 'inventories.id', '=', 'orders.inventory_id')
            ->join('products', function ($join) {
                $join->on('products.id', '=', 'inventories.product_id')
                     ->on('products.id', '=', 'orders.product_id');
            })
            ->where('products.admin_id', request()->user()->id)
            ->orderBy('products.product_name');

        $sku = request()->input('sku');
        if ($sku) {
            $qry->where('inventories.sku', 'like', $sku . '%');
        }

        $productName = request()->input('product_name');
        if ($productName) {
            $qry->where('product_name', 'like', $productName . '%');
        }

        $orders = (clone $qry)
            ->paginate()
            ->appends(request()->only('sku', 'product_name'))
            ->onEachSide(2);

        return inertia('Orders', [
            'orders'         => OrderResource::collection($orders),
            'avg'            => '$' . number_format($qry->avg('orders.total_cents') / 100, 2, '.', ','),
            'total'          => '$' . number_format($qry->sum('orders.total_cents') / 100, 2, '.', ','),
            'totalOpen'      => (clone $qry)->where('orders.order_status', 'open')->count(),
            'totalPaid'      => (clone $qry)->where('orders.order_status', 'paid')->count(),
            'totalPending'   => (clone $qry)->where('orders.order_status', 'pending')->count(),
            'totalFulfilled' => (clone $qry)->where('orders.order_status', 'fulfulled')->count(),
            'totalShipped'   => (clone $qry)->where('orders.order_status', 'shipped')->count()
        ]);
    }

    /**
     * Show the requested order.
     *
     * @param Order $order
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load('product', 'inventory');

        return inertia('ViewOrder', [
            'order' => $order
        ]);
    }
}
