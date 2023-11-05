@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Category</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Category</a></li>
  </ol>
</div>
<div class="row">
  <div class="col-lg-8 m-auto">
    <div class="card">
      <div class="card-header">
        <h3>Edit Category</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('updateCategory') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" value="{{ $category->id }}" name="category_id">
          <div class="mb-3">
            <label for="" class="form-label">Category Name</label><br>
            @if(session('categoryExists'))
            <strong class="text-danger">{{ session('categoryExists') }}</strong>
            @endif
            <input type="text" class="form-control" value="{{ $category->category_name }}" name="category_name">
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Category Image</label><br>
            @error('category_image')
            <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <input onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
              type="file" class="form-control" name="category_image">
            <img id="blah" width="100" src="{{ asset('uploads/category/'.$category->category_image) }}">
          </div>
          <div class="mt-5">
            <button class="btn btn-primary">Update Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
@if (session('categoryUpdate'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('categoryUpdate') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@endsection