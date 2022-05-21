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
      <div class="row justify-content-center">
        <div class="col-sm-6">
          <form action="">
            @csrf
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
      <div class="card-columns">
        @if($products->count() > 0)
          @foreach($products as $product)
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                @if($product->description != null)
                  <p>{{ $product->description }}</p>
                @endif
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>
@endsection
