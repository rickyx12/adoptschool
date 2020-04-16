@extends('main')

@section('stakeholders-profile')
  <div id="stakeholdersProfile" class="container">
  	<div class="row">
	  	<div class="col-md-3"></div>

	  	<div class="col-md-6">
		  	<div class="card mt-4">
		  		<div class="card-body d-flex flex-column">
		  			<div class="form-group">
		  				<label>Email</label>
		  				<input type="text" class="form-control" value="{{ $stakeholder->email }}" readonly="readonly" />
		  			</div>
		  			<div class="form-group">
		  				<label>Name</label>
		  				<input type="text" id="name" class="form-control" value="{{ $stakeholder->name }}" :class="errorNameClass" autocomplete="off" />
				        <div v-if="errorName" class="invalid-feedback" style="display: block;">
				          @{{ errorNameMsg }}
				        </div>		  				
		  			</div>
		  			<div class="form-group">
		  				<label>Sector</label>
		  				<select id="sector" class="form-control" @change="getSubSector">
		  					<option value="{{ $stakeholder->sectorId }}">{{ $stakeholder->sector }}</option>
							@foreach($sectors as $sector)
								<option value="{{ $sector->id }}">{{ $sector->sector }}</option>
							@endforeach
		  				</select>
		  			</div>
		  			<div class="form-group">
		  				<label>Sub Sector</label>
		  				<select id="subSector" class="form-control">
		  					<option value="{{ $stakeholder->subsectorId }}">{{ $stakeholder->subsector }}</option>
		  					<option v-for="subsector in subsectors" :value="subsector.id">
		  						@{{ subsector.name }}
		  					</option>
		  				</select>
		  			</div>
		  			<div class="form-group">
		  				<label>Member Since</label>
		  				<input type="text" class="form-control" value="{{ $stakeholder->date_register }}" readonly="readonly" />
		  			</div>
		  		
		  			<button class="btn btn-success mx-auto" @click="save({{ $stakeholder->stakeholderId }})">Save Changes</button>
		  			
		  		</div>
		  	</div>
	  	</div>

	  	<div class="col-md-3"></div>
  	</div>
  </div>
@endsection

@push('stakeholders-profile-scripts')
	<script src="{{ url('../resources/library/loadingoverlay2.1.6/loadingoverlay.min.js') }}"></script>
	<script src="{{ url('../resources/library/sweetalert2/sweetalert2.js') }}"></script>
	<script src="{{ url('../resources/library/vuejs/vue.js') }}"></script>
	<script src="{{ url('../resources/library/axios/axios.min.js') }}"></script>	
	<script type="module" src="{{ url('../resources/js/stakeholders/profile.js') }}"></script>
@endpush
