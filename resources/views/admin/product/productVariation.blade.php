@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Product Variation</a></li>
  </ol>
</div>
<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4>Add Product Color</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('colorStore') }}" method="POST">
          @csrf
          <div class="mb-3">
            @error('colorName')
            <strong class="text-danger">{{ $message }}</strong><br>
            @enderror
            <input type="text" class="form-control" name="colorName" placeholder="Color Name">
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" name="colorCode" placeholder="Color Code">
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary mt-4">Add Color</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4>Add Product Size</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('productSize') }}" method="POST">
          @csrf
          <div class="mb-3">
            @error('size')
            <strong class="text-danger">{{ $message }}</strong><br>
            @enderror
            <input type="text" class="form-control" name="size" placeholder="Product Size">
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary mt-4">Add Size</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4>Color List</h4>
      </div>
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Color Name</th>
              <th>Color</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($colors as $key=>$color )
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $color->colorName }}</td>
              <td>
                <div style="background-color:{{ $color->colorCode }};color:transparent">.</div>
              </td>
              <td><a href="{{ route('deleteColor',$color->id) }}" class="btn btn-danger">Delete</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4>Size List</h4>
      </div>
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Size Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($sizes as $key=>$size )
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $size->productSize }}</td>
              <td><a href="{{ route('deleteSize',$size->id) }}" class="btn btn-danger">Delete</a></td>
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
@if (session('colorInserted'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('colorInserted') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@if (session('sizeInserted'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('sizeInserted') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@if (session('deleteColor'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('deleteColor') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@if (session('deleteSize'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('deleteSize') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@endsection