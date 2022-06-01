@extends('layouts.hub')

@section('content')
  <div class="p-3 p-lg-5">
    <div class="row">
      <div class="col-sm-3">
        <div class="list-group mb-4">
        <a href="{{ route('hub.orders') }}" class="list-group-item">Orders</a>
        <a href="{{ route('hub.products') }}" class="list-group-item">Products</a>
        </div>
      </div>
      <div class="col-sm">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title m-0">Orders</h3>
          </div>
          <div class="card-body">
            <x-flash-alert />
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Customer</th>
                  <th>Product(s)</th>
                  <th>Action(s)</th>
                </tr>
              </thead>
              <tbody>
                @if($orders->count() > 0)
                  @foreach($orders as $order)
                    <tr>
                      <td></td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
