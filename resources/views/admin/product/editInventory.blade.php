@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Product</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Inventory</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Inventory</a></li>
  </ol>
</div>
<div class="row">
  <div class="col-lg-8 m-auto">
    <div class="card">
      <div class="card-header">
        <h3>Edit Product Inventory</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('updateInventory') }}" method="post">
          @csrf
          <div class="mb-4">
            <input type="hidden" value="{{ $inventory->id }}" name="inventoryId">
            <strong> Product Name : {{ $inventory->relToProduct->productName }}</strong>
          </div>
          <div class="mb-4">
            <label for="" class="font-weight-bold">Image</label><br>
            <img width="100" src="{{ asset('uploads/product/preview/'.$inventory->relToProduct->previewImage) }}"
              alt="">
          </div>
          <div class="mb-4">
            <label for="" class="font-weight-bold">Product Color</label>
            <select name="colorId" id="" class="form-control">
              <option value="" disabled selected>-- Select Color --</option>
              @foreach ($colors as $color )
              <option {{ ($color->id == $inventory->colorId)?'selected':'' }} value="{{ $color->id }}">{{
                $color->colorName }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="" class="font-weight-bold">Product Size</label>
            <select name="sizeId" id="" class="form-control">
              <option value="" disabled selected>--Select Size--</option>
              @foreach ($size as $sizes )
              <option {{ ($sizes->id == $inventory->sizeId)?'selected':'' }} value="{{ $sizes->id }}">{{
                $sizes->productSize }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="" class="font-weight-bold">Quantity</label>
            <input type="number" class="form-control" value="{{ $inventory->quantity }}" name="quantity">
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary mt-4">Update Inventory</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
@if (session('updateInventory'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('updateInventory') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@endsection