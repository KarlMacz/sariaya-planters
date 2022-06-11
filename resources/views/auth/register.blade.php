@extends('layouts.auth')

@section('content')
  <div class="d-flex flex-column align-items-center justify-content-center min-vh-100 min-vw-100">
    <div class="register-section py-4 py-md-0">
      <div class="mb-4">
        <a href="{{ route('guest.index') }}">
          <img src="{{ asset('assets/img/sp-logo.svg') }}" class="box-logo">
        </a>
      </div>
      <div class="card shadow-lg mb-4">
        <div class="card-body">
          <div class="display-5 mb-2">Sign Up</div>
          <x-flash-alert />
          <form action="{{ route('auth.register') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-sm-8">
                <div class="form-group">
                  <label for="" class="required">E-mail Address:</label>
                  <input type="text" name="email" class="form-control" required>
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group">
                  <label for="">Contact Number:</label>
                  <input type="text" name="contact_number" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm">
                <div class="form-group">
                  <label for="" class="required">Password:</label>
                  <input type="password" name="password" class="form-control" required>
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group">
                  <label for="" class="required">Confirm Password:</label>
                  <input type="password" name="password_confirmation" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm">
                <div class="form-group">
                  <label for="" class="required">First Name:</label>
                  <input type="text" name="first_name" class="form-control" required>
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group">
                  <label for="">Middle Name:</label>
                  <input type="text" name="middle_name" class="form-control">
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group">
                  <label for="" class="required">Last Name:</label>
                  <input type="text" name="last_name" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-8">
                <div class="form-group">
                  <label for="" class="required">Address Line:</label>
                  <input type="text" name="address_line" class="form-control" required>
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group">
                  <label for="">Postal Code:</label>
                  <input type="text" name="postal_code" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm">
                <div class="form-group">
                <label for="" class="required">Province:</label>
                  <select id="province-field" name="province" class="form-control" required>
                    <option value="" selected disabled>Province</option>
                    @if(count($provinces) > 0)
                      @foreach($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group">
                  <label for="" class="required">City / Municipality:</label>
                  <select id="municipality-field" name="city" class="form-control" required>
                    <option value="" selected disabled>City / Municipality</option>
                  </select>
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group">
                  <label for="" class="required">Barangay:</label>
                  <select id="barangay-field" name="barangay" class="form-control" required>
                    <option value="" selected disabled>Barangay</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-8">
                <div class="form-group">
                  <label for="">Store Name:</label>
                  <input type="text" name="store_name" class="form-control">
                </div>
              </div>
            </div>
            <div class="text-right">
              <button type="submit" class="btn btn-success">
                <span class="fas fa-sign-in-alt fa-fw"></span>
                <span class="ml-2">Sign Up</span>
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="card shadow-lg">
        <div class="card-body">
          <div class="text-center">Already Registered? <a href="{{ route('auth.login') }}">Sign In</a></div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(function() {
      $('body').on('change', '#province-field', function(e) {
        $.ajax({
          url: "{{ route('api.fetch.municipality') }}",
          method: 'POST',
          data: {
            ph_province_id: e.target.value
          },
          dataType: 'json',
          success: function(response) {
            if(response.status == 'ok') {
              if(response.data.length > 0) {
                $('#municipality-field').html(`<option value="" selected disabled>City / Municipality</option>`);

                response.data.forEach(function(item) {
                  $('#municipality-field').append(`<option value="${item.id}">${item.name}</option>`);
                });
              }
            }
          }
        });
      });

      $('body').on('change', '#municipality-field', function(e) {
        $.ajax({
          url: "{{ route('api.fetch.barangay') }}",
          method: 'POST',
          data: {
            ph_municipality_id: e.target.value
          },
          dataType: 'json',
          success: function(response) {
            if(response.status == 'ok') {
              if(response.data.length > 0) {
                $('#barangay-field').html(`<option value="" selected disabled>Barangay</option>`);

                response.data.forEach(function(item) {
                  $('#barangay-field').append(`<option value="${item.id}">${item.name}</option>`);
                });
              }
            }
          }
        });
      });
    });
  </script>
@endsection
