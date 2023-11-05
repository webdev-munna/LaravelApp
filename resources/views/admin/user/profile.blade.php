@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
  </ol>
</div>
<div class="row d-flex">
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h4>Change Profile</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('updateProfile') }}" method="POST">
          @csrf
          <div class="mb-3">
            {{-- @if (session('proUpd'))
            <strong class="text-success">{{ session('proUpd') }}</strong><br>
            @endif --}}
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ auth::user()->name }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ auth::user()->email }}">
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update Profile</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h4>Change Password</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('updatePass') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label" for="oldPass">Old Password</label><br>
            @if (session('wrong_pass'))
            <strong class="text-danger">{{ session('wrong_pass') }}</strong>
            @endif
            @error('old_password')
            <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <input type="password" id="oldPass" class="form-control" name="old_password"
              placeholder="Enter old password">
          </div>
          <div class="mb-3" style="position:relative">
            <label class="form-label" for="newPass">New Password</label>
            <br>
            @error('password')
            <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <input type="password" id="newPass" class="form-control" name="password" placeholder="Enter new password">
            <i class="fa fa-eye" id="newPassword" style="position:absolute;top:50px;left:250px;font-size:21px"></i>
          </div>
          <div class="mb-3">
            <label class="form-label" for="conPass">Confirm Password</label>
            <br>
            @error('password_confirmation')
            <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <input type="password" id="conPass" class="form-control" name="password_confirmation"
              placeholder="Enter new password again">
          </div>
          <div class="mt-3">
            <button type="submit" class="btn btn-primary">Update Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h4>Change Profile Image</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('updateImg') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label">Image</label><br>
            @error('image')
            <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <input type="file" class="form-control" name="image">
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update Profile Image</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
@if (session('proUpd'))
<script>
  Swal.fire(
      'Success',
      '{{ session('proUpd') }}',
      'success'
    )
</script>
@endif
@if (session('passUpd'))
<script>
  Swal.fire(
      'Success',
      '{{ session('passUpd') }}',
      'success'
    )
</script>
@endif
<script>
  $('#newPassword').click(function(){
    var pass = document.getElementById('newPass');
    if(pass.type=='password'){
      pass.type = 'text';
    }else{
      pass.type = 'password';
    }
  })
</script>
@endsection