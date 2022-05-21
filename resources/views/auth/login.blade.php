@extends('layouts.auth')

@section('content')
  <div class="d-flex flex-column align-items-center justify-content-center min-vh-100 min-vw-100">
    <div class="login-section py-4 py-md-0">
      <div class="mb-4">
        <a href="{{ route('guest.index') }}">
          <img src="{{ asset('assets/img/sp-logo.svg') }}" class="box-logo">
        </a>
      </div>
      <div class="card shadow-lg mb-4">
        <div class="card-body">
          <div class="display-5 mb-2">Sign In</div>
          <x-flash-alert />
          <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="">E-mail Address:</label>
              <input type="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="form-group">
              <label for="">Password:</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="text-right">
              <button type="submit" class="btn btn-success">
                <span class="fa-solid fa-right-to-bracket fa-fw"></span>
                <span class="ml-2">Sign In</span>
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="card shadow-lg">
        <div class="card-body">
          <div class="text-center">Not yet Registered? <a href="{{ route('auth.register') }}">Sign Up</a></div>
        </div>
      </div>
    </div>
  </div>
@endsection
