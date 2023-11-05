@extends('frontend.master')

@section('content')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
  <div class="container">
    <div class="row">
      <div class="colxl-12 col-lg-12 col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active" aria-current="page">Login</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Login Detail ======================== -->
<section class="middle">
  <div class="container">
    <div class="row align-items-start justify-content-between">

      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <div class="mb-3">
          <h3>Login</h3>
        </div>
        @if (session('errorLogin'))
        <h4 class="alert alert-danger">{{ session('errorLogin') }}</h4>
        @endif
        <form class="border p-3 rounded" action="{{ route('customerLogin') }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Email *</label>
            <input type="text" class="form-control" placeholder="Email*" name="email" value="{{ old('email') }}">
          </div>

          <div class="form-group">
            <label>Password *</label>
            <input type="password" class="form-control" placeholder="Password*" name="password">
          </div>

          <div class="form-group">
            <div class="d-flex align-items-center justify-content-between">
              <div class="eltio_k2">
                <a href="{{ route('pass.reset.email') }}">Lost Your Password?</a>
              </div>
            </div>
          </div>
          <div class="form-group mt-4">
            <div class="mb-1">
              <a href="{{ route('login.google') }}" class="btn btn-info btn-block">Login with Google</a>
            </div>
            <div class="">
              <a href="{{ route('login.github') }}" class="btn btn-secondary btn-block">Login with Github</a>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login</button>
          </div>
        </form>
      </div>

      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mfliud">
        <div class="mb-3">
          <h3>Register</h3>
        </div>
        @if (session('customerReg'))
        <strong class="alert alert-success">{{ session('customerReg') }}</strong>
        @endif
        <form class="border p-3 rounded" action="{{ route('customerRegister') }}" method="POST">
          @csrf
          <div class="row">
            <div class="form-group col-md-12">
              <label>Full Name *</label><br>
              @error('name')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <input type="text" class="form-control" placeholder="Full Name" name="name" value="{{ old('name') }}">
            </div>
          </div>

          <div class="form-group">
            <label>Email *</label>
            <br>
            @error('email')
            <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <input type="text" class="form-control" placeholder="Email*" name="email" value="{{ old('email') }}">
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label>Password *</label>
              <br>
              @error('password')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <input type="password" class="form-control" placeholder="Password*" name="password">
            </div>

            <div class="form-group col-md-6">
              <label>Confirm Password *</label><br>
              @error('password_confirmation')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <input type="password" class="form-control" placeholder="Confirm Password*" name="password_confirmation">
            </div>
          </div>
          <div class="form-group mt-4">
            <div class="">
              <a href="{{ route('login.google') }}" class="btn btn-info btn-block mr-2">Login with Google</a>
            </div>
            <div class="mt-1">
              <a href="" class="btn btn-primary btn-block mr-2">Login with Facebook</a>
            </div>
            <div class="mt-1">
              <a href="{{ route('login.github') }}" class="btn btn-secondary btn-block">Login with Github</a>
            </div>
          </div>
          <div class="form-group mt-4">
            <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Create An
              Account</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</section>
<!-- ======================= Login End ======================== -->
@endsection
@section('script')
@if (session('customerRegister'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('categoryUpdate') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@endsection