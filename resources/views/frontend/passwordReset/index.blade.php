@extends('frontend.master')

@section('content')
<div class="container mt-4">
  <div class="col-lg-8 m-auto">
    <div class="card">
      <div class="card-header">
        <h3>Password Reset</h3>
      </div>
      <div class="card-body">

        <div class="col-xl-12col-lg12 col-md-12 col-sm-12 mfliud">

          @if (session('wrongEmail'))
          <strong class="alert alert-danger">{{ session('wrongEmail') }}</strong>
          @endif
          {{-- @if (session('requestResetEmail'))
          <strong class="alert alert-success">{{ session('requestResetEmail') }}</strong>
          @endif --}}
          <form class="border p-3 rounded" action="{{ route('customer.pass.reset.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Email *</label>
              <br>
              @error('email')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <input type="text" class="form-control" placeholder="Input Your Account Email*" name="email"
                value="{{ old('email') }}">
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Send
                Request</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
@if (session('requestResetEmail'))
<script>
  const Toast = Swal.mixin({
  toast: true,
  position: 'top-right',
  iconColor: 'black',
  customClass: {
    popup: 'colored-toast'
  },
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true
})
Toast.fire({
  icon: 'success',
  title: '{{ session('requestResetEmail') }}'
})
</script>
@endif
@endsection