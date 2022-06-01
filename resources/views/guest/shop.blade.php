@extends('layouts.guest')

@section('resources')
  <style>
    #main-section {
      min-height: 85vh;
    }
  </style>
@endsection

@section('content')
  <div id="banner" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="d-flex align-items-center h-100 w-100">
          <img class="d-block w-100" src="assets/img/carousel1.jpg" alt="First slide">
        </div>
      </div>
      <div class="carousel-item">
        <div class="d-flex align-items-center h-100 w-100">
          <img class="d-block w-100" src="assets/img/carousel2.jpg" alt="Second slide">
        </div>
      </div>
      <div class="carousel-item">
        <div class="d-flex align-items-center h-100 w-100">
          <img class="d-block w-100" src="assets/img/carousel3.JPG" alt="Third slide">
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#banner" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#banner" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <div id="main-section">
    <div class="container py-5">
      <div class="row justify-content-center mb-4">
        <div class="col-sm-8">
          <form action="">
            <div class="row">
              <div class="col-sm">
                <div class="form-group">
                  <input type="text" name="search_for" class="form-control" placeholder="Search for..." required>
                </div>
              </div>
              <div class="col-sm-auto">
                <button type="submit" class="btn btn-success">
                  <span class="fa-solid fa-magnifying-glass fa-fw"></span>
                  <span class="ml-2">Search</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row row-cols-1 row-cols-md-4">
        @if($products->count() > 0)
          @foreach($products as $product)
            <div class="col px-1 mb-2">
              <a href="{{ route('guest.product', ['id' => base64_encode($product->id)]) }}" class="card h-100">
                <div class="card-body">
                  <img src="{{ asset('assets/img/img_default.jpeg') }}" class="img-thumbnail">
                  <h5 class="card-title m-0">{{ $product->name }}</h5>
                  <h4 class="text-success mt-auto mb-0">&#8369; {{ number_format(($product->discounted_price != null ? $product->discounted_price : $product->price), 2) }}</h4>
                  @if($product->discounted_price != null)
                    <h6 class="m-0">
                      <s class="text-muted">&#8369; {{ number_format($product->price, 2) }}</s>
                      <span class="ml-2">{{ $product->discount }}%</span>
                    </h6>
                  @endif
                </div>
              </a>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>
@endsection
