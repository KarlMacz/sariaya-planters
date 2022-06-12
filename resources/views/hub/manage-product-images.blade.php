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
              <h3 class="card-title m-0">Manage Product Images</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <x-flash-alert />
                <div class="mb-4">
                  <label for="">Uploaded Image(s):</label>
                  <div>
                    @if($product->images->count() > 0)
                      @foreach($product->images as $image)
                        <div class="d-inline-block position-relative m-1" style="width: 30%;">
                          <form action="{{ route('hub.products.delete-image', ['id' => base64_encode($image->id)]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-cross">
                              <span class="fa-solid fa-times fa-fw"></span>
                            </button>
                          </form>
                          <img src="{{ asset('uploads/' . $image->filename) }}" class="img-thumbnail w-100 m-0">
                        </div>
                      @endforeach
                    @else
                      <div class="alert alert-secondary text-dark">No uploaded images.</div>
                    @endif
                  </div>
                </div>
                <hr>
                <form action="{{ route('hub.products.manage-images', ['id' => base64_encode($product->id)]) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <input type="file" name="images[]" multiple required>
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
