<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta name="author" content="Themezhub" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- ajax token --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('dashboard/images/kumo.png') }}">
  <title>Kumo- Fashion eCommerce HTML Template</title>

  <!-- Custom CSS -->
  <link href="{{ asset('frontend/css/plugins/animation.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/plugins/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/plugins/flaticon.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/plugins/font-awesome.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/plugins/iconfont.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/plugins/ion.rangeSlider.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/plugins/light-box.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/plugins/line-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/plugins/slick-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/plugins/slick.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/plugins/snackbar.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/plugins/themify.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/styles.css') }}" rel="stylesheet">
  {{-- seelct2 search --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .categoryId:checked~.form-option-label {
      border-color: #121212;
      color: #121212;
    }

    .colorId:checked~.form-option-label {
      border-color: #121212;
      color: #121212;
    }

    .sizeId:checked~.form-option-label {
      border-color: #121212;
      color: #121212;
    }
  </style>

  {{-- internal colored toast alert --}}
  <style>
    .colored-toast.swal2-icon-success {
      background-color: #a5dc86 !important;
    }

    .colored-toast.swal2-icon-error {
      background-color: #f27474 !important;
    }

    .colored-toast.swal2-icon-warning {
      background-color: #f8bb86 !important;
    }

    .colored-toast.swal2-icon-info {
      background-color: #3fc3ee !important;
    }

    .colored-toast.swal2-icon-question {
      background-color: #87adbd !important;
    }

    .colored-toast .swal2-title {
      color: white;
    }

    .colored-toast .swal2-close {
      color: white;
    }

    .colored-toast .swal2-html-container {
      color: white;
    }
  </style>

</head>

<body>
  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/6544bdb2f2439e1631eb4ae2/1hea8a15o';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();
  </script>
  <!--End of Tawk.to Script-->

  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <div class="preloader"></div>

  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper">

    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->
    <!-- Top Header -->
    <div class="py-2 br-bottom">
      <div class="container">
        <div class="row">

          <div class="col-xl-7 col-lg-6 col-md-6 col-sm-12 hide-ipad">
            <div class="top_second">
              <p class="medium text-muted m-0 p-0"><i class="lni lni-phone fs-sm"></i></i> Hotline <a href="#"
                  class="medium text-dark text-underline">0(800) 123-456</a></p>
            </div>
          </div>

          <!-- Right Menu -->
          <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
            <!-- Choose Language -->
            <div class="language-selector-wrapper dropdown js-dropdown float-right mr-3">
              <a class="popup-title" href="javascript:void(0)" data-toggle="dropdown" title="Language"
                aria-label="Language dropdown">
                <span class="hidden-xl-down medium text-muted">Language:</span>
                <span class="iso_code medium text-muted">English</span>
                <i class="fa fa-angle-down medium text-muted"></i>
              </a>
              <ul class="dropdown-menu popup-content link">
                <li class="current"><a href="javascript:void(0);" class="dropdown-item medium text-muted"><img
                      src="assets/img/1.jpg" alt="en" width="16" height="11" /><span>English</span></a></li>
                <li><a href="javascript:void(0);" class="dropdown-item medium text-muted"><img
                      src="{{ asset('frontend/img/2.jpg') }}" alt="fr" width="16"
                      height="11" /><span>Français</span></a></li>
              </ul>
            </div>
            <div class="language-selector-wrapper dropdown js-dropdown float-right mr-3">
              @auth('customerLogin')
              <a class="popup-title" href="#" data-toggle="dropdown">
                <span class="iso_code medium text-muted">{{ auth::guard('customerLogin')->user()->name }}</span>
                <i class="fa fa-angle-down medium text-muted"></i>
              </a>
              <ul class="dropdown-menu">
                <li class="current"><a href="{{ route('customerProfile') }}"
                    class="dropdown-item medium text-muted"><span>Profile</span></a>
                </li>
                <li class="current"><a href="{{ route('customerLogout') }}"
                    class="dropdown-item medium text-muted"><span>Logout</span></a>
                </li>
              </ul>
            </div>
            @else
            <a href="{{ route('registerLogin') }}" class="text-muted medium"><i class="lni lni-user mr-1"></i>Sign In
              /
              Register</a>
            @endauth
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="headd-sty header">
    <div class="container">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
          <div class="headd-sty-wrap d-flex align-items-center justify-content-between py-3">
            <div class="headd-sty-left d-flex align-items-center">
              <div class="headd-sty-01">
                <a class="nav-brand py-0" href="{{ route('frontHome') }}">
                  <img src="{{ asset('frontend/img/logo.png') }}" class="logo" alt="" />
                </a>
              </div>
              <div class="headd-sty-02 ml-3">
                <div class="input-group">
                  <input type="text" id="inputSearch" class="form-control custom-height b-0"
                    placeholder="Search for products..." />
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <button id="searchBtn" class="btn bg-white text-danger custom-height rounded px-3"
                        type="button"><i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="headd-sty-last">
              <ul class="nav-menu nav-menu-social align-to-right align-items-center d-flex">
                <li>
                  <div class="call d-flex align-items-center text-left">
                    <i class="lni lni-phone fs-xl"></i>
                    <span class="text-muted small ml-3">Call Us Now:<strong class="d-block text-dark fs-md">0(800)
                        123-456</strong></span>
                  </div>
                </li>
                <li>
                  <a href="#" onclick="openWishlist()">
                    <i class="far fa-heart fs-lg"></i><span class="dn-counter bg-success">{{
                      App\Models\Wishlist::where('customerId',Auth::guard('customerLogin')->id())->count() }}</span>
                  </a>
                </li>
                <li>
                  <a href="#" onclick="openCart()">
                    <div class="d-flex align-items-center justify-content-between">
                      <i class="fas fa-shopping-basket fs-lg"></i><span class="dn-counter theme-bg">{{
                        App\Models\Cart::where('customerId',Auth::guard('customerLogin')->id())->count() }}</span>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
            <div class="mobile_nav">
              <ul>
                <li>
                  <a href="#" onclick="openSearch()">
                    <i class="lni lni-search-alt"></i>
                  </a>
                </li>
                <li>
                  <a href="#" data-toggle="modal" data-target="#login">
                    <i class="lni lni-user"></i>
                  </a>
                </li>
                <li>
                  <a href="#" onclick="openWishlist()">
                    <i class="lni lni-heart"></i><span class="dn-counter">0</span>
                  </a>
                </li>
                <li>
                  <a href="#" onclick="openCart()">
                    <i class="lni lni-shopping-basket"></i><span class="dn-counter">0</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Start Navigation -->
  <div class="headerd header-dark head-style-2">
    <div class="container">
      <nav id="navigation" class="navigation navigation-landscape">
        <div class="nav-header">
          <div class="nav-toggle"></div>
          <div class="nav-menus-wrapper">
            <ul class="nav-menu">
              <li><a href="{{ route('frontHome') }}" class="pl-0">Home</a></li>
              <li><a href="{{ route('filter.product') }}">Shop</a></li>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>
  <!-- End Navigation -->
  <div class="clearfix"></div>
  <!-- ============================================================== -->
  <!-- Top header  -->
  <!-- ============================================================== -->

  @yield('content')


  <!-- ======================= Customer Features ======================== -->
  <section class="px-0 py-3 br-top">
    <div class="container">
      <div class="row">

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
          <div class="d-flex align-items-center justify-content-start py-2">
            <div class="d_ico">
              <i class="fas fa-shopping-basket"></i>
            </div>
            <div class="d_capt">
              <h5 class="mb-0">Free Shipping</h5>
              <span class="text-muted">Capped at $10 per order</span>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
          <div class="d-flex align-items-center justify-content-start py-2">
            <div class="d_ico">
              <i class="far fa-credit-card"></i>
            </div>
            <div class="d_capt">
              <h5 class="mb-0">Secure Payments</h5>
              <span class="text-muted">Up to 6 months installments</span>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
          <div class="d-flex align-items-center justify-content-start py-2">
            <div class="d_ico">
              <i class="fas fa-shield-alt"></i>
            </div>
            <div class="d_capt">
              <h5 class="mb-0">15-Days Returns</h5>
              <span class="text-muted">Shop with fully confidence</span>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
          <div class="d-flex align-items-center justify-content-start py-2">
            <div class="d_ico">
              <i class="fas fa-headphones-alt"></i>
            </div>
            <div class="d_capt">
              <h5 class="mb-0">24x7 Fully Support</h5>
              <span class="text-muted">Get friendly support</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
  <!-- ======================= Customer Features ======================== -->

  <!-- ============================ Footer Start ================================== -->
  <footer class="dark-footer skin-dark-footer style-2">
    <div class="footer-middle">
      <div class="container">
        <div class="row">

          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
            <div class="footer_widget">
              <img src="{{ asset('frontend/img/logo-light.png') }}" class="img-footer small mb-2" alt="" />

              <div class="address mt-3">
                3298 Grant Street Longview, TX<br>United Kingdom 75601
              </div>
              <div class="address mt-3">
                1-202-555-0106<br>help@shopper.com
              </div>
              <div class="address mt-3">
                <ul class="list-inline">
                  <li class="list-inline-item"><a href="#"><i class="lni lni-facebook-filled"></i></a></li>
                  <li class="list-inline-item"><a href="#"><i class="lni lni-twitter-filled"></i></a></li>
                  <li class="list-inline-item"><a href="#"><i class="lni lni-youtube"></i></a></li>
                  <li class="list-inline-item"><a href="#"><i class="lni lni-instagram-filled"></i></a></li>
                  <li class="list-inline-item"><a href="#"><i class="lni lni-linkedin-original"></i></a></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
            <div class="footer_widget">
              <h4 class="widget_title">Supports</h4>
              <ul class="footer-menu">
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">About Page</a></li>
                <li><a href="#">Size Guide</a></li>
                <li><a href="#">FAQ's Page</a></li>
                <li><a href="#">Privacy</a></li>
              </ul>
            </div>
          </div>

          <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
            <div class="footer_widget">
              <h4 class="widget_title">Shop</h4>
              <ul class="footer-menu">
                <li><a href="#">Men's Shopping</a></li>
                <li><a href="#">Women's Shopping</a></li>
                <li><a href="#">Kids's Shopping</a></li>
                <li><a href="#">Furniture</a></li>
                <li><a href="#">Discounts</a></li>
              </ul>
            </div>
          </div>

          <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
            <div class="footer_widget">
              <h4 class="widget_title">Company</h4>
              <ul class="footer-menu">
                <li><a href="#">About</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Affiliate</a></li>
                <li><a href="#">Login</a></li>
              </ul>
            </div>
          </div>

          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
            <div class="footer_widget">
              <h4 class="widget_title">Subscribe</h4>
              <p>Receive updates, hot deals, discounts sent straignt in your inbox daily</p>
              <div class="foot-news-last">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Email Address">
                  <div class="input-group-append">
                    <button type="button" class="input-group-text b-0 text-light"><i
                        class="lni lni-arrow-right"></i></button>
                  </div>
                </div>
              </div>
              <div class="address mt-3">
                <h5 class="fs-sm text-light">Secure Payments</h5>
                <div class="scr_payment"><img src="assets/img/card.png" class="img-fluid" alt="" /></div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12 col-md-12 text-center">
            <p class="mb-0">© 2021 Kumo. Designd By <a href="https://themezhub.com/">ThemezHub</a>.</p>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- ============================ Footer End ================================== -->

  <!-- Wishlist -->
  <div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Wishlist">
    <div class="rightMenu-scroll">
      <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
        <h4 class="cart_heading fs-md ft-medium mb-0">Saved Products</h4>
        <button onclick="closeWishlist()" class="close_slide"><i class="ti-close"></i></button>
      </div>
      <div class="right-ch-sideBar">

        <div class="cart_select_items py-2">
          @foreach (App\Models\Wishlist::where('customerId',Auth::guard('customerLogin')->id())->get() as $wishList )
          <!-- Single Item -->
          <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
            <div class="cart_single d-flex align-items-center">
              <div class="cart_selected_single_thumb">
                <a href="#"><img src="{{ asset('uploads/product/preview/'.$wishList->relToProduct->previewImage) }}"
                    width="60" class="img-fluid" alt="" /></a>
              </div>
              <div class="cart_single_caption pl-2">
                <h4 class="product_title fs-sm ft-medium mb-0 lh-1">{{ $wishList->relToProduct->productName }}</h4>
                <p class="mb-2"><span class="text-dark ft-medium small">{{
                    $wishList->relToSize->productSize }}</span>,
                  <span class="text-dark small">{{$wishList->relToColor->colorName
                    }}</span>
                </p>
                @if ($wishList->relToProduct->discount)
                <h4 class="fs-md ft-medium mb-0 lh-1">TK {{ number_format(round($wishList->relToProduct->afterDiscount))
                  }}</h4>
                @else
                <h4 class="fs-md ft-medium mb-0 lh-1">TK {{ number_format(round($wishList->relToProduct->price)) }}</h4>
                @endif
              </div>
            </div>
            <div class="fls_last"><a href="{{ route('wishlistDelete',$wishList->id) }}" class="close_slide gray"><i
                  class="ti-close"></i></a></div>
          </div>
          @endforeach
        </div>

        <div class="cart_action px-3 py-3">
          <div class="form-group">
            <button type="button" class="btn d-block full-width btn-dark-light"><a
                href="{{ route('customerWishlist') }}">Wishlist</a> </button>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Cart -->
  <div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Cart">
    <div class="rightMenu-scroll">
      <div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
        <h4 class="cart_heading fs-md ft-medium mb-0">Products List</h4>
        <button onclick="closeCart()" class="close_slide"><i class="ti-close"></i></button>
      </div>
      <div class="right-ch-sideBar">

        <div class="cart_select_items py-2">
          <!-- Single Item -->
          @php
          $subTotal = 0;
          @endphp
          @foreach (App\Models\Cart::where('customerId',Auth::guard('customerLogin')->id())->get() as $cartList )
          <div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
            <div class="cart_single d-flex align-items-center">
              <div class="cart_selected_single_thumb">
                <a href="#"><img src="{{ asset('uploads/product/preview/'.$cartList->relToProduct->previewImage) }}"
                    width="60" class="img-fluid" alt="" /></a>
              </div>
              <div class="cart_single_caption pl-2">
                <h4 class="product_title fs-sm ft-medium mb-0 lh-1">{{ $cartList->relToProduct->productName }}</h4>
                <p class="mb-2"><span class="text-dark ft-medium small">{{$cartList->relToSize->productSize}}</span>
                  <span class="text-dark small">{{ $cartList->colorId==
                    NULL?'N/A': $cartList->relToColor->colorName}}</span>
                </p>
                @if ($cartList->relToProduct->discount)
                <h4 class="fs-md ft-medium mb-0 lh-1">TK {{ number_format(round($cartList->relToProduct->afterDiscount))
                  }} X{{
                  $cartList->quantity }}</h4>
                @else
                <h4 class="fs-md ft-medium mb-0 lh-1">TK {{ number_format(round($cartList->relToProduct->price)) }} X{{
                  $cartList->quantity }}</h4>
                @endif
              </div>
            </div>
            <div class="fls_last">
              <a href="{{ route('deleteCart',$cartList->id) }}" class="close_slide gray"><i class="ti-close"></i>
              </a>
            </div>
          </div>
          @if ($cartList->relToProduct->discount)
          @php
          $subTotal += $cartList->relToProduct->afterDiscount * $cartList->quantity
          @endphp
          @else
          @php
          $subTotal += $cartList->relToProduct->price * $cartList->quantity
          @endphp
          @endif
          @endforeach
        </div>

        <div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
          <h6 class="mb-0">Subtotal</h6>
          <h3 class="mb-0 ft-medium">Tk {{ number_format(round($subTotal),2) }}</h3>
        </div>

        <div class="cart_action px-3 py-3">
          <div class="form-group">
            <a href="{{ route('viewCart') }}" type="button" class="btn d-block full-width btn-dark-light">View Cart</a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>

  </div>
  <!-- ============================================================== -->
  <!-- End Wrapper -->
  <!-- ============================================================== -->

  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
  <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
  <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/js/ion.rangeSlider.min.js') }}"></script>
  <script src="{{ asset('frontend/js/slick.js') }}"></script>
  <script src="{{ asset('frontend/js/slider-bg.js') }}"></script>
  <script src="{{ asset('frontend/js/lightbox.js') }}"></script>
  <script src="{{ asset('frontend/js/smoothproducts.js') }}"></script>
  <script src="{{ asset('frontend/js/snackbar.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jQuery.style.switcher.js') }}"></script>
  <script src="{{ asset('frontend/js/custom.js') }}"></script>
  {{-- sweet alert --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  {{-- seelct2 search --}}
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <!-- ============================================================== 
    -->
  <!-- This page plugins -->
  <!-- ============================================================== -->

  <script>
    function openWishlist() {
				document.getElementById("Wishlist").style.display = "block";
			}
			function closeWishlist() {
				document.getElementById("Wishlist").style.display = "none";
			}
  </script>

  <script>
    function openCart() {
				document.getElementById("Cart").style.display = "block";
			}
			function closeCart() {
				document.getElementById("Cart").style.display = "none";
			}
  </script>

  <script>
    function openSearch() {
				document.getElementById("Search").style.display = "block";
			}
			function closeSearch() {
				document.getElementById("Search").style.display = "none";
			}
  </script>
  <script>
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
  </script>

  @yield('script')

</body>

</html>