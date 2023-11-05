@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Category</a></li>
  </ol>
</div>
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header d-flex">
        <h4>Category List</h4>
        <span class="float-end">Total: {{ count($categories); }}</span>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="myTable">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Category Image</th>
              <th>Category Name</th>
              <th>Added By</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($categories as $key=>$category )
            <tr>
              <td>{{ $key+1 }}</td>
              <td><img width="60" src="{{ asset('uploads/category') }}/{{ $category->category_image }}"></td>
              <td>{{ $category->category_name }}</td>
              <td>{{ $category->relToUser->name }}</td>
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
                    <a class="dropdown-item" href="{{ route('categoryEdit',$category->id) }}">Edit</a>
                    <a class="dropdown-item" href="{{ route('categoryDelete',$category->id) }}">Move To Trash</a>
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
        <h4>Add Category</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('categoryStore') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="cate" class="form-label">Category Name</label><br>
            @error('category_name')
            <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <input type="text" id="cate" class="form-control" name="category_name" value="{{ old('category_name') }}">
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Category Image</label>
            <br>
            @error('category_image')
            <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <input type="file" class="form-control" name="category_image">
          </div>
          <div class="mt-3">
            <button type="submit" class="btn btn-primary">Add Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Trash category --}}

<div class="col-lg-12">
  <div class="card">
    <div class="card-header d-flex">
      <h4>Trashed Category List</h4>
      <span class="float-end">Total: {{ count($trashCategories); }}</span>
    </div>
    <div class="card-body">
      <table class="table table-striped" id="myTable">
        <thead>
          <tr>
            <th>Sl</th>
            <th>Category Image</th>
            <th>Category Name</th>
            <th>Added By</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($trashCategories as $key=>$category )
          <tr>
            <td>{{ $key+1 }}</td>
            <td><img width="60" src="{{ asset('uploads/category') }}/{{ $category->category_image }}"></td>
            <td>{{ $category->category_name }}</td>
            <td>{{ $category->relToUser->name }}</td>
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
                  <a class="dropdown-item" href="{{ route('categoryRestore',$category->id) }}">Restore</a>
                  <a class="dropdown-item" href="{{ route('categoryForceDelete',$category->id) }}">Permanently
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
@if (session('categoryIns'))
<script>
  Swal.fire(
      'Success',
      '{{ session('categoryIns') }}',
      'success'
    )
</script>
@endif
@if (session('delCategory'))
<script>
  Swal.fire(
      'Success',
      '{{ session('delCategory') }}',
      'success'
    )
</script>
@endif
@if (session('categoryRestore'))
<script>
  Swal.fire(
      'Success',
      '{{ session('categoryRestore') }}',
      'success'
    )
</script>
@endif
@if (session('categoryFDelete'))
<script>
  Swal.fire(
      'Success',
      '{{ session('categoryFDelete') }}',
      'success'
    )
</script>
@endif
{{-- data table --}}
<script>
  $(document).ready( function () {
  $('#myTable').DataTable();
} );

</script>
@endsection