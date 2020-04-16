@extends('main')

@section('stakeholders-projects')
  <div id="projectsStakeholders" class="container">
  		<div class="row mt-3">
  			<projects 
	  			v-for="project in projects" 
	  			:project="project"
	  			:request-error-contact-no="requestErrorContactNo"
	  			:request-error-contact-no-message="requestErrorContactNoMessage"
	  			:request-error-contact-no-show="requestErrorContactNoMessageShow"
	  			@contactno="requestContactNo = $event"
	  			@message="requestStakeholdersMessage = $event"
	  			@request="sendRequest(project.id)"
  			></projects>
	  	</div>
	  	<div class="row">
		  	<div class="col-md-5"></div>
		  	<div class="col-md-2">
		  		<button class="btn btn-sm btn-success mb-2 mx-auto" @click="viewMoreProjects">View More</button>
		  	</div>
		  	<div class="col-md-5"></div>
  		</div>
  </div>
@endsection

@push('stakeholders-projects-scripts')
	<script src="{{ url('../resources/library/loadingoverlay2.1.6/loadingoverlay.min.js') }}"></script>
	<script src="{{ url('../resources/library/sweetalert2/sweetalert2.js') }}"></script>
	<script src="{{ url('../resources/library/vuejs/vue.js') }}"></script>
	<script src="{{ url('../resources/library/axios/axios.min.js') }}"></script>	
	<script type="module" src="{{ url('../resources/js/stakeholders/projects.js') }}"></script>
@endpush
