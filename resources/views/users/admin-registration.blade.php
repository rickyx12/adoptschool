@extends('main')

@section('admin-registration')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">

				<div id="registrationCard" class="card mt-3">
					<div class="card-header bg-info text-white"><h6>Admin Registration</h6></div>
					<div class="card-body">
						<form id="loginForm" method="POST">
							@csrf
							<div class="form-group">
								<label>Email Address</label>
								<input type="email" name="email" id="emailAddress" class="form-control" autocomplete="off">
								<div id="errorEmail"></div>
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" name="password" id="password" class="form-control">
								<div id="errorPassword"></div>
							</div>
							<div class="form-group">
								<label>Complete Name</label>
								<input type="text" name="completeName" id="completeName" class="form-control" autocomplete="off">
								<div id="errorCompleteName"></div>
							</div>
							<div class="row mt-3">
								<div class="col-md text-right">
									<input type="submit" id="registerBtn" class="btn btn-success" value="Register >>" />
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


@push('admin-registration-scripts')
	<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ url('../resources/js/admin-register.js') }}"></script>
@endpush