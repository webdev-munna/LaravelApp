@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Permission</a></li>
  </ol>
</div>
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h3>Permission List</h3>
      </div>
      <div class="card-body">
        <table class="table table-striped table-dark" id="myTable">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Permission Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allPermissions as $key=>$Permissions )
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $Permissions->name }}</td>
              <td>
                <a href="{{ route('permission.edit',$Permissions->id) }}"><button class="btn btn-info">Edit</button></a>
                <a onclick="return confirm('are you sure??');"
                  href="{{ route('permission.delete',$Permissions->id) }}"><button
                    class="btn btn-danger">Delete</button></a>
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
        <h3>Add New Permission</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('permission.store') }}" method="post">
          @csrf
          <div class="mb-3">
            <label for="permission">Permission Name</label>
            <input type="text" id="permission" class="form-control" name="permissionName">
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary">Add Permission</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
@if (session('success'))
<script>
  const Toast = Swal.mixin({
  toast: true,
  position: 'top-right',
  iconColor: 'white',
  customClass: {
    popup: 'colored-toast'
  },
  showConfirmButton: false,
  timer: 2500,
  timerProgressBar: true
})
 Toast.fire({
  icon: 'success',
  title: '{{ session('success') }}'
})
</script>
@endif
@endsection