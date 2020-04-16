@extends('main')

@section('schools-stakeholders')
  	<div id="stakeholdersSchool" class="container">
		<div class="row mt-3">
			<stakeholders 
				v-for="stakeholder in stakeholders" 
				:stakeholders="stakeholder"
			></stakeholders>
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

@push('schools-stakeholders-scripts');
	<script src="{{ url('../resources/library/gijgo/dist/combined/js/gijgo.min.js') }}" type="text/javascript"></script>
	<link href="{{ url('../resources/library/gijgo/dist/combined/css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
	<script src="{{ url('../resources/library/loadingoverlay2.1.6/loadingoverlay.min.js') }}"></script>
	<script src="{{ url('../resources/library/sweetalert2/sweetalert2.js') }}"></script>
	<script src="{{ url('../resources/library/vuejs/vue.js') }}"></script>
	<script src="{{ url('../resources/library/axios/axios.min.js') }}"></script>	
	<script src="{{ url('../resources/library/cleavejs1.5.4/cleave.min.js') }}"></script>
	<script type="module" src="{{ url('../resources/js/schools/stakeholders.js') }}"></script>
@endpush