@extends('frontend.master')

@section('content')
<div class="container mt-4">
  <div class="col-lg-8 m-auto">
    <div class="card">
      <div class="card-header">
        <h3>Set Your New Password</h3>
      </div>
      <div class="card-body">

        <div class="col-xl-12col-lg12 col-md-12 col-sm-12 mfliud">

          @if (session('wrongEmail'))
          <strong class="alert alert-danger">{{ session('wrongEmail') }}</strong>
          @endif
          @if (session('requestResetEmail'))
          <strong class="alert alert-success">{{ session('requestResetEmail') }}</strong>
          @endif
          <form class="border p-3 rounded" action="{{ route('customer.pass.reset.confirm.store',$token) }}"
            method="POST">
            @csrf
            <div class="form-group">
              <label>New Password *</label>
              <br>
              @error('password')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <input type="password" class="form-control" placeholder="New Password" name="password">
            </div>
            <div class="form-group">
              <label>Cofirm Password *</label>
              <br>
              @error('password_confirmation')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation">
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
@if (session('customerPassResetSucc'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('customerPassResetSucc') }}',
      showConfirmButton: true,
      timer: 2000,
    })
</script>
@endif
@endsection