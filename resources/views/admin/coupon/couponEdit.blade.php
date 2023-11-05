@extends('layouts.dashboard')
@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('coupon') }}">Coupon</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)"> Edit Coupon</a></li>
  </ol>
</div>
<div class="row">
  <div class="col-lg-8 m-auto">
    <div class="card">
      <div class="card-header">
        <h3>Edit Coupon</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('couponUpdate') }}" method="POST">
          @csrf
          <input type="hidden" name="couponId" value="{{ $couponInfos->id }}">
          <div class="mb-3">
            <label for="name">Coupon Name</label>
            <input type="text" id="name" class="form-control" name="couponName" value="{{ $couponInfos->couponName }}">
          </div>
          <div class="mb-3">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control">
              <option value="" disabled selected>--Select Type</option>
              <option {{ $couponInfos->type==1?'selected':'' }} value="1">Percentage</option>
              <option {{ $couponInfos->type==2?'selected':'' }} value="2">Solid Amount</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="dis">Discount</label>
            <input type="number" id="dis" class="form-control" name="discount"
              value="{{ $couponInfos->couponDiscount }}">
          </div>
          <div class="mb-3">
            <label for="min">Minimum Tk</label>
            <input type="number" id="min" class="form-control" name="minimum" value="{{ $couponInfos->minimum }}">
          </div>
          <div class="mb-3">
            <label for="max">Maximum</label>
            <input type="number" id="max" class="form-control" name="maximum" value="{{ $couponInfos->maximum }}">
          </div>
          <div class="mb-3">
            <label for="val">Validity</label>
            <input type="date" id="val" class="form-control" name="validity" value="{{ $couponInfos->validity }}">
          </div>
          <div class="mt-5">
            <button type="submit" class="btn btn-primary">Update Coupon</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
@if (session('couponUpdate'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('couponUpdate') }}',
      showConfirmButton: true,
      timer: 1500,
    })
</script>
@endif
@endsection