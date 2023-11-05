@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Orders</a></li>
  </ol>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex">
        <h4>Order List</h4>
        <span class="float-end">Total:{{ count($allOrders) }} </span>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="myTable">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Order ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Payment Method</th>
              <th>Total</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              @foreach ($allOrders as $key=> $orders )
              <td>{{ $key+1 }}</td>
              <td>{{ $orders->orderId }}</td>
              <td>{{ $orders->relToCustomerLogin->name }}</td>
              <td>{{ $orders->relToCustomerLogin->email }}</td>
              <td>{{ $orders->relToCustomerLogin->mobile }}</td>
              <td>
                @if ($orders->paymentMethod==2)
                <span class="text-primary">SSL</span>
                @elseif ($orders->paymentMethod==3)
                <span class="text-secondary">Stripe</span>
                @else
                <span class="text-success">Cash On</span>
                @endif
              </td>
              <td>{{ $orders->total }}</td>
              <td>
                @if ($orders->orderStatus==1)
                <span class="badge badge-primary">Pending</span>
                @elseif ($orders->orderStatus==2)
                <span class="badge badge-secondary">Confirmed</span>
                @elseif ($orders->orderStatus==3)
                <span class="badge badge-danger">Processing</span>
                @elseif ($orders->orderStatus==4)
                <span class="badge badge-info">Ready To Delivery</span>
                @elseif ($orders->orderStatus==5)
                <span class="badge badge-success">Delivered</span>
                @else
                <span class="badge badge-danger">Cancelled</span>
                @endif
              </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <circle fill="#000000" cx="5" cy="12" r="2" />
                        <circle fill="#000000" cx="12" cy="12" r="2" />
                        <circle fill="#000000" cx="19" cy="12" r="2" />
                      </g>
                    </svg>
                  </button>
                  <div class="dropdown-menu">
                    <form action="{{ route('customerOrderStatus') }}" method="POST">
                      @csrf
                      <input type="hidden" name="orderId" value="{{ $orders->id }}">
                      <button type="submit" name="status" class="dropdown-item" value="2">Confirmed</button>
                      <button type="submit" name="status" class="dropdown-item" value="3">Processing</button>
                      <button type="submit" name="status" class="dropdown-item" value="4">Ready To Delivary</button>
                      <button type="submit" name="status" class="dropdown-item" value="5">Delivered</button>
                      <button type="submit" name="status" class="dropdown-item" value="6">Cancel</button>
                    </form>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
@if (session('chngStatus'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('chngStatus') }}',
      showConfirmButton: true,
      timer: 2000,
    })
</script>
@endif
@endsection