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
            <li class="breadcrumb-item"><a href="#">Product</a></li>
            <li class="breadcrumb-item active" aria-current="page">Details</li>
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
    <div class="row justify-content-between">
      <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
        <div class="quick_view_slide">
          @foreach ($thumbnail as $thumb )
          <div class="single_view_slide"><a href="" data-lightbox="roadtrip" class="d-block mb-4"><img
                src="{{ asset('uploads/product/thumbnail/'.$thumb->productThumbnail) }}" class="img-fluid rounded"
                alt="" /></a></div>
          @endforeach
        </div>
      </div>

      <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
        <div class="prd_details pl-3">
          <div class="prt_01 mb-1"><span class="text-light bg-info rounded px-2 py-1">{{
              $productInfo->first()->relToCateogry->category_name }}</span></div>
          <div class="prt_02 mb-3">
            <h2 class="ft-bold mb-1">{{ $productInfo->first()->productName }}</h2>
            <div class="text-left">
              <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                @for ($i =1; $i<= $avarageReview; $i++) <i class="fas fa-star filled"></i>
                  @endfor
                  @for ($j =1; $j<= 5 - $avarageReview; $j++) <i class="fas fa-star"></i>
                    @endfor
                    <span class="small">({{ $totalReview }} Reviews)</span>
              </div>
              <div class="elis_rty">
                @if ($productInfo->first()->discount)
                <span class="ft-medium text-muted line-through fs-md mr-2">TK {{
                  $productInfo->first()->price
                  }}</span><span class="ft-bold theme-cl fs-lg mr-2">TK {{ $productInfo->first()->afterDiscount
                  }}</span>
                @else
                <span class="ft-bold theme-cl fs-lg mr-2">TK {{ $productInfo->first()->price }}</span>
                @endif
              </div>
            </div>
          </div>

          <div class="prt_03 mb-4">
            <p>Brand Name: {{ $productInfo->first()->brand==null?'No Brand':$productInfo->first()->brand }}</p>
          </div>
          <div class="prt_03 mb-4">
            <p>{{ $productInfo->first()->shortDescription }}</p>
          </div>

          <form action="{{ route('cartStore') }}" method="POST">
            @csrf
            <input type="hidden" value="{{ $productInfo->first()->id }}" name="productId">
            <div class="prt_04 mb-2">
              <p class="d-flex align-items-center mb-0 text-dark ft-medium">Select Color:</p>
              @error('colorId')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <div class="text-left" id="ajaxColorData">
                @foreach ($availableColors as $colors )
                @if ($colors->colorId !=1)
                <div class="form-check form-option form-check-inline mb-1">
                  <input class="form-check-input getSize" type="radio" name="colorId" id="color{{ $colors->colorId }}"
                    value="{{ $colors->colorId }}">
                  <label class="form-option-label rounded-circle" for="color{{ $colors->colorId }}"><span
                      class="form-option-color rounded-circle"
                      style="background:{{ $colors->relToColor->colorName }};"></span></label>
                </div>
                {{-- @else
                <div class="form-check form-option size-option  form-check-inline mb-2">
                  <input class="form-check-input" value="{{ $colors->colorId}}" type="radio" name="colorId" id="50"
                    checked>
                  <label class="form-option-label" for="50">{{ $colors->relToColor->colorName}}</label>
                </div> --}}
                @endif
                @endforeach
              </div>
            </div>
            <div class="prt_04 mb-4">
              <p class="d-flex align-items-center mb-0 text-dark ft-medium">Select Size:</p>
              @error('sizeId')
              <strong class="text-danger">{{ $message }}</strong>
              @enderror
              <div class="text-left pb-0 pt-2" id="ajaxSizeData">
                @foreach ( $availableSizes as $size)
                @if ($size->sizeId != 1)
                <div class="form-check form-option size-option  form-check-inline mb-2">
                  <input class="form-check-input productSize" value="{{ $size->sizeId }}" type="radio" name="sizeId"
                    id="50{{ $size->sizeId }}">
                  <label class="form-option-label" for="50{{ $size->sizeId }}">{{ $size->relToSize->productSize
                    }}</label>
                </div>
                @endif
                @endforeach
              </div>
            </div>

            <div class="prt_05 mb-4">
              <div class="form-row mb-7">
                <div class="col-12 col-lg-auto">
                  <!-- Quantity -->
                  @error('quantity')
                  <strong class="text-danger">{{ $message }}</strong>
                  @enderror
                  <select class="mb-2 custom-select" name="quantity">
                    <option value="" disabled selected>--Select Quantity--</option>
                    <option value="1" selected>1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                  </select>
                </div>
                <div class="col-12 col-lg">
                  <!-- Submit -->
                  <button type="submit" value="1" name="submitBtn" class="btn btn-block custom-height bg-dark mb-2">
                    <i class="lni lni-shopping-basket mr-2"></i>Add to Cart
                  </button>
                </div>
                <div class="col-12 col-lg-auto">
                  <button type="submit" value="2" name="submitBtn"
                    class="btn custom-height btn-default btn-block mb-2 text-dark">
                    <i class="lni lni-heart mr-2"></i>Wishlist
                  </button>
                </div>
          </form>
          {{-- <form action="{{ route('wishList') }}" method="POST">
            @csrf
            <input type="hidden" value="{{ $productInfo->first()->id }}" name="productId">
            <input class="" type="hidden" name="colorId" value="{{ $colors->colorId }}">
            <input value="{{ $size->sizeId }}" type="hidden" name="sizeId">
            <div class="col-12 col-lg-auto">
              <button type="submit" class="btn custom-height btn-default btn-block mb-2 text-dark">
                <i class="lni lni-heart mr-2"></i>Wishlist
              </button>
            </div>
          </form> --}}
        </div>
      </div>

      <div class="prt_06">
        <p class="mb-0 d-flex align-items-center">
          <span class="mr-4">Share:</span>
          <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2"
            href="#!">
            <i class="fab fa-twitter position-absolute"></i>
          </a>
          <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2"
            href="#!">
            <i class="fab fa-facebook-f position-absolute"></i>
          </a>
          <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted" href="#!">
            <i class="fab fa-pinterest-p position-absolute"></i>
          </a>
        </p>
      </div>

    </div>
  </div>
  </div>
  </div>
</section>
<!-- ======================= Product Detail End ======================== -->

<!-- ======================= Product Description ======================= -->
<section class="middle">
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12">
        <ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="myTab"
          role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="description-tab" href="#description" data-toggle="tab" role="tab"
              aria-controls="description" aria-selected="true">Description</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" href="#information" id="information-tab" data-toggle="tab" role="tab"
              aria-controls="information" aria-selected="false">Additional information</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" href="#reviews" id="reviews-tab" data-toggle="tab" role="tab" aria-controls="reviews"
              aria-selected="false">Reviews</a>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">

          <!-- Description Content -->
          <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
            <div class="description_info">
              <p class="p-0 mb-2">{!! $productInfo->first()->longDescription !!}</p>
            </div>
          </div>

          <!-- Additional Content -->
          <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
            <div class="additionals">
              <table class="table">
                <tbody>
                  <tr>
                    <th class="ft-medium text-dark">ID</th>
                    <td>#1253458</td>
                  </tr>
                  <tr>
                    <th class="ft-medium text-dark">SKU</th>
                    <td>KUM125896</td>
                  </tr>
                  <tr>
                    <th class="ft-medium text-dark">Color</th>
                    <td>Sky Blue</td>
                  </tr>
                  <tr>
                    <th class="ft-medium text-dark">Size</th>
                    <td>Xl, 42</td>
                  </tr>
                  <tr>
                    <th class="ft-medium text-dark">Weight</th>
                    <td>450 Gr</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Reviews Content -->

          <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
            <div class="reviews_info">
              @foreach ($productReview as $reviews )
              <div class="single_rev d-flex align-items-start br-bottom py-3">
                <div class="single_rev_thumb"><img src="assets/img/team-1.jpg" class="img-fluid circle" width="90"
                    alt="" /></div>
                <div class="single_rev_caption d-flex align-items-start pl-3">
                  <div class="single_capt_left">
                    <h5 class="mb-0 fs-md ft-medium lh-1">{{ $reviews->relToCustomer->name }}&nbsp &nbsp</h5>
                    <span class="small">{{ $reviews->updated_at->Format('d M Y')
                      }}</span>
                    <p>{{ $reviews->review }}</p>
                  </div>
                  <div class="single_capt_right">
                    <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                      @for ($i =1; $i<= $reviews->star; $i++)
                        <i class="fas fa-star filled"></i>
                        @endfor
                        @for ($j =1; $j<= 5 - $reviews->star; $j++)
                          <i class="fas fa-star"></i>
                          @endfor
                          {{-- @if ($reviews->star==1)
                          <i class="fas fa-star filled"></i>
                          @elseif ($reviews->star==2)
                          <i class="fas fa-star filled"></i>
                          <i class="fas fa-star filled"></i>
                          @elseif ($reviews->star==3)
                          <i class="fas fa-star filled"></i>
                          <i class="fas fa-star filled"></i>
                          <i class="fas fa-star filled"></i>
                          @elseif ($reviews->star==4)
                          <i class="fas fa-star filled"></i>
                          <i class="fas fa-star filled"></i>
                          <i class="fas fa-star filled"></i>
                          <i class="fas fa-star filled"></i>
                          @else
                          <i class="fas fa-star filled"></i>
                          <i class="fas fa-star filled"></i>
                          <i class="fas fa-star filled"></i>
                          <i class="fas fa-star filled"></i>
                          <i class="fas fa-star filled"></i>
                          @endif --}}
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @auth('customerLogin')
            @if(App\Models\OrderedProduct::where('customerId',Auth::guard('customerLogin')->id())->where('productId',$productInfo->first()->id)->exists())
            @if(App\Models\OrderedProduct::where('customerId',Auth::guard('customerLogin')->id())->where('productId',$productInfo->first()->id)->whereNotNull('review')->first()==false)
            <div class="reviews_rate">
              <form class="row" action="{{ route('productReview',$productInfo->first()->id) }}" method="POST">
                @csrf
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <h4>Submit Rating</h4>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <div
                    class="revie_stars d-flex align-items-center justify-content-between px-2 py-2 gray rounded mb-2 mt-1">
                    <div class="srt_013">
                      <div class="submit-rating">
                        <input class="star" id="star-5" type="radio" name="rating" value="5" />
                        <label for="star-5" title="5 stars">
                          <i class="active fa fa-star" aria-hidden="true"></i>
                        </label>
                        <input class="star" id="star-4" checked type="radio" name="rating" value="4" />
                        <label for="star-4" title="4 stars">
                          <i class="active fa fa-star" aria-hidden="true"></i>
                        </label>
                        <input class="star" id="star-3" type="radio" name="rating" value="3" />
                        <label for="star-3" title="3 stars">
                          <i class="active fa fa-star" aria-hidden="true"></i>
                        </label>
                        <input class="star" id="star-2" type="radio" name="rating" value="2" />
                        <label for="star-2" title="2 stars">
                          <i class="active fa fa-star" aria-hidden="true"></i>
                        </label>
                        <input class="star" id="star-1" type="radio" name="rating" value="1" />
                        <label for="star-1" title="1 star">
                          <i class="active fa fa-star" aria-hidden="true"></i>
                        </label>
                      </div>
                    </div>

                    <div class="srt_014">
                      <h6>
                        <span id="selectedStar" class="mb-0">4</span>
                        <span>Star</span>
                      </h6>
                    </div>
                  </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                  <div class="form-group">
                    <label class="medium text-dark ft-medium">Full Name</label>
                    <input type="text" class="form-control" readonly
                      value="{{ auth::guard('customerLogin')->user()->name }}" />
                  </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                  <div class="form-group">
                    <label class="medium text-dark ft-medium">Email Address</label>
                    <input type="email" class="form-control" readonly
                      value="{{ auth::guard('customerLogin')->user()->email }}" />
                  </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <label class="medium text-dark ft-medium">Description</label>
                    <textarea name="reviewDescription" class="form-control"></textarea>
                  </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group m-0">
                    <button type="submit" class="btn btn-white stretched-link hover-black">Submit Review <i
                        class="lni lni-arrow-right"></i></button>
                  </div>
                </div>

              </form>
            </div>
            @else
            <div class="alert alert-warning text-dark d-flex justify-content-between align-items-center h6">
              <span>You already review this product. </span>
            </div>
            @endif
            @else
            <div class="alert alert-warning text-dark d-flex justify-content-between align-items-center h6">
              <span>You did't buy this product yet. </span>
            </div>
            @endif

            @else
            <div class="alert alert-warning text-dark d-flex justify-content-between align-items-center h6">
              <span>Please
                login to leave a review </span><a class="btn btn-info" href="{{ route('registerLogin') }}">Login</a>
            </div>

            @endauth
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ======================= Product Description End ==================== -->

<!-- ======================= Similar Products Start ============================ -->
<section class="middle pt-0">
  <div class="container">

    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="sec_title position-relative text-center">
          <h2 class="off_title">Similar Products</h2>
          <h3 class="ft-bold pt-3">Matching Producta</h3>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="slide_items">

          <!-- single Item -->
          @forelse ( $matchingProduct as $match)
          <div class="single_itesm">
            <div class="product_grid card b-0 mb-0">
              @if ($match->discount)
              <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
              <div class="badge bg-danger text-white position-absolute ft-regular ab-right text-upper">-{{
                $match->discount }}%</div>
              @endif
              <div class="card-body p-0">
                <div class="shop_thumb position-relative">
                  <a class="card-img-top d-block overflow-hidden" href="{{ route('productDetails',$match->slug) }}"><img
                      class="card-img-top" src="{{ asset('uploads/product/preview/'.$match->previewImage) }}"
                      alt="..."></a>
                </div>
              </div>
              <div class="card-footer b-0 p-3 pb-0 d-flex align-items-start justify-content-center">
                <div class="text-left">
                  <div class="text-center">
                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{ route('productDetails',$match->slug) }}">{{
                        $match->productName
                        }}</a></h5>
                    <div class="elis_rty">@if ($match->discount)
                      &#2547; <span class="ft-medium text-muted line-through fs-md mr-2">{{
                        $match->price
                        }}</span><span class="ft-bold text-dark fs-sm">&#2547; {{ $match->afterDiscount }}</span>
                      @else
                      <span class="ft-bold text-dark fs-sm">&#2547; {{ $match->afterDiscount }}</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @empty
          <h4 font-weight-bold>No Matching Products Found.</h4>
          @endforelse
        </div>
      </div>
    </div>

  </div>
</section>
@endsection
@section('script')
<script>
  $('.getSize').click(function(){
    let productId = '{{ $productInfo->first()->id }}';
    let colorId = $(this).val();
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
    });
    $.ajax({
      url:'/getSize',
      type: 'post',
      data:{'productId':productId,'colorId':colorId},
      success:function(data){
        $('#ajaxSizeData').html(data);
      }
    })
})
</script>
<script>
  $('.productSize').click(function(){
    let productId = '{{ $productInfo->first()->id }}';
    let sizeId = $(this).val();
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
    });
    $.ajax({
      url:'/getColor',
      type: 'post',
      data:{'productId':productId,'sizeId':sizeId},
      success:function(data){
         $('#ajaxColorData').html(data);
      }
    })
})
</script>
@if (session('cartInsert'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('cartInsert') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@if (session('wishlistInsert'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('wishlistInsert') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@if (session('CostomerRegister'))
<script>
  Swal.fire({
            title: '{{ session('CostomerRegister') }}',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'green',
            cancelButtonColor: 'red',
            confirmButtonText: 'Login/Register!'
            }).then((result) => {
              if (result.isConfirmed) {
                let link = '{{ route('registerLogin') }}'
                window.location.href = link;
              }
            })
</script>
@endif
@if (session('wishlistexist'))
<script>
  Swal.fire('{{ session('wishlistexist') }}')
</script>
@endif

<script>
  $('.star').click(function(){
    var star = $(this).val();
    $('#selectedStar').html(star);
  });
</script>

@endsection