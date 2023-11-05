@extends('frontend.master')

@section('content')
<div class="gray py-3">
  <div class="container">
    <div class="row">
      <div class="colxl-12 col-lg-12 col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('viewCart') }}">Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Product Detail ======================== -->
<section class="middle">
  <div class="container">

    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="text-center d-block mb-5">
          <h2>Checkout</h2>
        </div>
      </div>
    </div>

    <div class="row justify-content-between">
      <div class="col-12 col-lg-7 col-md-12">
        <form action="{{ route('orderStore') }}" method="POST">
          @csrf
          <h5 class="mb-4 ft-medium">Billing Details</h5>
          <div class="row mb-2">

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              @error('name')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <div class="form-group">
                <label class="text-dark">Full Name *</label>
                <input type="text" class="form-control" placeholder="First Name" name="name"
                  value="{{ old('name') }}" />
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              @error('email')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <div class="form-group">
                <label class="text-dark">Email *</label>
                <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" />
              </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="form-group">
                <label class="text-dark">Company</label>
                <input type="text" class="form-control" placeholder="Company Name (optional)" name="company"
                  value="{{ old('company') }}" />
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              @error('mobile')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <div class="form-group">
                <label class="text-dark">Mobile Number *</label>
                <input type="number" class="form-control" placeholder="Mobile Number" name="mobile"
                  value="{{ old('mobile') }}" />
              </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              @error('address')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <div class="form-group">
                <label class="text-dark">Address *</label>
                <input type="text" class="form-control" placeholder="Address" name="address"
                  value="{{ old('address') }}" />
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
              @error('countryId')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <div class="form-group">
                <label class="text-dark">Country *</label>
                <select class="custom-select country" name="countryId">
                  <option value="" disabled selected>-- Select Country --</option>
                  @foreach ($countries as $country )
                  <option value="{{ $country->id }}">{{ $country->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              @error('cityId')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <div class="form-group">
                <label class="text-dark">City / Town *</label>
                <select class="custom-select city" name="cityId">
                  <option value="" disabled selected>-- Select City --</option>
                </select>
              </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              @error('postcode')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <div class="form-group">
                <label class="text-dark">ZIP / Postcode *</label>
                <input type="number" class="form-control" placeholder="Zip / Postcode" name="postcode"
                  value="{{ old('postcode') }}" />
              </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group">
                <label class="text-dark">Additional Information</label>
                <textarea class="form-control ht-50" name="notes">{{ old('notes') }}</textarea>
              </div>
            </div>
          </div>

      </div>

      <!-- Sidebar -->
      @php
      $subTotal= 0;
      $total = 0;
      $discount = 0;
      $ty = session('type');
      $couponDiscountt = session('percentDiscount');
      $coupons = session('coupon');
      $minimum = session('mini');
      $maximum = session('maxi');
      @endphp
      <div class="col-12 col-lg-4 col-md-12">
        <div class="d-block mb-3">
          <h5 class="mb-4">Order Items ({{ count($carts) }})</h5>
          <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
            @foreach ($carts as $cart)
            <li class="list-group-item">
              <div class="row align-items-center">
                <div class="col-3">
                  <!-- Image -->
                  <a href="{{ route('productDetails',$cart->relToProduct->slug) }}"><img
                      src="{{ asset('uploads/product/preview/'.$cart->relToProduct->previewImage) }}"
                      alt="product image" class="img-fluid"></a>
                </div>
                <div class="col d-flex align-items-center">
                  <div class="cart_single_caption pl-2">
                    <h4 class="product_title fs-md ft-medium mb-1 lh-1">{{ $cart->relToProduct->productName }}</h4>
                    <p class="mb-1 lh-1"><span class="text-dark">Size: {{ $cart->relToSize->productSize }}</span></p>
                    <p class="mb-3 lh-1"><span class="text-dark">Color: {{ $cart->relToColor->colorName }}</span></p>
                    @if ($cart->relToProduct->discount)
                    <h4 class="fs-md ft-medium mb-3 lh-1">TK {{ $cart->relToProduct->afterDiscount }} X{{
                      $cart->quantity }}</h4>
                    @else
                    <h4 class="fs-md ft-medium mb-3 lh-1">TK {{ $cart->relToProduct->price }} X{{
                      $cart->quantity }}</h4>
                    @endif
                  </div>
                </div>
              </div>
            </li>
            @php
            $subTotal += $cart->relToProduct->afterDiscount*$cart->quantity;
            @endphp
            @endforeach
          </ul>
        </div>

        <div class="mb-4">
          <div class="form-group">
            <h6>Delivery Location</h6>
            @error('charge')
            <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <ul class="no-ul-list">
              <li>
                <input id="c1" class="radio-custom location" name="charge" type="radio" value="50">
                <label for="c1" class="radio-custom-label">Inside City</label>
              </li>
              <li>
                <input id="c2" class="radio-custom location" name="charge" type="radio" value="80">
                <label for="c2" class="radio-custom-label">Outside City</label>
              </li>
            </ul>
          </div>
        </div>
        <div class="mb-4">
          <div class="form-group">
            <h6>Select Payment Method</h6>
            @error('paymentMethod')
            <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <ul class="no-ul-list">
              <li>
                <input id="c3" class="radio-custom" name="paymentMethod" type="radio" value="1">
                <label for="c3" class="radio-custom-label">Cash on Delivery</label>
              </li>
              <li>
                <input id="c4" class="radio-custom" name="paymentMethod" type="radio" value="2">
                <label for="c4" class="radio-custom-label">Pay With SSLCommerz</label>
              </li>
              <li>
                <input id="c5" class="radio-custom" name="paymentMethod" type="radio" value="3">
                <label for="c5" class="radio-custom-label">Pay With Stripe</label>
              </li>
            </ul>
          </div>
        </div>
        @php
        if($minimum > $subTotal || $maximum < $subTotal ){ $discount=0; $couponDiscountt=0; $total=$subTotal; }else{
          if($ty==1){ $total=$subTotal - $subTotal*$couponDiscountt/100; $discount=$subTotal*$couponDiscountt/100;
          }else{ $total=$subTotal - $couponDiscountt; $discount=$couponDiscountt; } } @endphp <input type="hidden"
          id="total" name="total" value="{{ $total }}">
          <input type="hidden" id="subTotal" name="subTotal" value="{{ $subTotal }}">
          <input type="hidden" id="discount" name="discount" value="{{ $discount }}">
          <div class="card mb-4 gray">
            <div class="card-body">
              <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                  <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">{{
                    number_format(round($subTotal)) }} TK</span>
                </li>
                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                  <span>Discount</span> <span class="ml-auto text-dark ft-medium">{{
                    number_format(round($discount)) }} TK {{$ty==1?"(".$couponDiscountt."%)":''
                    }}</span>
                </li>
                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                  <span>Charge</span> <span class="ml-auto text-dark ft-medium" id="charge">0 TK</span>
                </li>
                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                  <span>Total</span> <span class="ml-auto text-dark ft-medium" id="grandTotal">{{
                    number_format(round($total)) }} TK</span>
                </li>
              </ul>
            </div>
          </div>


          <button type="submit" class="btn btn-block btn-dark mb-3">Place Your Order</button>
      </div>
      </form>
    </div>

  </div>
</section>
<!-- ======================= Product Detail End ======================== -->
@endsection
@section('script')
<script>
  $('.location').click(function(){
       let charge = $(this).val() +' TK';
       let total = $('#total').val();
       let grandTotal = parseInt(charge) + parseInt(total);
       let munna = grandTotal.toLocaleString('en-US')  +' TK';
       $('#charge').html(charge);
       $('#grandTotal').html(munna);
       
     })
</script>
<script>
  $(".country").select2({
  maximumSelectionLength: 3
});
</script>
<script>
  $(".city").select2({
  maximumSelectionLength: 3
});
</script>
<script>
  $('.country').change(function(){
     let countryId = $(this).val();
     $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   $.ajax({
     url: '/getCity',
     type:'POST',
     data:{'countryId':countryId},
     success:function(data){
         $('.city').html(data);
     }
   })

  })
</script>
@if (session('orderSuccess'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('orderSuccess') }}',
      showConfirmButton: true,
      timer: 2500,
    })
</script>
@endif
@endsection