<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\Utilities;

use Auth;

use App\Cart;
use App\Order;
use App\OrderItem;
use App\Product;

class GuestController extends Controller
{
    use Utilities;

    public function showIndex()
    {
        return view('guest.index', [
            'cart' => $this->getCart()
        ]);
    }

    public function showShop(Request $request)
    {
        $search_for = $request->input('search_for', '');

        $products = Product::where('is_displayed', true)
            ->where('quantity', '>', 0)
            ->where('name', 'LIKE', '%' . $search_for . '%')
            ->get();

        return view('guest.shop', [
            'cart' => $this->getCart(),
            'products' => $products
        ]);
    }

    public function showProduct($id)
    {
        $id = base64_decode($id);

        $product = Product::where('is_displayed', true)
            ->where('id', $id)
            ->first();

        $on_cart_count = Cart::where('product_id', $id)
            ->sum('quantity');

        return view('guest.product', [
            'cart' => $this->getCart(),
            'on_cart_count' => $on_cart_count,
            'product' => $product
        ]);
    }

    public function showCart()
    {
        return view('guest.cart', [
            'cart' => $this->getCart()
        ]);
    }

    public function showTransactionHistory()
    {
        $orders = Order::where('buyer_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guest.transaction-history', [
            'cart' => $this->getCart(),
            'orders' => $orders
        ]);
    }

    public function postAddToCart(Request $request)
    {
        $id = base64_decode($request->input('id'));
        $quantity = $request->input('quantity');

        $product = Product::where('id', $id)
            ->first();

        if($product == null || $product->quantity == 0 || $quantity > $product->quantity) {
            $this->flashPrompt('error', 'Unable to add this product to cart. Either product no longer exist or doesn\'t have enough stocks left.');

            return redirect()->back();
        }

        $cart_item = Cart::where('buyer_id', Auth::user()->id)
            ->where('product_id', $id)
            ->first();

        if($cart_item == null) {
            $new_cart_item = new Cart;

            $new_cart_item->buyer_id = Auth::user()->id;
            $new_cart_item->product_id = $id;
            $new_cart_item->quantity = $quantity;

            if($new_cart_item->save()) {
                $this->flashPrompt('ok', 'Product has been added to cart.');
            } else {
                $this->flashPrompt('error', 'Failed to add product to cart.');
            }
        } else {
            $cart_item->quantity += $quantity;

            if($cart_item->save()) {
                $this->flashPrompt('ok', 'Product in the cart has been updated.');
            } else {
                $this->flashPrompt('error', 'Failed to update product in the cart.');
            }
        }

        return redirect()->back();
    }

    public function deleteRemoveFromCart(Request $request)
    {
        $id = base64_decode($request->input('id'));

        $cart_item = Cart::where('id', $id)
            ->first();

        if($cart_item != null) {
            Cart::where('id', $id)
                ->delete();
        }

        return redirect()->back();
    }

    public function postCheckout(Request $request)
    {
        $payment_method = $request->input('payment_method');

        $cart = Cart::where('buyer_id', Auth::user()->id)
            ->get();

        if($cart->count() > 0) {
            $has_under_stock_products = false;

            foreach($cart as $cart_item) {
                if($cart_item->quantity > $cart_item->product->quantity) {
                    $has_under_stock_products = true;
                }
            }

            if(!$has_under_stock_products) {
                $new_order = new Order;

                $new_order->buyer_id = Auth::user()->id;
                $new_order->payment_method = $payment_method;

                if($new_order->save()) {
                    foreach($cart as $cart_item) {
                        $new_order_item = new OrderItem;

                        $new_order_item->order_id = $new_order->id;
                        $new_order_item->product_id = $cart_item->product_id;
                        $new_order_item->quantity = $cart_item->quantity;
                        $new_order_item->at_price = $cart_item->product->price;
                        $new_order_item->at_discount = $cart_item->product->discount;

                        if($new_order_item->save()) {
                            $product = Product::where('id', $cart_item->product_id)
                                ->first();

                            $product->quantity -= $cart_item->quantity;

                            if($product->save()) {
                                Cart::where('id', $cart_item->id)
                                    ->delete();
                            }
                        }
                    }

                    $this->createOrderLog($new_order->id, 'Your order has been placed. It will be processed as soon as possible.');
                }

                $this->flashPrompt('ok', 'Your order has been placed. It will be processed as soon as possible.');
            } else {
                $this->flashPrompt('error', 'Some products in the cart are either no longer exist or has insufficient or out of stock.');
            }
        } else {
            $this->flashPrompt('error', 'Failed to update product in the cart.');
        }

        return redirect()->back();
    }
}
