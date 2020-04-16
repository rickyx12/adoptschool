@extends('main')

@section('stakeholders-contributions')
  <div id="contributionsStakeholders" class="container">
  		<div class="row mt-3">
  			<contributions 
	  			v-for="project in projects" 
	  			:project="project"
  				@cancel="cancelContribution(project.contributionId)"
  			>
  			</contributions>
	  	</div>
	  	<div class="row">
		  	<div class="col-md-5"></div>
		  	<div class="col-md-2">
		  		<button class="btn btn-sm btn-success mb-2 mx-auto" @click="viewMoreContributions">View More</button>
		  	</div>
		  	<div class="col-md-5"></div>
  		</div>
  </div>
@endsection

@push('stakeholders-contributions-scripts')
	<script src="{{ url('../resources/library/loadingoverlay2.1.6/loadingoverlay.min.js') }}"></script>
	<script src="{{ url('../resources/library/sweetalert2/sweetalert2.js') }}"></script>
	<script src="{{ url('../resources/library/vuejs/vue.js') }}"></script>
	<script src="{{ url('../resources/library/axios/axios.min.js') }}"></script>	
	<script type="module" src="{{ url('../resources/js/stakeholders/contributions.js') }}"></script>
@endpush
