@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
  </ol>
</div>
<div class="row">
  <div class="col-lg-10 m-auto">
    <div class="card">
      <div class="card-header">
        <h2 class="text-center">Users List</h2>
      </div>
      @if(session('success'))
      <div class="alert alert-success mx-4 mt-2">{{ session('success') }}</div>
      @endif
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Image</th>
              <th>Name</th>
              <th>Email</th>
              <th>Created_at</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($userList as $key=> $user )
            <tr>
              <td scope="row">{{ $key+1 }}</td>
              <td>
                @if ($user->image == null)
                <img width="50" src="{{ Avatar::create($user->name)->toBase64() }}" />
                @else
                <img width="50" src="{{ asset('uploads/user') }}/{{ auth::user()->image }}">
                @endif
              </td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->created_at }}
                {{ $user->created_at->diffForHumans() }}</td>
              <td><button class="btn btn-danger danger del" value="{{ route('userDelete',$user->id) }}">Delete</button>
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
  $('.del').click(function(){
      Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this user!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'red',
            cancelButtonColor: 'green',
            confirmButtonText: 'Delete!'
            }).then((result) => {
              if (result.isConfirmed) {
                let link = $(this).val()
                window.location.href = link;
              }
            })
     })
</script>
@if (session('userDel'))
<script>
  Swal.fire({
  position: 'center-center',
  icon: 'success',
  title: '{{ session('userDel') }}',
  showConfirmButton: false,
  timer: 3000
})
</script>
@endif
@endsection