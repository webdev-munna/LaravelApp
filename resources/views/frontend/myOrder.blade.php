@extends('frontend.customerMaster')

@section('customerContent')
<div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
  <div class="gray py-3 mb-4">
    <div class="container">
      <div class="row">
        <div class="colxl-12 col-lg-12 col-md-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">My Order</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- Single Order List -->
  @forelse ($customerOrder
  as $orderInfo )
  <div class="ord_list_wrap border mb-4">
    <div class="ord_list_head gray d-flex align-items-center justify-content-between px-3 py-3">
      <div class="olh_flex">
        <p class="m-0 p-0"><span class="text-muted">Order Number</span></p>
        <h6 class="mb-0 ft-medium">{{ $orderInfo->orderId }}</h6>
      </div>
      <div class="d-flex">
        <div class="ml-auto">
          <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
          <div class="delv_status">
            @if ($orderInfo->orderStatus==1)
            <span class="badge badge-primary">Pending</span>
            @elseif ($orderInfo->orderStatus==2)
            <span class="badge badge-secondary">Confirmed</span>
            @elseif ($orderInfo->orderStatus==3)
            <span class="badge badge-primary">Processing</span>
            @elseif ($orderInfo->orderStatus==4)
            <span class="badge badge-info">Ready To Delivery</span>
            @elseif ($orderInfo->orderStatus==5)
            <span class="badge badge-success">Delivered</span>
            @else
            <span class="badge badge-danger">Cancelled</span>
            @endif
          </div>
        </div>
        <div class="">
          <a title="Download Invoice" href="{{ route('order.invoice.download',substr($orderInfo->orderId,1)) }}"
            rel="noopener noreferrer"><i
              style="font-size:25px; text-align:center; margin-top:18px; margin-left:13px; color:blue"
              class="fa fa-download" aria-hidden="true"></i></a>
        </div>
      </div>
    </div>
    <div class="ord_list_body text-left">
      <!-- First Product -->
      @foreach (App\Models\OrderedProduct::where('orderId',$orderInfo->orderId)->get() as $allProducts
      )
      <div class="row m-0 py-4 br-bottom">
        <div class="col-xl-5 col-lg-5 col-md-5 col-12">
          <div class="cart_single d-flex align-items-start mfliud-bot">
            <div class="cart_selected_single_thumb">
              <a href="#"><img src="{{ asset('uploads/product/preview/'.$allProducts->relToProducts->previewImage) }}"
                  width="75" height="80" class=" " alt=""></a>
            </div>
            <div class="cart_single_caption pl-3">
              <p class="mb-0"><span class="text-muted small">{{
                  $allProducts->relToProducts->relToCateogry->category_name }}</span></p>
              <h4 class="product_title fs-sm ft-medium mb-1 lh-1">{{ $allProducts->relToProducts->productName }}</h4>
              <p class="mb-2"><span class="text-dark medium">Size: {{ $allProducts->relToSize->productSize }}</span>,
                <span class="text-dark medium">Color:
                  {{ $allProducts->relToColor->colorName }}</span><br>
                <span class="text-dark medium">Quantity:
                  {{ $allProducts->quantity }}</span>
              </p>
              <h4 class="fs-sm ft-bold mb-0 lh-1">TK {{ number_format(round($allProducts->price *
                $allProducts->quantity)) }}</h4>
            </div>
          </div>
        </div>

      </div>
      @endforeach
    </div>
    <div class="ord_list_footer d-flex align-items-center justify-content-between br-top px-3">
      <div class="col-xl-12 col-lg-12 col-md-12 pl-0 py-2 olf_flex d-flex align-items-center justify-content-between">
        <div class="olf_flex_inner">
          <p class="m-0 p-0"><span class="text-muted medium text-left">Order Date: {{
              $orderInfo->created_at->format('d/m/y') }}</span>
          </p>
        </div>
        <div class="olf_inner_right">
          <h5 class="mb-0 fs-sm ft-bold">Total: &#2547;{{ number_format(round($orderInfo->total)) }}</h5>
        </div>
      </div>
    </div>
  </div>
  @empty
  <div>
    <h4 class="alert alert-info">You have no order right now.</h4>
    <a href="{{ route('filter.product') }}">
      <button class="btn btn-primary">Shop Now</button>
    </a>
  </div>
  @endforelse
  <!-- End Order List -->
  @endsection