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
            <table class="table table-striped m-0">
              <thead>
                <tr>
                  <th>Transaction Date</th>
                  <th>Customer</th>
                  <th>Product(s)</th>
                  <th>Payment Method</th>
                  <th>Total Amount</th>
                  <th>Amount Paid</th>
                  <th>Status</th>
                  <th>Action(s)</th>
                </tr>
              </thead>
              <tbody>
                @if($orders->count() > 0)
                  @foreach($orders as $order)
                    <?php
                      $total = 0;
                    ?>
                    <tr>
                      <td>{{ $order->created_at->format('F d, Y (h:i A)') }}</td>
                      <td>{{ $order->buyer->full_name }}</td>
                      <td>
                        @if($order->items->count() > 0)
                          @foreach($order->items as $order_item)
                            <?php
                              $total += ($order_item->quantity * $order_item->discounted_price);
                            ?>
                            <div>
                              <strong>(x{{ $order_item->quantity }})</strong>
                              <span class="ml-1">{{ $order_item->product->name }}</span>
                            </div>
                          @endforeach
                        @endif
                      </td>
                      <td>{{ $order->paymentMethod() }}</td>
                      <td class="text-right">&#8369; {{ number_format($total, 2) }}</td>
                      <td class="text-right">&#8369; {{ number_format($order->amount_paid, 2) }}</td>
                      <td class="text-center">
                        @switch($order->status)
                          @case('COMPLETED')
                            <span class="badge badge-success">Completed</span>

                            @break
                          @case('PROCESSING')
                            <span class="badge badge-info">Processing</span>

                            @break
                          @case('CANCELLED')
                            <span class="badge badge-danger">Cancelled</span>

                            @break
                          @case('DELIVERING')
                            <span class="badge badge-warning">Delivering</span>

                            @break
                          @default
                            <span class="badge badge-secondary">Pending</span>

                            @break
                        @endswitch
                      </td>
                      <td class="text-center">
                        @if($total != $order->amount_paid)
                          <a href="{{ route('hub.orders.payment', ['id' => $order->id]) }}" class="btn btn-success btn-sm d-inline-flex align-items-center" data-toggle="tooltip" title="Update Payment">
                            <span class="fa-solid fa-money-bill-wave-alt fa-fw"></span>
                          </a>
                        @endif
                        @if($order->status != 'COMPLETED' && $order->status != 'DECLINED' && $order->status != 'CANCELLED')
                          <a href="{{ route('hub.orders.status', ['id' => $order->id]) }}" class="btn btn-info btn-sm d-inline-flex align-items-center" data-toggle="tooltip" title="Update Status">
                            <span class="fa-solid fa-pen-nib fa-fw"></span>
                          </a>
                        @endif
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
