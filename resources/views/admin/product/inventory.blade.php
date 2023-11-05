@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('viewProduct') }}">Product</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Inventory</a></li>
  </ol>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h4 class="font-weight-bold">Inventory For => {{ $productInfo->productName }}</h4>
      </div>
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Color</th>
              <th>Size</th>
              <th>Quantity</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($inventory as $sl => $inventories )
            <tr>
              <td>{{ $sl+1 }}</td>
              <td>{{ $inventories->relToColor->colorName }}</td>
              <td>{{ $inventories->relToSize->productSize }}</td>
              <td>{{ $inventories->quantity }}</td>
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
                    <a class="dropdown-item" href="{{ route('editInventory',$inventories->id) }}">Edit</a>
                    <button value="{{ route('inventoryDelete',$inventories->id) }}"
                      class="dropdown-item inventoryDel">Delete</button>
                  </div>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-secondary">You did't add any inventory yet.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h4>Add Product Inventory</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('inventoryStore') }}" method="post">
          @csrf
          <div class="mb-3">
            <input type="hidden" value="{{ $productInfo->id  }}" name="productId">
            <h5>Product Name : {{ $productInfo->productName }}</h5>
          </div>
          <div class="mb-3">
            <select name="colorId" id="" class="form-control">
              <option value="" disabled selected>--Select Color--</option>
              @foreach ($colors as $color )
              <option value="{{ $color->id }}">{{ $color->colorName }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <select name="sizeId" id="" class="form-control">
              <option value="" disabled selected>--Select Size--</option>
              @foreach ($size as $sizes )
              {{-- @if($sizes->subcategoryId==$productInfo->subcategoryId)
              @else --}}
              <option value="{{ $sizes->id }}">{{ $sizes->productSize }}</option>
              {{-- <option value="{{ $sizes->id }}">{{ $sizes->productSize }}</option>
              @endif --}}
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="quantity">product Quantity</label><br>
            @error('quantity')
            <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <input type="number" class="form-control" id="quantity" name="quantity">
          </div>
          <div class="mt-3">
            <button class="btn btn-primary">Add Inventory</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
@if (session('inventoryInsert'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('inventoryInsert') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
<script>
  $('.inventoryDel').click(function(){
    let link = $(this).val();
    Swal.fire({
       title: 'Are you sure?',
       text: "You want to delete this inventory?",
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
@if (session('inventoryDel'))
<script>
  Swal.fire({
      position: 'center-center',
      icon: 'success',
      title: '{{ session('inventoryDel') }}',
      showConfirmButton: true,
      timer: 3000,
    })
</script>
@endif
@endsection