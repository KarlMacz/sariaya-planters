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
      <div class="card mb-4">
        <div class="card-body">
          <div class="display-5 mb-2">Profile</div>
          <x-flash-alert />
          <form action="{{ route('auth.register') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-sm-8">
                <div class="form-group">
                  <label for="" class="required">E-mail Address:</label>
                  <input type="text" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group">
                  <label for="">Contact Number:</label>
                  <input type="text" name="contact_number" class="form-control" value="{{ Auth::user()->contact_number }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm">
                <div class="form-group">
                  <label for="" class="required">First Name:</label>
                  <input type="text" name="first_name" class="form-control" value="{{ Auth::user()->first_name }}" required>
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group">
                  <label for="">Middle Name:</label>
                  <input type="text" name="middle_name" class="form-control" value="{{ Auth::user()->middle_name }}">
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group">
                  <label for="" class="required">Last Name:</label>
                  <input type="text" name="last_name" class="form-control" value="{{ Auth::user()->last_name }}" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-8">
                <div class="form-group">
                  <label for="" class="required">Address Line:</label>
                  <input type="text" name="address_line" class="form-control" value="{{ Auth::user()->address_line }}" required>
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group">
                  <label for="">Postal Code:</label>
                  <input type="text" name="postal_code" class="form-control" value="{{ Auth::user()->postal_code }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm">
                <div class="form-group">
                <label for="" class="required">Province:</label>
                  <select id="province-field" name="province" class="form-control" value="{{ Auth::user()->province_id}}" required>
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
                  <select id="municipality-field" name="city" class="form-control" value="{{ Auth::user()->municipality_id }}" required>
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
    </div>
  </div>
@endsection
