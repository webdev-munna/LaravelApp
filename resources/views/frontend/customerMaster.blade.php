@extends('frontend.master')

@section('content')
<section class="middle">
  <div class="container">
    <div class="row align-items-start justify-content-between">

      <div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
        <div class="d-block border rounded mfliud-bot">
          <div class="dashboard_author px-2 py-5">
            <div class="dash_auth_thumb circle p-1 border d-inline-flex mx-auto mb-2">
              @if (Auth::guard('customerLogin')->user()->profileImage == null)
              <img width="50" src="{{ Avatar::create(Auth::guard('customerLogin')->user()->name)->toBase64() }}" />
              @else
              <img
                src="{{ asset('uploads/customer/profileImage/'.Auth::guard('customerLogin')->user()->profileImage) }}"
                class="img-fluid circle" width="100" alt="" />
              @endif
            </div>
            <div class="dash_caption">
              <h4 class="fs-md ft-medium mb-0 lh-1">{{ Auth::guard('customerLogin')->user()->name }}</h4>
              <span class="text-muted smalls">{{ Auth::guard('customerLogin')->user()->country }}</span>
            </div>
          </div>

          <div class="dashboard_author">
            <h4 class="px-3 py-2 mb-0 lh-2 gray fs-sm ft-medium text-muted text-uppercase text-left">Dashboard
              Navigation</h4>
            <ul class="dahs_navbar">
              <li><a href="{{ route('myOrder') }}"><i class="lni lni-shopping-basket mr-2"></i>My Order</a></li>
              <li><a href="{{ route('customerWishlist') }}"><i class="lni lni-heart mr-2"></i>Wishlist</a></li>
              <li><a href="{{ route('customerProfile') }}" class=""><i class="lni lni-user mr-2"></i>Profile
                  Info</a></li>
              <li><a href="{{ route('customerLogout') }}"><i class="lni lni-power-switch mr-2"></i>Log Out</a></li>
            </ul>
          </div>

        </div>
      </div>

      @yield('customerContent')

    </div>
  </div>
</section>
@endsection