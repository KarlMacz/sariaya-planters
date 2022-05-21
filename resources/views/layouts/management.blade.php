<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name') }}</title>
  <link rel="shortcut icon" href="/assets/img/plantita logo.jpg">
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('fontawesome-6.1.1/css/all.min.css') }}">
  <!-- CSS Files -->
  <link href="{{ asset('paper-dashboard/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('paper-dashboard/assets/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/guest-custom.css') }}" rel="stylesheet" />
@yield('resources')
</head>
<body class="bg-light">
@yield('content')
  <div>
    @yield('forms')
    <form class="logout-form" action="{{ route('auth.logout') }}" method="POST">
      @csrf
    </form>
  </div>
@yield('dialogs')
  <!-- JS Files -->
  <script src="{{ asset('paper-dashboard/assets/js/core/jquery.min.js') }}"></script>
  <script src="{{ asset('paper-dashboard/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('paper-dashboard/assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('paper-dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
  <script src="{{ asset('paper-dashboard/assets/js/plugins/bootstrap-notify.js') }}"></script>
  <script src="{{ asset('perfect-scrollbar-1.5.5/dist/perfect-scrollbar.min.js') }}"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function showLoader() {
      $('.loader').fadeIn(200);
    }

    function hideLoader() {
      $('.loader').fadeOut(200);
    }

    $(function() {
      $('body').on('click', '.logout-button', function() {
        $('.logout-form').trigger('submit');

        return false;
      });
    })
  </script>
@yield('scripts')
</body>
</html>
