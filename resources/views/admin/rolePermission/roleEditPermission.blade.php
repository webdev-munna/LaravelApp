@extends('layouts.dashboard')
@section('content')
<div class="col-lg-8 m-auto">
  <div class="card">
    <div class="card-header">
      <h3>Edit & Assign Role</h3>
    </div>
    <div class="card-body">
      <form action="{{ route('role.permission.update',$roles->id) }}" method="post">
        @csrf
        <div class="mb-3">
          <label for="roleName" class="form-label">Role Name</label><br>
          <input type="text" id="roleName" class="form-control" name="roleName" value="{{ $roles->name }}">
        </div>
        <div class="mb-3">
          <h5 for="roleName" class="form-label">Permissions</h5>
          <div class="checkbox" style="display: inline-block; margin-right:10px">
            @error('permissionId')
            <span class="text-danger">{{ $message }}</span><br>
            @enderror
            <label class="unselectable font-weight-bold"><input class="checkAll" type="checkbox">
              Select All</label><br>
            @foreach ($allPermissions as $permissions )
            <label for="permission{{ $permissions->id }}" class="unselectable"><input class="checkMe mx-1" {{
                ($roles->hasPermissionTo($permissions->name)?'checked':'') }}
              id="permission{{ $permissions->id }}" type="checkbox" name="permissionId[]"
              value="{{ $permissions->id }}">
              {{ $permissions->name }}</label>
            @endforeach
          </div>
        </div>
        <div class="mb-3">
          <button type="submit" class="btn btn-primary">Update Assign Role</button>
        </div>
      </form>
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
@endsection