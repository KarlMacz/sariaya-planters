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
      <x-flash-alert />
      <div class="card h-100">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-4">
              <!-- Product Image Carousel -->
              <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <div class="d-flex align-items-center h-100 w-100">
                      <img class="d-block w-100" src="{{ asset('assets/img/product_Carousel_Temp1.jpg') }}" alt="First slide">
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="d-flex align-items-center h-100 w-100">
                      <img class="d-block w-100" src="{{ asset('assets/img/product_Carousel_Temp2.jpg') }}" alt="Second slide">
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="d-flex align-items-center h-100 w-100">
                      <img class="d-block w-100" src="{{ asset('assets/img/product_Carousel_Temp3.jpg') }}" alt="Third slide">
                    </div>
                  </div>
                </div>
                <a class="carousel-control-prev" href="#product-carousel" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#product-carousel" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
            <div class="col-sm">
              <h5 class="card-title m-0">{{ $product->name }}</h5>
              <h6 class="card-subtitle mb-4">Rate: {{ $product->rating }}</h6>
              <h4 class="text-success mt-auto mb-0">&#8369; {{ number_format(($product->discounted_price != null ? $product->discounted_price : $product->price), 2) }}</h4>
              @if($product->discounted_price != null)
                <h6 class="m-0">
                  <s class="text-muted">&#8369; {{ number_format($product->price, 2) }}</s>
                  <span class="ml-2">{{ $product->discount }}%</span>
                </h6>
              @endif
              @if($product->description != null)
                <div class="mt-4">{{ $product->description }}</div>
              @endif
              <form action="{{ route('guest.add-to-cart') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ base64_encode($product->id) }}">
                <div class="form-group mt-4">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <span>Quantity:</span>
                    </div>
                    <div class="col col-md-2 px-0">
                      <input type="number" class="form-control" name="quantity" min="1" max="{{ $product->quantity }}" value="0" {{ Auth::check() ? '' : 'disabled' }}>
                    </div>
                    <div class="col-auto">
                      <span>{{ $product->quantity }} piece{{ ($product->quantity) == 1 ? '' : 's' }} available.</span>
                    </div>
                  </div>
                </div>
                <div>
                  @if(Auth::check())
                    <button type="submit" class="btn btn-success">
                      <span class="fa-solid fa-cart-plus fa-fw"></span>
                      <span class="ml-2">Add to Cart</span>
                    </button>
                  @else
                    <a href="{{ route('auth.login', ['redirect_to' => route('guest.product', ['id' => base64_encode($product->id)], false)]) }}" class="btn btn-success">
                      <span class="fa-solid fa-right-to-bracket fa-fw"></span>
                      <span class="ml-2">Log In</span>
                    </a>
                  @endif
                </div>
              </form>
              <hr>
              <h6 class="m-0">Seller</h6>
              <h5>{{ $product->seller->store_name ?? '' }}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
