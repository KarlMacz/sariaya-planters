@extends('layouts.guest')

@section('content')
  <div class="position-relative">
    <div class="d-flex flex-column align-items-center justify-content-center position-absolute h-100 w-100" style="z-index: 1;">
      <div style="background-color: rgba(0, 0, 0, 0.5); border-radius: 1rem; max-width: 50%;">
        <img src="{{ asset('assets/img/sp-logo.svg') }}" class="box-logo">
        <div class="display-5 text-white text-center pb-4" style="text-shadow: 2px 4px #477035;">Bringing Nature to Every Home</div>
      </div>
    </div>
    <div id="banner" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="d-flex align-items-center h-100 w-100">
            <img class="d-block w-100" src="{{ asset('assets/img/carousel1.jpg') }}" alt="First slide">
          </div>
        </div>
        <div class="carousel-item">
          <div class="d-flex align-items-center h-100 w-100">
            <img class="d-block w-100" src="{{ asset('assets/img/carousel2.jpg') }}" alt="Second slide">
          </div>
        </div>
        <div class="carousel-item">
          <div class="d-flex align-items-center h-100 w-100">
            <img class="d-block w-100" src="{{ asset('assets/img/carousel3.jpg') }}" alt="Third slide">
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
  </div>
  <div class="container py-5">
    <div class="row align-items-center">
      <div class="col-md-7">
        <h5 class="mt-0">Our Services</h5>
        <h2 class="mt-0">What We Offer</h2>
        <h5>Indoor plants</h5>
        <p>Should be an essential component of every interior design. Greenery brightens up indoor spaces and is known to have mood-boosting qualities.</p>
        <h5>Outdoor plants</h5>
        <p>offer us more than pretty colors and fragrances to enjoy. Plants give people health benefits as well, and some of those benefits might surprise you.</p>
        <h5>Garden care</h5>
        <p>From choosing the best plants for your yard these  will help you make your garden the best it can be.</p>
      </div>
      <div class="col-md-5">
        <img src="{{ asset('assets/img/1.png') }}" class="img-thumbnail m-0">
      </div>
    </div>
  </div>
@endsection
