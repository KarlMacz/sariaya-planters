<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\Utilities;

use Auth;

use App\Order;
use App\Product;

class HubController extends Controller
{
    use Utilities;

    public function showOrders()
    {
        $orders = Order::where('status', '!=', 'CANCELLED')
            ->get();

        return view('hub.orders', [
            'orders' => $orders
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
}
