@extends('layouts.dashboard')
@section('content')
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h4>Role Assign Permission List</h4>
        <span class="float-end"></span>
      </div>
      <div class="card-body">
        <table class="table table-striped table-dark" id="myTable">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Role</th>
              <th>Permissions</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($roles as $key=>$item )
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $item->name }}</td>
              <td>
                {{-- Here permissions is default keyword of spatie permission package --}}
                @foreach ($item->permissions as $permission )
                <strong class="badge badge-pill badge-info text-white my-1">{{ $permission->name }}</strong>
                @endforeach
                &nbsp;
              </td>
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
                    <a class="dropdown-item" href="{{ route('role.permission.edit',$item->id) }}">Edit</a>
                    <a onclick="return confirm('Are you sure??')" class="dropdown-item"
                      href="{{ route('role.permission.delete',$item->id) }}">Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center text-danger">No data available.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h3>Create & Assign Role</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('role.assign.store') }}" method="post">
          @csrf
          <div class="mb-3">
            <label for="roleName" class="form-label">New Role Name</label><br>
            @error('roleName')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            <input type="text" autofocus id="roleName" class="form-control" name="roleName" placeholder="Role Name">
          </div>
          <div class="mb-3">
            <h5 for="roleName" class="form-label">Select Permission</h5>
            <div class="checkbox" style="display: inline-block; margin-right:10px">
              @error('permissionId')
              <span class="text-danger">{{ $message }}</span><br>
              @enderror
              <label class="unselectable font-weight-bold"><input class="checkAll" type="checkbox">
                Select All</label><br>
              @foreach ($allPermissions as $permissions )
              <label for="permission{{ $permissions->id }}" class="unselectable"><input class="checkMe mx-1"
                  id="permission{{ $permissions->id }}" type="checkbox" name="permissionId[]"
                  value=" {{ $permissions->id }}">
                {{ $permissions->name }}</label>
              @endforeach
            </div>
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary">Add Assign Role</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
  $('.checkAll').click(function(){
      var checked = $(this).prop('checked');
      $('.checkMe').prop('checked', checked);
   });
</script>
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