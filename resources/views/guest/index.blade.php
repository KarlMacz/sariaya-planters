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
        <h2 class="mt-0">The Jade</h2>
        <p>Basic info: The Jade is grown indoors and borrows itself from the bonsai in the way it grows like a miniature tree, with a trunk and branches. It is also a succulent that will retain water well within the leaves, just like the cactus plant.</p>
        <p>This succulent is a hardy fellow and has two main requirements for a healthy long life, which is water and plenty of light. They are both an indoor and outdoor species, although conditions outside need to be right (enough heat and sun).</p>
        <p>How it looks and displaying: As mentioned above the Jade has a similar look to a bonsai tree with a thick trunk and branches. The leaves are a thick oval shaped type which are a shiny dark green and possibly red colored outer edge's. They can produce white or pink flowers in the right conditions, once they have matured. The most important aspect of displaying this shrub is plenty of sunlight.....close to a window.</p>
      </div>
      <div class="col-md-5">
        <img src="{{ asset('assets/img/img_public1.jpg') }}" class="img-thumbnail m-0">
      </div>
    </div>
    <hr class="my-5">
    <div class="row align-items-center">
      <div class="col-md-7 order-md-2">
        <h2 class="mt-0">Hibiscus Flowers</h2>
        <p>Growing and size: Many of these are grown in gardens or indoors as mentioned above, and can grow up to a fair few feet tall and wide. Growing in the home requires them to be pruned to keep there size down to what's suitable for the place it's housed in.</p>
        <p>How they look: The Rose of China is an attractive shrub with shiny dark green, toothed leaves. Five colorful petals bloom and a long staminal column (pollen stalk) sits in the center of the flower. At the right height indoors they look charming.</p>
      </div>
      <div class="col-md-5">
        <img src="{{ asset('assets/img/img_public2.jpg') }}" class="img-thumbnail m-0">
      </div>
    </div>
    <hr class="my-5">
    <div class="row align-items-center">
      <div class="col-md-7">
        <h2 class="mt-0">The White Lily Flowers</h2>
        <p>The white lily flowers (known as a spathe) begin blooming with a twist at first before flourishing and revealing it's yellow or white spadix in the center. The right light conditions are required for the flowers to bloom which can last a couple of months.</p>
      </div>
      <div class="col-md-5">
        <img src="{{ asset('assets/img/img_public3.jpg') }}" class="img-thumbnail m-0">
      </div>
    </div>
    <hr class="my-5">
    <div class="row align-items-center">
      <div class="col-md-7 order-md-2">
        <h2 class="mt-0">Aloe Vera</h2>
        <p>Medicinal and health benefits: Aloe is available in juice for drinking (tastes good), skin care, coolant for sunburn and is also used for other purposes.</p>
        <p>There seems to be no satisfactory evidence of the benefits or safety of consuming or using A.vera products.</p>
        <p>I would say it seems possible aloe offers health benefits from drinking because it is a natural plant which is where we usually get most of the goodness from in our foods and other products for health (that's only my thought’s though and not evidence). I love the drink but the coolant I used for sun burn did not work and felt very uncomfortable and sticky. Other products have worked much better when I have had sun burn.</p>
      </div>
      <div class="col-md-5">
        <img src="{{ asset('assets/img/img_public4.JPG') }}" class="img-thumbnail m-0">
      </div>
    </div>
    <hr class="my-5">
    <div class="row align-items-center">
      <div class="col-md-7">
        <h2 class="mt-0">Spider Plant</h2>
        <p>Minimal care: This plant can survive with minimal care/attention and can manage low temperatures. However, they will start to look very unattractive and create mess (leaves falling and browning) without enough water and light or too much of either. When they're taken care of properly they look great.</p>
      </div>
      <div class="col-md-5">
        <img src="{{ asset('assets/img/img_public5.jpg') }}" class="img-thumbnail m-0">
      </div>
    </div>
  </div>
@endsection
