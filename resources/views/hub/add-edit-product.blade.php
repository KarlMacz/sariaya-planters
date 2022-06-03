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
            <div class="d-flex">
              <h3 class="card-title m-0">{{ ucfirst($mode) }} Product</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <x-flash-alert />
                <form action="{{ route('hub.products.add-edit', ['mode' => $mode, 'id' => ($product->id ?? null)]) }}" method="POST">
                  @csrf
                  <div class="form-group">
                    <label for="">Product Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name ?? '' }}" required autofocus>
                  </div>
                  <div class="form-group">
                    <label for="">Product Description:</label>
                    <textarea name="description" rows="3" class="form-control">{{ $product->description ?? '' }}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="">Price:</label>
                    <input type="number" name="price" class="form-control" step="0.01" value="{{ $product->price ?? '' }}" required>
                  </div>
                  <div class="row">
                    <div class="col-sm">
                      <div class="form-group">
                        <label for="">Stock (Quantity):</label>
                        <input type="number" name="quantity" class="form-control" step="1" value="{{ $product->quantity ?? '' }}" required>
                      </div>
                    </div>
                    <div class="col-sm">
                      <div class="form-group">
                        <label for="">Discount:</label>
                        <input type="number" name="discount" class="form-control" step="0.01" value="{{ $product->discount ?? '' }}" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="is_displayed" value="true" id="show-product-checkbox"{{ $product != null && $product->is_displayed ? ' checked' : '' }}>
                      <label class="form-check-label" for="show-product-checkbox">Show Product</label>
                    </div>
                  </div>
                  <div class="text-right">
                    <button type="submit" class="btn btn-success">
                      <span class="fa-solid fa-save fa-fw"></span>
                      <span class="ml-2">Save</span>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
