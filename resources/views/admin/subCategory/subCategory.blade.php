@extends('layouts.dashboard')
@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Sub Category</a></li>
  </ol>
</div>
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header d-flex">
        <h4>Subcategory List</h4>
        <span class="float-end">Total: {{ count($subCategories); }}</span>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="subcategoryTable">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Category Id</th>
              <th>Subcategory Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($subCategories as $key=>$subCategory )
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $subCategory->relToCategory->category_name }}</td>
              <td>{{ $subCategory->subcategoryName }}</td>
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
                    <a class="dropdown-item" href="{{ route('editSubcategory',$subCategory->id) }}">Edit</a>
                    <a class="dropdown-item" href="{{ route('deleteSubcategory',$subCategory->id) }}">Soft Delete</a>
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
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h4>Add Subcategory</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('subcategoryStore') }}" method="post">
          @csrf
          <div class="mb-3">
            @error('categoryId')
            <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <select name="categoryId" id="" class="form-control">
              <option value="" disabled selected>--Select Category--</option>
              @foreach ($categories as $category )
              <option value="{{ $category->id }}">{{ $category->category_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            @error('subcategoryName')
            <strong class="text-danger">{{ $message }}</strong><br>
            @enderror
            <label for="subcategory" class="form-label">Subcategory Name</label>
            <input type="text" class="form-control" id="subcategory" name="subcategoryName"
              value="{{ old('subcategoryName') }}">
          </div>
          <div class="mt-3">
            <button type="submit" class="btn btn-primary">Add Subcategory</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="col-lg-12">
  <div class="card">
    <div class="card-header">
      <h4>Trash Subcategory List</h4>
      <span class="float-end">Total: {{ count($trashsubCategory); }}</span>
    </div>
    <div class="card-body">
      <table class="table table-striped" id="myTable">
        <thead>
          <tr>
            <th>Sl</th>
            <th>Category Id</th>
            <th>Subcategory Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($trashsubCategory as $key=>$subCategory )
          <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $subCategory->relToCategory->category_name }}</td>
            <td>{{ $subCategory->subcategoryName }}</td>
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
                  <a class="dropdown-item" href="{{ route('restoreSubcategory',$subCategory->id) }} }}">Restore</a>
                  <a class="dropdown-item" href="{{ route('permantdeleteSubcategory',$subCategory->id) }}">Permantly
                    Delete</a>
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
@endsection
@section('script')
@if (session('subcatStore'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('subcatStore') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@if (session('delSubcategory'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('delSubcategory') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@if (session('permanantdelSubcategory'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('permanantdelSubcategory') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@if (session('restoreSubcategory'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('restoreSubcategory') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
{{-- data table --}}
<script>
  $(document).ready( function () {
  $('#subcategoryTable').DataTable();
} );
</script>
@endsection