@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Coupon</a></li>
  </ol>
</div>

<div class="row">
  <div class="col-lg-12 m-auto">
    <div class="card">
      <div class="card-header">
        <h3>Add Coupon</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('couponStore') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-lg-3 mb-5">
              @error('couponName')
              <strong class="text-danger">{{ $message }}</strong><br>
              @enderror
              <input type="text" class="form-control" name="couponName" placeholder="Coupon Name"
                value="{{ old('couponName') }}">
            </div>
            <div class="col-lg-3 mb-5">
              @error('type')
              <strong class="text-danger">{{ $message }}</strong><br>
              @enderror
              <label for="type">Coupon Type</label>
              <select name="type" id="type" class="form-control">
                <option value="" disabled selected>--Select Type</option>
                <option value="1">Percentage</option>
                <option value="2">Solid Amount</option>
              </select>
            </div>
            <div class="col-lg-3 mb-5">
              @error('couponDiscount')
              <strong class="text-danger">{{ $message }}</strong><br>
              @enderror
              <input type="number" class="form-control" name="couponDiscount" placeholder="Discount"
                value="{{ old('couponDiscount') }}">
            </div>
            <div class="col-lg-3 mb-5">
              @error('minimum')
              <strong class="text-danger">{{ $message }}</strong><br>
              @enderror
              <input type="number" class="form-control" name="minimum" placeholder="Minimum Range TK"
                value="{{ old('minimum') }}">
            </div>
            <div class="col-lg-3 mb-5">
              @error('maximum')
              <strong class="text-danger">{{ $message }}</strong><br>
              @enderror
              <input type="number" class="form-control" name="maximum" placeholder="Maximum Range TK"
                value="{{ old('maximum') }}">
            </div>
            <div class="col-lg-3 mb-5">
              @error('validity')
              <strong class="text-danger">{{ $message }}</strong><br>
              @enderror
              <label for="val">Coupon Validity</label>
              <input type="date" id="val" class="form-control" name="validity" placeholder="">
            </div>
            <div class="col-lg-12 mt-4">
              <button type="submit" class="btn btn-primary">Add Coupon</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Coupon List</h3>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="myTable">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Coupon Name</th>
              <th>Type</th>
              <th>Coupon Discount</th>
              <th>Minimum Amount</th>
              <th>Maximum Amount</th>
              <th>Validity</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($coupon as $key=>$coupons )
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $coupons->couponName }}</td>
              <td class="badge badge-{{ $coupons->type==1?'success':'primary' }}">{{
                $coupons->type==1?'Percentage':'Solid Amount' }}</td>
              <td>{{ $coupons->type==1?$coupons->couponDiscount.'%':$coupons->couponDiscount.' TK' }}</td>
              <td>{{ $coupons->minimum }}</td>
              <td>{{ $coupons->maximum }}</td>
              <td>@if (Carbon\Carbon::now()->format('Y-m-d') > $coupons->validity)
                Date Expired.
                @else
                {{ Carbon\Carbon::now()->diffInDays($coupons->validity, false); }} Days Left</td>
              @endif
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
                    <a class="dropdown-item" href="{{ route('couponEdit',$coupons->id) }}">Edit</a>
                    <a class="dropdown-item" href="{{ route('couponDelete',$coupons->id) }}">Delete</a>
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
@if (session('couponIns'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('couponIns') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@if (session('deleteCpn'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('deleteCpn') }}',
      showConfirmButton: true,
      timer: 2000,
    })
</script>
@endif
@endsection