<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\Utilities;

use Auth;

use App\Order;
use App\OrderLog;
use App\Product;

class HubController extends Controller
{
    use Utilities;

    public function showOrders()
    {
        $orders = Order::where('status', '!=', 'CANCELLED')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hub.orders', [
            'orders' => $orders
        ]);
    }

    public function showOrderStatus($id)
    {
        $order = Order::where('id', $id)
            ->first();

        return view('hub.update-order-status', [
            'order' => $order
        ]);
    }

    public function showOrderPayment($id)
    {
        $order = Order::where('id', $id)
            ->first();

        return view('hub.update-order-payment', [
            'order' => $order
        ]);
    }

    public function showProducts()
    {
        $products = Product::where('seller_id', Auth::user()->id)
            ->get();

        return view('hub.products', [
            'products' => $products
        ]);
    }

    public function showAddEditProduct($mode, $id = null)
    {
        $product = null;

        if($mode == 'edit' && $id != null) {
            $product = Product::where('seller_id', Auth::user()->id)
                ->where('id', $id)
                ->first();
        }

        return view('hub.add-edit-product', [
            'mode' => $mode,
            'product' => $product
        ]);
    }

    public function postAddEditProduct($mode, $id = null, Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description', null);
        $price = $request->input('price');
        $quantity = $request->input('quantity');
        $discount = $request->input('discount');
        $is_displayed = $request->boolean('is_displayed', false);

        if($mode == 'add') {
            $new_product = new Product;

            $new_product->name = $name;
            $new_product->description = $description;
            $new_product->price = $price;
            $new_product->quantity = $quantity;
            $new_product->discount = $discount;
            $new_product->is_displayed = $is_displayed;

            if($new_product->save()) {
                $this->flashPrompt('ok', 'Product has been added.');

                return redirect()->route('hub.products');
            } else {
                $this->flashPrompt('error', 'Failed to add product.');
            }
        }

        if($mode == 'edit') {
            $existing_product = Product::where('seller_id', Auth::user()->id)
                ->where('id', $id)
                ->first();

            $existing_product->name = $name;
            $existing_product->description = $description;
            $existing_product->price = $price;
            $existing_product->quantity = $quantity;
            $existing_product->discount = $discount;
            $existing_product->is_displayed = $is_displayed;

            if($existing_product->save()) {
                $this->flashPrompt('ok', 'Product has been updated.');

                return redirect()->route('hub.products');
            } else {
                $this->flashPrompt('error', 'Failed to edit product.');
            }
        }

        return redirect()->back();
    }

    public function putOrderStatus($id, Request $request)
    {
        $status = $request->input('status');

        $order = Order::where('id', $id)
            ->first();

        if($order != null) {
            if($order->status != $status) {
                $order->status = $status;

                if($order->save()) {
                    $order_log = new OrderLog;

                    $order_log->order_id = $order->id;

                    switch($order->status) {
                        case 'PENDING':
                            $order_log->message = 'Your order has been placed. It will be processed as soon as possible.';

                            break;
                        case 'PROCESSING':
                            $order_log->message = 'Your order is now being processed.';

                            break;
                        case 'DELIVERING':
                            $order_log->message = 'Your order is now being delivered. Delivery driver is now on his/her way to delivery address.';

                            break;
                        case 'COMPLETED':
                            $order_log->message = 'Your order has been completed. Thank you for ordering.';

                            break;
                        case 'CANCELLED':
                            $order_log->message = 'Your order has been cancelled.';

                            break;
                        case 'DECLINED':
                            $order_log->message = 'Your order has been declined by the seller.';

                            break;
                    }

                    $order_log->save();

                    $this->flashPrompt('ok', 'Order status has been updated.');
                } else {
                    $this->flashPrompt('error', 'Failed to update order status.');
                }
            } else {
                $this->flashPrompt('error', 'No changes has been made.');
            }
        } else {
            $this->flashPrompt('error', 'Order doesn\'t exist.');
        }

        return redirect()->back();
    }

    public function putOrderPayment($id, Request $request)
    {
        $amount_paid = $request->input('amount_paid');

        $order = Order::where('id', $id)
            ->first();

        if($order != null) {
            if($order->amount_paid != $amount_paid) {
                $order->amount_paid = $amount_paid;

                if($order->save()) {
                    $this->flashPrompt('ok', 'Order payment has been updated.');
                } else {
                    $this->flashPrompt('error', 'Failed to update order payment.');
                }
            } else {
                $this->flashPrompt('error', 'No changes has been made.');
            }
        } else {
            $this->flashPrompt('error', 'Order doesn\'t exist.');
        }

        return redirect()->route('hub.orders.payment');
    }
}
