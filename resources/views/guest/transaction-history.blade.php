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
      <div class="row">
        <div class="col-sm-4">
          <div class="card mb-4">
            <div class="card-body">
              <label>ORDERED BY:</label>
              <h4 class="mt-0">{{ Auth::user()->full_name }}</h4>
              <label>DELIVERY ADDRESS:</label>
              <h6 class="mt-0"">{{ Auth::user()->full_address }}</h6>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <x-flash-alert />
          <div class="card h-100">
            <div class="card-body">
              <h3 class="mt-0">Transaction History</h3>
              <div class="list-group">
                @if($orders->count() > 0)
                  @foreach($orders as $order)
                    <div class="list-group-item">
                      <h6>Transaction Date: <strong>{{ $order->created_at->format('F d, Y (h:i A)') }}</strong></h6>
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
                      <table class="table table-bordered table-striped table-sm">
                        <tbody>
                          <tr>
                            <th class="text-right" width="30%">Status:</th>
                            <td>
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
                          </tr>
                          <tr>
                            <th class="text-right" width="30%">Payment Method:</th>
                            <td>{{ $order->paymentMethod() }}</td>
                          </tr>
                          <tr>
                            <th class="text-right" width="30%">Amount Paid:</th>
                            <td>&#8369; {{ number_format($order->amount_paid, 2) }}</td>
                          </tr>
                        </tbody>
                      </table>
                      @if($order->logs->count() > 0 && $order->status !== 'CANCELLED')
                        <div class="timeline">
                          @foreach($order->logs as $order_log)
                            <div class="timeline-item">
                              <small class="lh-1">
                                <strong>{{ $order_log->created_at->format('F d, Y (h:i A)') }}</strong>
                              </small>
                              <div>{{ $order_log->message }}</div>
                            </div>
                          @endforeach
                        </div>
                      @endif
                    </div>
                  @endforeach
                @else
                  <div class="list-group-item">
                    <div class="text-center">
                      <em class="text-muted">No previous transactions</em>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
