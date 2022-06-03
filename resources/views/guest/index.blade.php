@extends('layouts.guest')

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
  <div class="container py-5">
    <div class="row align-items-center">
      <div class="col-md-7">
        <h5 class="mt-0">Our Services</h5>
        <h2 class="mt-0">What We Offer</h2>
        <h5>Indoor plants</h5>
        <p>Should be an essential component of every interior design. Greenery brightens up indoor spaces and is known to have mood-boosting qualities.</p>
        <h6>Outdoor plants</h6>
        <p>offer us more than pretty colors and fragrances to enjoy. Plants give people health benefits as well, and some of those benefits might surprise you.</p>
        <h7>Garden care</h7>
        <p>From choosing the best plants for your yard these  will help you make your garden the best it can be.</p>
      </div>
      <div class="col-md-5">
        <img src="{{ asset('assets/img/1.png') }}" class="img-thumbnail m-0">
      </div>
    
  </div>
@endsection
