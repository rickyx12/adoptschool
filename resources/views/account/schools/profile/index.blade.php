@extends('main')

@section('schools-profile')
  <div id="schoolsProfile" class="container">
  	<div class="row">
	  	<div class="col-md-3"></div>

	  	<div class="col-md-6">
		  	<div class="card mt-4 mb-4">
		  		<div class="card-body d-flex flex-column">
		  			<div class="form-group">
		  				<label>School</label>
		  				<input id="name" type="text" class="form-control" :class="errorName" value="{{ $profile->name }}">
				      <div v-if="errorNameShow" class="invalid-feedback">
				        @{{ errorNameMsg }}
				      </div>		  				
		  			</div>
		  			<div class="form-group">
		  				<label>Region</label>
		  				<select id="region" class="form-control" @change="getDivision">
		  					<option value="{{ $profile->regionId }}">{{ $profile->region }}</option>
		  					@foreach($regions as $region)
		  						<option value="{{ $region->id }}">{{ $region->name }}</option>
		  					@endforeach
		  				</select>
		  			</div>
		  			<div class="form-group">
		  				<label>Division</label>
		  				<select id="division" class="form-control">
		  					<option value="{{ $profile->divisionId }}">{{ $profile->division }}</option>
		  					<option v-for="division in divisions" :value="division.id" :key="division.id">@{{ division.name}}</option>
		  				</select>
		  			</div>
		  			<div class="form-group">
		  				<label>Type</label>
		  				<select id="schoolType" class="form-control">
		  					<option value="{{ $profile->schoolTypeId }}">{{ $profile->schoolType }}</option>
		  					@foreach($schoolType as $type)
		  						<option value="{{ $type->id }}">{{ $type->type }}</option>
		  					@endforeach
		  				</select>
		  			</div>
		  			<div class="form-group">
		  				<label>Accountable Person</label>
		  				<input id="accountablePerson" type="text" class="form-control" :class="errorAccountablePerson" value="{{ $profile->accountable_person }}">
					      <div v-if="errorAccountablePersonShow" class="invalid-feedback">
					        @{{ errorAccountablePersonMsg }}
					      </div>		  				
		  			</div>
		  			<div class="form-group">
		  				<label>Position</label>
		  				<input id="position" type="text" class="form-control" :class="errorPosition" value="{{ $profile->position }}">
					      <div v-if="errorPositionShow" class="invalid-feedback">
					        @{{ errorPositionMsg }}
					      </div>		  			
		  			</div>
		  			<div class="form-group">
		  				<label>Contact#</label>
		  				<input id="contactNo" type="text" class="form-control" :class="errorContactNo" value="{{ $profile->contact_no }}">
					      <div v-if="errorContactNoShow" class="invalid-feedback">
					        @{{ errorContactNoMsg }}
					      </div>		  			
		  			</div>
		  			<div class="form-group">
		  				<label>Member Since</label>
		  				<input type="text" class="form-control" readonly value="@formatDate($profile->date_register)">		  			
		  			</div>
		  		</div>
		  		<div class="d-flex d-row">
		  			<button class="btn btn-success mx-auto mb-2" @click="update({{ $profile->schoolId }})">Save Changes</button>
		  		</div>
		  	</div>
	  	</div>

	  	<div class="col-md-3"></div>
  	</div>
  </div>
@endsection

@push('schools-profile-scripts')
	<script src="{{ url('../resources/library/loadingoverlay2.1.6/loadingoverlay.min.js') }}"></script>
	<script src="{{ url('../resources/library/sweetalert2/sweetalert2.js') }}"></script>
	<script src="{{ url('../resources/library/vuejs/vue.js') }}"></script>
	<script src="{{ url('../resources/library/axios/axios.min.js') }}"></script>	
	<script type="module" src="{{ url('../resources/js/schools/profile.js') }}"></script>
@endpush
