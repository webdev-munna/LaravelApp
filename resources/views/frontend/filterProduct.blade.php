@extends('frontend.master')

@section('content')
<!-- ======================= Shop Style 1 ======================== -->
<section class="bg-cover" style="background:url({{ asset('frontend/img/banner-2.png') }}) no-repeat;">
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="text-left py-5 mt-3 mb-3">
          <h1 class="ft-medium mb-3">Shop</h1>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ======================= Shop Style 1 ======================== -->


<!-- ======================= Filter Wrap Style 1 ======================== -->
<section class="py-3 br-bottom br-top">
  <div class="container">
    <div class="row align-items-center justify-content-between">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Women's</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ============================= Filter Wrap ============================== -->


<!-- ======================= All Product List ======================== -->
<section class="middle">
  <div class="container">
    <div class="row">

      <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 p-xl-0">
        <div class="search-sidebar sm-sidebar border">
          <div class="search-sidebar-body">
            <!-- Single Option -->
            <div class="single_search_boxed">
              <div class="col-lg-12">
                <div class="form-group px-3">
                  <button type="reset" id="resetShop" class="btn btn-dark form-control">Reset Filter</button>
                </div>
              </div>
              <div class="widget-boxed-header">
                <h4><a href="#pricing" data-toggle="collapse" aria-expanded="false" role="button">Pricing</a></h4>
              </div>
              <div class="widget-boxed-body collapse show" id="pricing" data-parent="#pricing">
                <div class="row">
                  <div class="col-lg-6 pr-1">
                    <div class="form-group pr-3">
                      <input type="number" class="form-control min" placeholder="Min"
                        value="{{ @$_GET['min']!=NULL?$_GET['min']:'' }}">
                    </div>
                  </div>
                  <div class="col-lg-6 pl-1">
                    <div class="form-group pr-3">
                      <input type="number" class="form-control max" placeholder="Max"
                        value="{{ @$_GET['max']!=NULL?$_GET['max']:'' }}">
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group px-3">
                      <button type="submit" class="btn form-control sortBtn">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Single Option -->
            <div class="single_search_boxed">
              <div class="widget-boxed-header">
                <h4><a href="#Categories" data-toggle="collapse" aria-expanded="false" role="button">Categories</a></h4>
              </div>
              <div class="widget-boxed-body collapse show" id="Categories" data-parent="#Categories">
                <div class="side-list no-border">
                  <!-- Single Filter Card -->
                  <div class="single_filter_card">
                    <div class="card-body pt-0">
                      <div class="inner_widget_link">
                        <ul class="no-ul-list">
                          @foreach ($categories as $category)
                          <li>
                            <input {{ @$_GET['category']==$category->id?'checked':'' }} id="category{{ $category->id }}"
                            class="categoryId" name="category" type="radio"
                            value="{{ $category->id }}">
                            <label for="category{{ $category->id }}" class="checkbox-custom-label">{{
                              $category->category_name
                              }}<span>{{ App\Models\Product::where('categoryId',$category->id)->count();
                                }}</span></label>
                          </li>
                          @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Single Option -->
            <div class="single_search_boxed">
              <div class="widget-boxed-header">
                <h4><a href="#brands" data-toggle="collapse" aria-expanded="false" role="button">Brands</a></h4>
              </div>
              <div class="widget-boxed-body collapse show" id="brands" data-parent="#brands">
                <div class="side-list no-border">
                  <!-- Single Filter Card -->
                  <div class="single_filter_card">
                    <div class="card-body pt-0">
                      <div class="inner_widget_link">
                        <ul class="no-ul-list">
                          <li>
                            <input id="brands1" class="checkbox-custom" name="brands" type="radio">
                            <label for="brands1" class="checkbox-custom-label">Sumsung<span>142</span></label>
                          </li>
                          <li>
                            <input id="brands2" class="checkbox-custom" name="brands" type="radio">
                            <label for="brands2" class="checkbox-custom-label">Apple<span>652</span></label>
                          </li>
                          <li>
                            <input id="brands3" class="checkbox-custom" name="brands" type="radio">
                            <label for="brands3" class="checkbox-custom-label">Nike<span>232</span></label>
                          </li>
                          <li>
                            <input id="brands4" class="checkbox-custom" name="brands" type="radio">
                            <label for="brands4" class="checkbox-custom-label">Reebok<span>192</span></label>
                          </li>
                          <li>
                            <input id="brands5" class="checkbox-custom" name="brands" type="radio">
                            <label for="brands5" class="checkbox-custom-label">Hawai<span>265</span></label>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Single Option -->
            <div class="single_search_boxed">
              <div class="widget-boxed-header">
                <h4><a href="#colors" data-toggle="collapse" class="collapsed" aria-expanded="false"
                    role="button">Colors</a></h4>
              </div>
              <div class="widget-boxed-body collapse" id="colors" data-parent="#colors">
                <div class="side-list no-border">
                  <!-- Single Filter Card -->
                  <div class="single_filter_card">
                    <div class="card-body pt-0">
                      <div class="text-left">
                        @foreach ($colors as $color )
                        <div class="form-check form-option form-check-inline mb-1">
                          <input {{ @$_GET['color']==$color->id?'checked':'' }} class="colorId" type="radio"
                          name="colora8" id="color{{ $color->id }}"
                          value="{{ $color->id }}">
                          <label class="form-option-label rounded-circle" for="color{{ $color->id }}"><span
                              style="background: {{ $color->colorCode }}"
                              class="form-option-color rounded-circle"></span></label>
                        </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Single Option -->
            <div class="single_search_boxed">
              <div class="widget-boxed-header">
                <h4><a href="#size" data-toggle="collapse" class="collapsed" aria-expanded="false"
                    role="button">Size</a></h4>
              </div>
              <div class="widget-boxed-body collapse" id="size" data-parent="#size">
                <div class="side-list no-border">
                  <!-- Single Filter Card -->
                  <div class="single_filter_card">
                    <div class="card-body pt-0">
                      <div class="text-left pb-0 pt-2">
                        @foreach ($sizes as $size )
                        <div class="form-check form-option form-check-inline mb-2">
                          <input {{ @$_GET['size']==$size->id?'checked':'' }} class="sizeId" type="radio" name="sizes"
                          id="id{{ $size->id }}"
                          value="{{ $size->id }}">
                          <label class="form-option-label" for="id{{ $size->id }}">{{ $size->productSize }}</label>
                        </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">

        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="border mb-3 mfliud">
              <div class="row align-items-center py-2 m-0">
                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                  <h6 class="mb-0">Searched Products Found</h6>
                </div>

                <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                  <div class="filter_wraps d-flex align-items-center justify-content-end m-start">
                    <div class="single_fitres mr-2 br-right">
                      <select class="custom-select simple sortBy">
                        <option value="">--Sorting--</option>
                        <option {{ @$_GET['sortBy']==1?'selected':'' }} value="1"> Sort By Low-High Price</option>
                        <option {{ @$_GET['sortBy']==2?'selected':'' }} value="2"> Sort By Hight-Low Price</option>
                        <option {{ @$_GET['sortBy']==3?'selected':'' }} value="3"> Sort By A-Z</option>
                        <option {{ @$_GET['sortBy']==4?'selected':'' }} value="3"> Sort By Z-A</option>
                      </select>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- row -->
        <div class="row align-items-center rows-products">

          <!-- Single -->
          @forelse ($searchProduct as $allProducts )
          <div class="col-xl-4 col-lg-4 col-md-6 col-6">
            <div class="product_grid card b-0">
              @if ($allProducts->discount)
              <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">
                <h5>-{{ $allProducts->discount }}%</h5>
              </div>
              @else
              <span class="d-none"></span>
              @endif
              <div class="card-body p-0">
                <div class="shop_thumb position-relative">
                  <a class="card-img-top d-block overflow-hidden"
                    href="{{ route('productDetails',$allProducts->slug) }}"><img class="card-img-top"
                      src="{{ asset('uploads/product/preview/'.$allProducts->previewImage) }}" alt="..."></a>
                </div>
              </div>
              <div class="card-footer b-0 p-0 pt-2 bg-white">

                <div class="text-left">
                  <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a
                      href="{{ route('productDetails',$allProducts->slug) }}">{{ $allProducts->productName
                      }}</a></h5>
                  <div class="elis_rty"><span class="ft-bold text-dark fs-sm">&#2547 {{ $allProducts->afterDiscount
                      }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @empty
          <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <h5 class="text-center text-info mt-4">No Product Found.</h5>
          </div>
          @endforelse
        </div>
        <!-- row -->
      </div>
    </div>
  </div>
</section>
<!-- ======================= All Product List ======================== -->
@endsection
@section('script')
{{-- <script>
  $('#searchBtn').click(function(){
    var result = $('#inputSearch').val();
    var catgoryId = $('input[class="categoryId"]:checked').val();
    var colorId = $('input[class="colorId"]:checked').val();
    var sizeId = $('input[class="sizeId"]:checked').val();
    var min = $('.min').val();
    var max = $('.max').val();
    var sortBy = $('.sortBy').val();
    var link = "{{ route('filter.product') }}"+"?qry="+result+"&category="+catgoryId+"&color="+colorId+"&size="+sizeId+"&min="+min+"&max="+max+"& sortBy ="+sortBy;
    window.location.href = link;
  });

  $('.sortBtn').click(function(){
    var result = $('#inputSearch').val();
    var catgoryId = $('input[class="categoryId"]:checked').val();
    var colorId = $('input[class="colorId"]:checked').val();
    var sizeId = $('input[class="sizeId"]:checked').val();
    var min = $('.min').val();
    var max = $('.max').val();
    var sortBy = $('.sortBy').val();
    var link = "{{ route('filter.product') }}"+"? qry ="+result+"&category="+catgoryId+"&color="+colorId+"&size="+sizeId+"&min="+min+"&max="+max+"& sortBy ="+sortBy;
    window.location.href = link;
  });

  $('.categoryId').click(function(){
    var result = $('#inputSearch').val();
    var catgoryId = $('input[class="categoryId"]:checked').val();
    var colorId = $('input[class="colorId"]:checked').val();
    var sizeId = $('input[class="sizeId"]:checked').val();
    var min = $('.min').val();
    var max = $('.max').val();
    var sortBy = $('.sortBy').val();
    var link = "{{ route('filter.product') }}"+"?qry="+result+"&category="+catgoryId+"&color="+colorId+"&size="+sizeId+"&min="+min+"&max="+max+"& sortBy ="+sortBy;
    window.location.href = link;
  });

  $('.colorId').click(function(){
    var result = $('#inputSearch').val();
    var catgoryId = $('input[class="categoryId"]:checked').val();
    var colorId = $('input[class="colorId"]:checked').val();
    var sizeId = $('input[class="sizeId"]:checked').val();
    var min = $('.min').val();
    var max = $('.max').val();
    var sortBy = $('.sortBy').val();
    var link = "{{ route('filter.product') }}"+"? qry ="+result+"&category="+catgoryId+"&color="+colorId+"&size="+sizeId+"&min="+min+"&max="+max+"& sortBy ="+sortBy;
    window.location.href = link;
  });

  $('.sizeId').click(function(){
    var result = $('#inputSearch').val();
    var catgoryId = $('input[class="categoryId"]:checked').val();
    var colorId = $('input[class="colorId"]:checked').val();
    var sizeId = $('input[class="sizeId"]:checked').val();
    var min = $('.min').val();
    var max = $('.max').val();
    var sortBy = $('.sortBy').val();
    var link = "{{ route('filter.product') }}"+"? qry ="+result+"&category="+catgoryId+"&color="+colorId+"&size="+sizeId+"&min="+min+"&max="+max+"& sortBy ="+sortBy;
    window.location.href = link;
  });

  $('.sortBy').change(function(){
    var result = $('#inputSearch').val();
    var catgoryId = $('input[class="categoryId"]:checked').val();
    var colorId = $('input[class="colorId"]:checked').val();
    var sizeId = $('input[class="sizeId"]:checked').val();
    var min = $('.min').val();
    var max = $('.max').val();
    var sortBy = $('.sortBy').val();
    var link = "{{ route('filter.product') }}"+"?qry="+result+"&category="+catgoryId+"&color="+colorId+"&size="+sizeId+"&min="+min+"&max="+max+"&sortBy="+sortBy;
    window.location.href = link;
  });
</script>
<script>
  $('#resetShop').click(function(){
    var link = "{{ route('filter.product') }}";
    window.location.href = link;
  });
</script> --}}
@endsection