@extends('layouts.dashboard')
@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Subcategory</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Subcategory</a></li>
  </ol>
</div>
<div class="row">
  <div class="col-lg-8 m-auto">
    <div class="card">
      <div class="card-header">
        <h4>Edit Subcategory</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('updateSubcategory') }}" method="post">
          @csrf
          <input type="hidden" value="{{ $subCategories->id }}" name="subcategoryId">
          <div class="mb-3">
            <select name="categoryId" id="" class="form-control">
              @foreach ($categories as $category )
              <option {{ ($category->id == $subCategories->categoryId)?'selected':'' }} value="{{ $category->id }}">{{
                $category->category_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Subcategory Name</label>
            <input type="text" class="form-control" value="{{ $subCategories->subcategoryName }}"
              name="subcategoryName">
          </div>
          <div class="mt-3">
            <button type="submit" class="btn btn-primary">Update Subcatogry</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
@if (session('updateSubcategory'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('updateSubcategory') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@endsection