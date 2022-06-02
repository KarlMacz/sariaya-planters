@extends('layouts.guest')

@section('resources')
  <style>
    #main-section {
      min-height: 85vh;
    }
  </style>
@endsection

@section('content')
  <div id="main-section">
    <div class="container py-5">
      <div class="row">
        <div class="col-sm-4">
          <div class="card mb-4">
            <div class="card-body">
              <label>ORDERED BY:</label>
              <h4 class="mt-0">{{ Auth::user()->full_name }}</h4>
              <label>DELIVERY ADDRESS:</label>
              <h6 class="mt-0"">{{ Auth::user()->full_address }}</h6>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <x-flash-alert />
          <div class="card h-100">
            <div class="card-body">
              <h3 class="mt-0">My Cart</h3>
              <div class="list-group">
                @if($cart->count() > 0)
                  @foreach($cart as $cart_item)
                    <div class="list-group-item">
                      <div class="row align-items-center">
                        <div class="col">
                          <h5 class="m-0"><a href="{{ route('guest.product', ['id' => base64_encode($cart_item->product_id)]) }}">{{ $cart_item->product->name }}</a></h5>
                          <h4 class="text-success mt-auto m-0">&#8369; {{ number_format(($cart_item->product->discounted_price != null ? $cart_item->product->discounted_price : $cart_item->product->price), 2) }}</h4>
                          <h6 class="m-0">
                            <small>
                              <s class="text-muted">&#8369; {{ number_format($cart_item->product->price, 2) }}</s>
                              <span class="ml-2">{{ $cart_item->product->discount }}%</span>
                            </small>
                          </h6>
                        </div>
                        <div class="col-auto">
                          <div class="form-group">
                            <label for="">Order Qty:</label>
                            <input type="number" class="form-control" name="quantity" min="1" max="{{ $cart_item->product->quantity }}" value="{{ $cart_item->quantity }}" {{ Auth::check() ? '' : 'disabled' }}>
                          </div>
                        </div>
                        <div class="col-auto">
                          <form action="{{ route('guest.remove-from-cart') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ base64_encode($cart_item->id) }}">
                            <button type="submit" class="btn btn-danger btn-sm m-0">
                              <span class="fa-solid fa-trash fa-fw"></span>
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @else
                  <div class="list-group-item">
                    <div class="text-center">
                      <em class="text-muted">Empty Cart</em>
                    </div>
                  </div>
                @endif
              </div>
              @if($cart->count() > 0)
                <div class="mt-2">
                  <form action="{{ route('guest.checkout') }}" method="POST">
                    @csrf
                    <div class="row align-items-center justify-content-between">
                      <div class="col-sm-5">
                        <div class="form-group mb-0">
                          <label for="">Payment Method:</label>
                          <select name="payment_method" class="form-control" required>
                            <option value="" selected disabled>Select an option...</option>
                            <option value="COD">Cash on Delivery</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-auto">
                        <button type="submit" class="btn btn-success m-0">
                          <span class="fa-solid fa-check fa-fw"></span>
                          <span class="ml-2">Checkout</span>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
