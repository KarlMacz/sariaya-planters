<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name') }}</title>
  <link rel="shortcut icon" href="/assets/img/plantita logo.jpg">
  <!-- Fonts and Icons -->

  <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('fontawesome-6.1.1/css/all.min.css') }}">
  <!-- CSS Files -->
  <link href="{{ asset('bootstrap-4.6.1/css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('paper-kit-2/assets/css/ct-paper.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/guest-custom.css') }}" rel="stylesheet" />
  <!-- Other Resources -->
@yield('resources')
</head>
<body class="bg-light">
  <nav class="navbar navbar-ct-success navbar-expand-lg navbar-light sticky-top shadow-lg mb-0">
    <div class="container">
      <a class="navbar-brand p-0 m-0" href="{{ route('guest.index') }}">
        <img src="{{ asset('assets/img/sp-logo.svg') }}" class="logo">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav w-100">
          <li class="nav-item mr-auto">
            <a class="nav-link" href="{{ route('guest.shop') }}">Shop Now</a>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle no-caret" data-toggle="dropdown">
              <span class="fa-solid fa-bell fa-fw"></span>
            </a>
            <div id="notifications" class="dropdown-menu dropdown-menu-right" style="width: 20rem;">
              <div></div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
              {{ Auth::user()->full_name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="{{ route('guest.transaction-history') }}">Transaction History</a>
              <a class="dropdown-item" href="{{ route('hub.orders') }}">Seller's Hub</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('guest.profile') }}">Profile</a>
              <a class="dropdown-item logout-button" href="#">Log Out</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
@yield('content')
  <footer class="footer bg-white p-4 shadow-lg">
    <div class="container">
      <p class="m-0">Copyright ?? 2022 Sariaya Planters. All Rights Reserved.</p>
    </div>
  </footer>
  <div>
    @yield('forms')
    <form class="logout-form" action="{{ route('auth.logout') }}" method="POST">
      @csrf
    </form>
  </div>
@yield('dialogs')
  <!-- JS Files -->
  <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ asset('bootstrap-4.6.1/js/bootstrap.bundle.min.js') }}"></script>
  <!--  Plugins -->
  <script src="{{ asset('paper-kit-2/assets/js/ct-paper-checkbox.js') }}"></script>
  <script src="{{ asset('paper-kit-2/assets/js/ct-paper-radio.js') }}"></script>
  <!-- <script src="{{ asset('paper-kit-2/assets/js/ct-paper.js') }}"></script> -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function showLoader() {
      $('.loader').fadeIn(200);
    }

    function hideLoader() {
      $('.loader').fadeOut(200);
    }

    function fetchNotifications() {
      $.ajax({
        url: "{{ route('api.fetch.notifications') }}",
        method: 'POST',
        data: {
          id: '{{ base64_encode(Auth::user()->id) }}'
        },
        dataType: 'json',
        success: function(response) {
          if(response.status == 'ok') {
            $('#notifications').html(`<div class="py-2 px-3">
                <span>Pending Order${response.data.pending_orders_count == 1 ? '' : 's'}:</span>
                <strong class="float-right">x${response.data.pending_orders_count}</strong>
              </div>
              <div class="dropdown-divider m-0"></div>
              <div class="py-2 px-3">
                <span>Processing Order${response.data.processing_orders_count == 1 ? '' : 's'}:</span>
                <strong class="float-right">x${response.data.processing_orders_count}</strong>
              </div>
              <div class="dropdown-divider m-0"></div>
              <div class="py-2 px-3">
                <span>Delivering Order${response.data.delivering_orders_count == 1 ? '' : 's'}:</span>
                <strong class="float-right">x${response.data.delivering_orders_count}</strong>
              </div>
              <div class="dropdown-divider m-0"></div>
              <div class="py-2 px-3">
                <span>Completed Order${response.data.completed_orders_count == 1 ? '' : 's'}:</span>
                <strong class="float-right">x${response.data.completed_orders_count}</strong>
              </div>`);
          }
        }
      });
    }

    $(function() {
      fetchNotifications();

      setInterval(fetchNotifications, 5000);

      $('[data-toggle="tooltip"]').tooltip();

      $('body').on('click', '.logout-button', function() {
        $('.logout-form').trigger('submit');

        return false;
      });
    })
  </script>
@yield('scripts')
</body>
</html>
