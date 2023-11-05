@extends('frontend.master')

@section('content')
<div class="clearfix"></div>
<!-- ============================================================== -->
<!-- Top header  -->
<!-- ============================================================== -->

<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
  <div class="container">
    <div class="row">
      <div class="colxl-12 col-lg-12 col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Cart</li>
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
          <h2>Shopping Cart</h2>
        </div>
      </div>
    </div>

    <div class="row justify-content-between">
      <div class="col-12 col-lg-7 col-md-12">
        <form action="{{ route('updateCart') }}" method="POST">
          @csrf
          <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
            @php
            $subTotal = 0;
            @endphp
            @foreach ($carts as $cartss )
            <li class="list-group-item">
              <div class="row align-items-center">
                <div class="col-3">
                  <!-- Image -->
                  <a href="{{ route('productDetails',$cartss->relToProduct->slug) }}"><img
                      src="{{ asset('uploads/product/preview/'.$cartss->relToProduct->previewImage) }}"
                      alt="product image" class="img-fluid"></a>
                </div>
                <div class="col d-flex align-items-center justify-content-between">
                  <div class="cart_single_caption pl-2">
                    <h4 class="product_title fs-md ft-medium mb-1 lh-1">{{ $cartss->relToProduct->productName }}</h4>
                    <p class="mb-1 lh-1"><span class="text-dark">Size: {{ $cartss->relToSize->productSize }}</span></p>
                    <p class="mb-3 lh-1"><span class="text-dark">Color: {{ $cartss->relToColor->colorName }}</span></p>
                    @if ($cartss->relToProduct->discount)
                    <h4 class="fs-md ft-medium mb-3 lh-1">TK {{ $cartss->relToProduct->afterDiscount }}</h4>
                    @else
                    <h4 class="fs-md ft-medium mb-3 lh-1">TK {{ $cartss->relToProduct->price }}</h4>
                    @endif
                    @php
                    $stock =
                    App\Models\Inventory::where('productId',$cartss->relToProduct->id)->where('colorId',$cartss->relToColor->id)->where('sizeId',$cartss->relToSize->id)->first()->quantity;
                    @endphp
                    <select class="mb-2 custom-select w-auto" name="quantity[{{ $cartss->id }}]">
                      @for ($i=1; $i<=$stock; $i++) <option {{$i==$cartss->quantity?'selected':''}} value="{{ $i }}">{{
                        $i }}
                        </option>
                        @endfor
                    </select>
                  </div>
                  <div class="fls_last"><a href="{{ route('deleteCart',$cartss->id) }}" class="close_slide gray"><i
                        class="ti-close"></i></a></div>
                </div>
              </div>
            </li>
            @if ($cartss->relToProduct->discount)
            @php
            $subTotal += $cartss->relToProduct->afterDiscount * $cartss->quantity;
            @endphp
            @else
            @php
            $subTotal += $cartss->relToProduct->price * $cartss->quantity;
            @endphp
            @endif
            @endforeach
          </ul>
          <div class="row align-items-end justify-content-between mb-10 mb-md-0">
            <div class="col-lg-6">
              <button type="submit" class="btn stretched-link borders">Update Cart</button>
            </div>
        </form>
        <div class="col-lg-6">
          <!-- Coupon -->
          <form action="{{ route('viewCart') }}" method="GET" class="mb-7 mb-md-0">
            <label class="fs-sm ft-medium text-dark">Coupon code:</label>
            <div class="row form-row">
              <div class="col">
                <input class="form-control" name="coupon" type="text" placeholder="Enter coupon code*">
              </div>
              <div class="col-auto">
                <button class="btn btn-dark" type="submit">Apply</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    @php
    $total = $subTotal;
    $percent = $couponDiscounts
    @endphp
    @php
    session([
    'type'=>$couponType,
    'percentDiscount'=> $couponDiscounts,
    'coupon' =>$coupons,
    'mini' => $minimum,
    'maxi' => $maximum,
    ]);
    @endphp
    <div class="col-12 col-md-12 col-lg-4">
      <div class="card mb-4 gray mfliud">
        @if ($coupons =='') {{-- first if --}}
        <input type="hidden">
        @else
        @if (App\Models\Coupon::where('couponName', $coupons)->exists()) {{-- 2nd if --}}
        @if ($subTotal > $couponDetail->first()->maximum || $subTotal < $couponDetail->first()->minimum) {{-- 3rd if
          --}}
          @php
          $couponDiscounts = 0;
          $percent = 0;
          @endphp
          <h4 class="text-danger text-center"><strong> For this Coupon range min TK {{ $couponDetail->first()->minimum
              }} and max TK {{$couponDetail->first()->maximum }}.</strong></h4>
          @else
          @if ($couponType == 1) {{-- 4th if --}}
          @php
          $total = $subTotal - $subTotal*$couponDiscounts/100;
          $couponDiscounts = $subTotal*$couponDiscounts/100;
          @endphp
          @else
          @php
          $total = $subTotal - $couponDiscounts;
          @endphp

          @endif {{-- 4th if --}}
          @endif {{-- 3rd if --}}
          @endif {{-- 2nd if --}}
          @endif {{-- first if --}}
          <div class="card-body">
            <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
              <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">TK {{ number_format(round($subTotal),2)
                  }} </span>
              </li>
              <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                <span>Discount</span> <span class="ml-auto text-dark ft-medium"> Tk {{
                  number_format(round($couponDiscounts))
                  }} {{ $couponType==1?'('.$percent.'%)':'' }}
                </span>
              </li>
              <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                <span>Total</span> <span class="ml-auto text-dark ft-medium">TK {{ number_format(round($total),2)
                  }}</span>
              </li>
              <li class="list-group-item fs-sm text-center">
                Shipping cost calculated at Checkout *
              </li>
            </ul>
          </div>
      </div>
      <a class="btn btn-block btn-dark mb-3" href="{{ route('checkOut') }}">Proceed to Checkout</a>

      <a class="btn-link text-dark ft-medium" href="{{ route('frontHome') }}">
        <i class="ti-back-left mr-2"></i> Continue Shopping
      </a>
    </div>

  </div>

  </div>
</section>
@endsection
@section('script')
@if (session('updateCart'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('updateCart') }}',
      showConfirmButton: true,
      timer: 1500,
    })
</script>
@endif
@if ($msgs)
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'warning',
      title: '{{ $msgs }}',
      showConfirmButton: true,
      timer: 8500,
    })
</script>
@endif
@endsection