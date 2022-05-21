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
@yield('content')
  <div>
    @yield('forms')
    <form class="logout-form" action="{{ route('auth.logout') }}" method="POST">
      @csrf
    </form>
  </div>
@yield('dialogs')
  <!-- JS Files -->
  <script src="{{ asset('paper-kit-2/assets/js/jquery-1.10.2.js') }}"></script>
  <script src="{{ asset('paper-kit-2/assets/js/jquery-ui-1.10.4.custom.min.js') }}"></script>
  <script src="{{ asset('bootstrap-4.6.1/js/bootstrap.js') }}"></script>
  <!--  Plugins -->
  <script src="{{ asset('paper-kit-2/assets/js/ct-paper-checkbox.js') }}"></script>
  <script src="{{ asset('paper-kit-2/assets/js/ct-paper-radio.js') }}"></script>
  <script src="{{ asset('paper-kit-2/assets/js/bootstrap-select.js') }}"></script>
  <script src="{{ asset('paper-kit-2/assets/js/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('paper-kit-2/assets/js/ct-paper.js') }}"></script>
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
