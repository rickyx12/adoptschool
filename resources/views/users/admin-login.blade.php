@extends('main')

@section('login')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">

				@if (session('error'))
				    <div class="alert alert-danger mt-2">
				        {{ session('error') }}
				    </div>
				@endif

				<div class="card mt-3">
					<div class="card-header bg-info text-white"><h6>Login</h6></div>
					<div class="card-body">
						<form id="loginForm" method="POST">
							@csrf
							<div class="form-group">
								<label>Email Address</label>
								<input type="email" name="email" id="emailAddress" class="form-control" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" name="password" id="password" class="form-control">
							</div>
							<div class="row mt-3">
								<div class="col-md text-right">
									<input type="submit" id="loginBtn" class="btn btn-success" value="Login >>" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
@endsection


@push('school-registration-scripts')
    <script src="{{ url('../resources/js/admin-login.js') }}"></script>
@endpush