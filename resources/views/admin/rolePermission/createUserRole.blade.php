@extends('layouts.dashboard')

@section('content')
<div class="row">
  <div class="col-lg-8">
    <div class="card-header">
      <h3>User Role List</h3>
    </div>
    <div class="card-body">
      <table class="table table-striped table-dark" id="myTable">
        <thead>
          <tr>
            <th>Sl</th>
            <th>User Name</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $key=>$user )
          <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $user->name }}</td>
            <td>
              {{-- Here getRoleNames is default keyword of spatie permission package --}}
              @foreach ($user->getRoleNames() as $role )
              <strong class="badge badge-pill badge-info text-white my-1">{{ $role }}</strong>
              @endforeach
              &nbsp;
            </td>
            <td>
              <a class="btn btn-success" href="{{ route('assign.user.role.edit',$user->id) }}">Edit</a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center text-danger">No data available.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>>
  </div>
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h4>Create User Role</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('assign.user.role.store') }}" class="form-group" method="post">
          @csrf
          <div class="form-group mb-3">
            {{-- <select class="form-control" id="userName">
              <option disabled selected>---Select User---</option>
              @foreach ($users as $user )
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select> --}}
            <select class="form-control" id="multiple-select-field" data-placeholder="--Select User--" multiple
              name="userId[]">
              @foreach ($users as $user )
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <h5 for="roleName" class="form-label">Select Role</h5>
            <div class="checkbox" style="display: inline-block; margin-right:10px">
              @error('permissionId')
              <span class="text-danger">{{ $message }}</span><br>
              @enderror
              @foreach ($roles as $role )
              <label for="role{{ $role->id }}" class="unselectable"><input class="checkMe mx-1" id="role{{ $role->id }}"
                  type="checkbox" name="roleId[]" value=" {{ $role->id }}">
                {{ $role->name }}</label>
              @endforeach
            </div>
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary">Assign User Role</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
{{-- <script>
  $("#userName").select2({
    theme: "bootstrap-5",
    containerCssClass: "select2--small",
    dropdownCssClass: "select2--small",
});
</script> --}}
<script>
  $( '#multiple-select-field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    closeOnSelect: false,
} );
</script>
@if (session('success'))
<script>
  const Toast = Swal.mixin({
  toast: true,
  position: 'top-right',
  iconColor: 'white',
  customClass: {
    popup: 'colored-toast'
  },
  showConfirmButton: false,
  timer: 2500,
  timerProgressBar: true
})
 Toast.fire({
  icon: 'success',
  title: '{{ session('success') }}'
})
</script>
@endif
@endsection