@extends('frontend.master')
@section('content')

<body class="h-100">
  <div class="authincation h-100">
    <div class="container h-100">
      <div class="row justify-content-center h-100 align-items-center">
        <div class="col-md-5">
          <div class="form-input-content text-center error-page">
            <h1 class="error-text  font-weight-bold">404</h1>
            <h4><i class="fa fa-times-circle text-danger"></i> Sorry!</h4>
            <p>This page does not exists yet</p>
            <div>
              <a class="btn btn-primary" href="{{ route('frontHome') }}">Back to Home</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
@endsection