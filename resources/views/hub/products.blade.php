@extends('layouts.hub')

@section('scripts')
  <script>
    $(function() {
      $('body').on('click', '.delete-button', function() {
        let name = $(this).attr('data-var-name');

        Swal.fire({
          icon: 'question',
          title: `Delete ${name}?`,
          text: 'Are you sure you want to delete this product? This cannot be undone later.'
        })
      });
    });
  </script>
@endsection

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
            <h3 class="card-title m-0">Products</h3>
          </div>
          <div class="card-body">
            <x-flash-alert />
            <div class="text-right">
              <a href="{{ route('hub.products.add-edit', ['mode' => 'add']) }}" class="btn btn-success btn-sm d-inline-flex align-items-center ml-auto">
                <span class="fa-solid fa-plus fa-fw"></span>
                <span class="ml-2">Add Product</span>
              </a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th width="30%">Description</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Discount</th>
                  <th>Status</th>
                  <th>Action(s)</th>
                </tr>
              </thead>
              <tbody>
                @if($products->count() > 0)
                  @foreach($products as $product)
                    <tr>
                      <td>{{ $product->name }}</td>
                      <td>
                        @if($product->description != null && $product->description != '')
                          {{ $product->description }}
                        @else
                          <small>
                            <em class="text-muted">Not Provided</em>
                          </small>
                        @endif
                      </td>
                      <td>{{ $product->quantity }}</td>
                      <td>&#8369; {{ number_format($product->price, 2) }}</td>
                      <td>{{ $product->discount }}%</td>
                      <td class="text-center">
                        @if($product->is_displayed)
                          <span class="badge badge-success">On Display</span>
                        @else
                          <span class="badge badge-danger">Hidden</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <a href="{{ route('hub.products.add-edit', ['mode' => 'edit', 'id' => $product->id]) }}" class="btn btn-warning btn-sm d-inline-flex align-items-center">
                          <span class="fa-solid fa-edit fa-fw"></span>
                        </a>
                        <button class="btn btn-danger btn-sm" data-var-id="{{ $product->id }}" data-var-name="{{ $product->name }}">
                          <span class="fa-solid fa-trash fa-fw"></span>
                        </button>
                      </td>
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
