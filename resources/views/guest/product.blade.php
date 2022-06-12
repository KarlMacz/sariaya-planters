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
      <div class="card mb-4">
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
              <h4 class="card-title m-0">{{ $product->name }}</h4>
              @if($product->rating > 0)
                <div class="d-flex align-items-center mb-2">
                  <small class="mr-2">Overall Rating: {{ $product->rating }}</small>
                  <div class="rating">
                    @for($i = 0; $i < $product->rating; $i++)
                      <span class="colored">☆</span>
                    @endfor
                  </div>
                </div>
              @else
                <div class="mb-2">
                  <em class="text-muted">No rating</em>
                </div>
              @endif
              <h4 class="text-success mt-auto mb-0">&#8369; {{ number_format(($product->discounted_price != null ? $product->discounted_price : $product->price), 2) }}</h4>
              @if($product->discounted_price != null)
                <h6 class="m-0">
                  <s class="text-muted">&#8369; {{ number_format($product->price, 2) }}</s>
                  <span class="ml-2">{{ $product->discount }}%</span>
                </h6>
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
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-body">
          <h6 class="m-0">Seller:</h6>
          <h4 class="mt-0 mb-{{ $product->description != null && $product->description != '' ? '4' : '0' }}">{{ $product->seller->store_name ?? '' }}</h4>
          @if($product->description != null && $product->description != '')
            <h6 class="m-0">Product Description:</h6>
            <div>{!! nl2br(trim($product->description)) !!}</div>
          @endif
        </div>
      </div>
      @if(Auth::check())
        <div class="card mb-4">
          <div class="card-body">
            <form action="{{ route('guest.product.comment', ['id' => base64_encode($product->id)]) }}" method="POST">
              @csrf
              <div class="form-group">
                <label>Comment:</label>
                <textarea name="message" rows="2" class="form-control no-resize" required></textarea>
              </div>
              <div class="row">
                <div class="col-sm">
                  <div class="d-flex align-items-center mb-2">
                    <label>Rate:</label>
                    <div class="rating">
                      <input type="radio" id="rating-5" name="rating" value="5" required><label for="rating-5">☆</label>
                      <input type="radio" id="rating-4" name="rating" value="4" required><label for="rating-4">☆</label>
                      <input type="radio" id="rating-3" name="rating" value="3" required><label for="rating-3">☆</label>
                      <input type="radio" id="rating-2" name="rating" value="2" required><label for="rating-2">☆</label>
                      <input type="radio" id="rating-1" name="rating" value="1" required><label for="rating-1">☆</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-auto">
                  <div class="text-right">
                    <button type="submit" class="btn btn-success">
                      <span class="fa-solid fa-paper-plane fa-fw"></span>
                      <span class="ml-2">Post</span>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      @endif
      @if($product->comments->count() > 0)
        <div class="card mb-4">
          <div class="card-body">
            <h6>Comments:</h6>
            <hr>
            @foreach($product->comments as $comment)
              <div class="p-2">
                <div>
                  <strong>{{ $comment->user->full_name }}</strong>
                </div>
                @if($comment->rating > 0)
                  <div class="rating">
                    @for($i = 0; $i < $comment->rating; $i++)
                      <span class="colored">☆</span>
                    @endfor
                  </div>
                @endif
                @if($comment->comment != null && $comment->comment != '')
                  <div>{!! nl2br(trim($comment->comment)) !!}</div>
                @else
                  <div>
                    <em>No comment.</em>
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection
