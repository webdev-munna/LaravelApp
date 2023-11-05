@extends('frontend.customerMaster')

@section('customerContent')
<div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
  <div class="gray py-3">
    <div class="container">
      <div class="row">
        <div class="colxl-12 col-lg-12 col-md-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- row -->
  <div class="row align-items-center">
    @forelse ($wishlists as $wishlist )
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
      <div class="product_grid card b-0">
        @if ($wishlist->relToProduct->discount)
        <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">
          <span>Sale</span>
        </div>
        @endif
        <a href="{{ route('delWishlist',$wishlist->id) }}">
          <button class="btn btn_love position-absolute ab-right theme-cl"><i class="fas fa-times"></i></button>
        </a>
        <div class="card-body p-0">
          <div class="shop_thumb position-relative">
            <a class="card-img-top d-block overflow-hidden"
              href="{{ route('productDetails',$wishlist->relToProduct->slug) }}"><img class="card-img-top"
                src="{{ asset('uploads/product/preview/'.$wishlist->relToProduct->previewImage) }}" alt="..."></a>
          </div>
        </div>
        <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
          <div class="text-left">
            <div class="text-center">
              <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a
                  href="{{ route('productDetails',$wishlist->relToProduct->slug) }}">{{
                  $wishlist->relToProduct->productName }}</a></h5>
              <div class="elis_rty">@if ($wishlist->relToProduct->discount)
                &#2547; <span class="ft-medium text-muted line-through fs-md mr-2">{{
                  number_format(round($wishlist->relToProduct->price))
                  }}</span><span class="ft-bold text-dark fs-sm">&#2547; {{
                  number_format(round($wishlist->relToProduct->afterDiscount)) }}</span>
                @else
                <span class="ft-bold text-dark fs-sm">&#2547; {{
                  number_format(round($wishlist->relToProduct->afterDiscount))
                  }}</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @empty
    <div class="m-auto">
      <h4 class="alert alert-info">You did not add any product to the wishlsit.</h4>
      <a href="{{ route('filter.product') }}">
        <button class="btn btn-primary">Shop Now</button>
      </a>
    </div>
    @endforelse
  </div>
  <!-- row -->
</div>
@endsection