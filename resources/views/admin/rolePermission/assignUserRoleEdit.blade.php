@extends('layouts.dashboard')
@section('content')
<div class="col-lg-8 m-auto">
  <div class="card">
    <div class="card-header">
      <h4>Edit User Role</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('assign.user.role.update') }}" class="form-group" method="post">
        @csrf
        <div class="mb-3">
          {{-- <select class="form-control" id="userName">
            <option disabled selected>---Select User---</option>
            @foreach ($users as $user )
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select> --}}
          <select class="form-control" id="multiple-select-field" data-placeholder="--Select User--" multiple
            name="userId[]">
            @foreach ($users as $user )
            <option {{ $user->name==$singleUser->name?'selected':'' }} value="{{ $user->id }}">{{ $user->name }}
            </option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <h5 for="roleName" class="form-label">Select Role</h5>
          <div class="checkbox" style="display: inline-block; margin-right:10px">
            @foreach ($roles as $role )
            <label for="role{{ $role->id }}" class="unselectable">
              <input {{($singleUser->hasRole($role->name)?'checked':'')}} class="checkMe mx-1"
              id="role{{$role->id}}"type="checkbox" name="roleId[]" value=" {{ $role->id }}">
              {{ $role->name }}</label>
            @endforeach
          </div>
        </div>
        <div class="mb-3">
          <button type="submit" class="btn btn-primary">Update User Role</button>
        </div>
      </form>
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
@endsection