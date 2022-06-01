<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\Utilities;

use Auth;

use App\Cart;
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
    }
}
