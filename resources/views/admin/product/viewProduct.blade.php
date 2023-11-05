@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">View Product</a></li>
  </ol>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex">
        <h4>Product List</h4>
        <span class="float-end">Total: {{ count($products) }} </span>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="myTable">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Product</th>
              <th>Price</th>
              <th>Discount</th>
              <th>After Discount</th>
              <th>Brand</th>
              <th>Preview</th>
              <th>Thumbnails</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($products as $key=>$products )
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $products->productName }}</td>
              <td>{{ $products->price }}</td>
              <td>{{ $products->discount }}</td>
              <td>{{ $products->afterDiscount }}</td>
              @if ($products->brand == null)
              <td>No Brand</td>
              @else
              <td>{{ $products->brand }}</td>
              @endif
              <td><img width="60" src="{{ asset('uploads/product/preview/'.$products->previewImage) }}" alt="">
              </td>
              <td>
                @foreach (App\Models\Thumbnail::where('productId',$products->id)->get() as $thumbImage )
                <img width="50" src="{{ asset('uploads/product/thumbnail/'.$thumbImage->productThumbnail) }}" alt="">
                @endforeach
              </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <circle fill="#000000" cx="5" cy="12" r="2" />
                        <circle fill="#000000" cx="12" cy="12" r="2" />
                        <circle fill="#000000" cx="19" cy="12" r="2" />
                      </g>
                    </svg>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('inventory',$products->id) }}">Inventory</a>
                    <button value="{{ route('softDelete',$products->id) }}" class="dropdown-item productDel">Move To
                      Trash</button>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Trash section --}}

  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex">
        <h4> Trash Product List</h4>
        <span class="float-end">Total:{{ count($trashProducts) }}</span>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="myTable">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Product</th>
              <th>Price</th>
              <th>Discount</th>
              <th>After Discount</th>
              <th>Brand</th>
              <th>Preview</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($trashProducts as $key=>$trashProduct )
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $trashProduct->productName }}</td>
              <td>{{ $trashProduct->price }}</td>
              <td>{{ $trashProduct->discount }}</td>
              <td>{{ $trashProduct->afterDiscount }}</td>
              @if ($trashProduct->brand == null)
              <td>No Brand</td>
              @else
              <td>{{ $trashProduct->brand }}</td>
              @endif
              <td><img width="60" src="{{ asset('uploads/product/preview/'.$trashProduct->previewImage) }}" alt="">
              </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <circle fill="#000000" cx="5" cy="12" r="2" />
                        <circle fill="#000000" cx="12" cy="12" r="2" />
                        <circle fill="#000000" cx="19" cy="12" r="2" />
                      </g>
                    </svg>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('inventory',$trashProduct->id) }}">Restore</a>
                    <button value="{{ route('deleteProduct',$trashProduct->id) }}"
                      class="dropdown-item productDel">Force
                      Delete</button>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
  $('.productDel').click(function(){
      let link = $(this).val();
      Swal.fire({
       title: 'Are you sure?',
       text: "You want to delete this product!",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: 'red',
       cancelButtonColor: 'green',
       confirmButtonText: 'Delete!'
       }).then((result) => {
         if (result.isConfirmed) {
           window.location.href = link;
         }
       })
     })
</script>
@if (session('productDel'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('productDel') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
{{-- data table --}}
<script>
  let table = new DataTable('#myTable');
</script>
@endsection