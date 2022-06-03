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
              <h3 class="card-title m-0">Update Order Status</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <x-flash-alert />
                <form action="{{ route('hub.orders.status', ['id' => ($order->id ?? null)]) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="">Customer Name:</label>
                    <input type="text" class="form-control" value="{{ $order->buyer->full_name ?? '' }}" disabled>
                  </div>
                  <?php
                    $total = 0;
                  ?>
                  <table class="table table-bordered table-striped table-sm">
                    <thead>
                      <tr>
                        <th width="10%">Qty</th>
                        <th>Product Name</th>
                        <th width="20%">Price</th>
                        <th width="20%">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($order->items->count() > 0)
                        @foreach($order->items as $order_item)
                          <?php
                            $total += ($order_item->quantity * ($order_item->discounted_price != null ? $order_item->discounted_price : $order_item->at_price));
                          ?>
                          <tr>
                            <td class="text-center">
                              <strong>(x{{ $order_item->quantity }})</strong>
                            </td>
                            <td>
                              <span>{{ $order_item->product->name }}</span>
                            </td>
                            <td>
                              <strong>&#8369; {{ number_format(($order_item->discounted_price != null ? $order_item->discounted_price : $order_item->at_price), 2) }}</strong>
                              @if($order_item->discounted_price != null)
                                <div>
                                  <small>
                                    <s class="text-muted">&#8369; {{ number_format($order_item->at_price, 2) }}</s>
                                    <span class="ml-2">{{ $order_item->at_discount }}%</span>
                                  </small>
                                </div>
                              @endif
                            </td>
                            <td class="text-right">&#8369; {{ number_format(($order_item->quantity * ($order_item->discounted_price != null ? $order_item->discounted_price : $order_item->at_price)), 2) }}</td>
                          </tr>
                        @endforeach
                      @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="text-right" colspan="3">Total</th>
                        <th class="text-right">&#8369; {{ number_format($total, 2) }}</th>
                      </tr>
                    </tfoot>
                  </table>
                  <div class="form-group">
                    <label for="">Status:</label>
                    <select name="status" class="form-control" required>
                      <option value="" selected disabled>Select an option...</option>
                      <option value="PENDING" {{ $order->status == 'PENDING' ? ' selected' : '' }}>Pending</option>
                      <option value="PROCESSING" {{ $order->status == 'PROCESSING' ? ' selected' : '' }}>Processing</option>
                      <option value="DELIVERING" {{ $order->status == 'DELIVERING' ? ' selected' : '' }}>Delivering</option>
                      @if($order->status == 'DELIVERING' && $total == $order->amount_paid)
                        <option value="COMPLETED" {{ $order->status == 'COMPLETED' ? ' selected' : '' }}>Completed</option>
                      @endif
                      @if($order->status == 'PENDING' || $order->status == 'PROCESSING')
                        <option value="DECLINED" {{ $order->status == 'DECLINED' ? ' selected' : '' }}>Declined</option>
                      @endif
                    </select>
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
