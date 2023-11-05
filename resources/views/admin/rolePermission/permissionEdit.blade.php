@extends('layouts.dashboard')
@section('content')
<div class="col-lg-8 m-auto">
  <div class="card">
    <div class="card-header">
      <h3>Edit Permission</h3>
    </div>
    <div class="card-body">
      <form action="{{ route('permission.update',$permission->id) }}" method="post">
        @csrf
        <div class="mb-3">
          <label for="permission">Permission Name</label>
          <input type="text" id="permission" class="form-control" name="permissionName" value="{{ $permission->name }}">
        </div>
        <div class="mb-3">
          <button type="submit" class="btn btn-primary">Update Permission</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection