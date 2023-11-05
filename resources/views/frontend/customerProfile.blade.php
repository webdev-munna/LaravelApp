@extends('frontend.customerMaster')

@section('customerContent')
<div class="col-12 col-md-12 col-lg-8 col-xl-8">
  <div class="gray py-3 mb-4">
    <div class="container">
      <div class="row">
        <div class="colxl-12 col-lg-12 col-md-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- row -->
  <div class="row align-items-center">
    <form class="row m-0" action="{{ route('updateCustomerProfile') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <div class="form-group">
          <label class="small text-dark ft-medium">First Name *</label>
          <input type="text" class="form-control" value="{{ auth::guard('customerLogin')->user()->name }}"
            name="name" />
        </div>
      </div>

      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <div class="form-group">
          @if (session('emailExists'))
          <strong class="text-danger">{{ session('emailExists') }}</strong><br>
          @endif
          <label class="small text-dark ft-medium">Email ID *</label>
          <input type="text" class="form-control" value="{{ auth::guard('customerLogin')->user()->email }}"
            name="email" />
        </div>
      </div>

      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <div class="form-group">
          <label class="small text-dark ft-medium">Current Password *</label><br>
          @if (session('errorOldPass'))
          <strong class="text-danger">{{ session('errorOldPass') }}</strong>
          @endif
          <input type="password" class="form-control" placeholder="Current Password" name="oldPassword" />
        </div>
      </div>

      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <div class="form-group">
          <label class="small text-dark ft-medium">New Password *</label>
          <input type="password" class="form-control" placeholder="New Password" name="newPassword" />
        </div>
      </div>

      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
        <div class="form-group">
          <label class="small text-dark ft-medium">Mobile</label>
          <input type="number" class="form-control" value="{{ auth::guard('customerLogin')->user()->mobile }}"
            placeholder="Mobile" name="mobile" />
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
        <div class="form-group">
          <label class="small text-dark ft-medium">Country</label>
          <input type="text" class="form-control" placeholder="Country"
            value="{{ auth::guard('customerLogin')->user()->country }}" name="country" />
        </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
        <div class="form-group">
          <label class="small text-dark ft-medium">Address</label>
          <input type="text" class="form-control" value="{{ auth::guard('customerLogin')->user()->address }}"
            placeholder="Address" name="address" />
        </div>
      </div>

      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
          <label class="small text-dark ft-medium">Profile Image</label><br>
          @error('profileImage')
          <strong class="text-danger">{{ $message }}</strong>
          @enderror
          <input type="file" class="form-control" name="profileImage" />
        </div>
      </div>



      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
          <button type="submit" class="btn btn-dark">Save Changes</button>
        </div>
      </div>

    </form>
  </div>
  <!-- row -->
</div>
@endsection

@section('script')
@if (session('updPassSucc'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('updPassSucc') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@endsection