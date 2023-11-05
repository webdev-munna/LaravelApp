@extends('layouts.dashboard')
@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Product</a></li>
  </ol>
</div>
<form action="{{ route('productStore') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="card">
    <div class="card-header">
      <h3>Add Product</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Add Category</h4>
            </div>
            <div class="card-body">
              <div class="mb-3">
                @error('categoryId')
                <strong class="text-danger">{{ $message }}</strong>
                @enderror
                <select id="categoryId" name="categoryId" class="form-control text-center">
                  <option value="" disabled selected>---Select Category---</option>
                  @foreach ($categories as $categoryList )
                  <option value="{{ $categoryList->id }}">{{ $categoryList->category_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Add Subcategory</h4>
            </div>
            <div class="card-body">
              <div class="mb-3">
                @error('subcategoryId')
                <strong class="text-danger">{{ $message }}</strong>
                @enderror
                <select id="subcategory_id" name="subcategoryId" class="form-control text-center">
                  <option value="" disabled selected>---Select Subcategory---</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="mb-4">
            @error('productName')
            <strong class="text-danger">{{ $message }}</strong><br>
            @enderror
            <label for="p_n">Product Name</label>
            <input type="text" id="p_n" class="form-control" name="productName" placeholder="product name"
              value="{{ old('productName') }}">
          </div>
        </div>

        <div class="col-lg-6">
          <div class="mb-4">
            @error('price')
            <strong class="text-danger">{{ $message }}</strong><br>
            @enderror
            <label for="p_p">Product Price</label>
            <input type="number" id="p_p" class="form-control" name="price" placeholder="price"
              value="{{ old('price') }}">
          </div>
        </div>

        <div class="col-lg-6">
          <div class="mb-4">
            <label for="p_d">Discount</label>
            <input type="number" id="p_d" class="form-control" name="discount" placeholder="product discount"
              value="{{ old('discount') }}">
          </div>
        </div>

        <div class="col-lg-6">
          <div class="mb-4">
            <label for="p_b">Product Brand</label>
            <input type="text" id="p_b" class="form-control" name="brandName" placeholder="brand name"
              value="{{ old('brand') }}">
          </div>
        </div>

        <div class="col-lg-12">
          <div class="mb-4">
            <label for="s_d">Short Description</label>
            <input type="text" id="s_d" class="form-control" name="shortDescription" placeholder="product description"
              value="{{ old('shortDescription') }}">
          </div>
        </div>

        <div class="col-lg-12">
          <div class="mb-4">
            <label for="">Long Description</label>
            <textarea type="text" id="summernote" class="form-control" name="longDescription" cols="30"
              rows="10">{{ old('longDescription') }}</textarea>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="mb-4">
            @error('preview')
            <strong class="text-danger">{{ $message }}</strong><br>
            @enderror
            <label for="p_pre">Product Preview</label>
            <input type="file" id="p_pre" class="form-control" name="preview">
          </div>
        </div>

        <div class="col-lg-6">
          <div class="mb-4">
            @error('thumbnail')
            <strong class="text-danger">{{ $message }}</strong><br>
            @enderror
            <label for="p_t">Product Thumbnails</label>
            <input type="file" id="p_t" class="form-control" name="thumbnail[]" multiple>
          </div>
        </div>

        <div class="col-lg-4 m-auto">
          <div class="mb-5 mt-4 ">
            <button type="submit" class="btn btn-primary form-control bg-primary text-white">Add Product</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
@section('script')
<script>
  $('#categoryId').change(function(){
     var categoryId = $(this).val();

     $.ajaxSetup({
     headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   $.ajax({
     url:'/getSubcategory',
     type: 'POST',
     data:{'categoryId':categoryId},
     success:function(data){
        $('#subcategory_id').html(data);
     }
   })
});
</script>
<script>
  $(document).ready(function() {
  $('#summernote').summernote();
});
</script>
@if (session('productInsert'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('productInsert') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif

@endsection