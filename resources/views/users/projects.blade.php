@extends('main')

@section('guest-projects')
  <div id="projectsGuest" class="container">
    <div class="row mt-3">
	  	@foreach($projects as $project)
		
			@inject('projects', 'App\Library\Services\Projects')	  	
	  	
	  		<div class="col-md-4 mb-3">
				<div id="projectCard{{ $project->id }}" class="card h-100">
			  <div class="card-body d-flex flex-column">
			  	<div class="row">
			  		<div class="col-md">
			  			<h5 class="card-title">{{ $project->sub_category }}</h5>
			  			<h6 class="card-subtitle mb-2 text-muted">{{ ucwords($project->school) }}</h6>	
			  		</div>
			    </div>
				    <ul>
				    	<li>
				    		<span class="lead" style="font-size: 16px;">
					    		<b>Estimated Amount</b>: 
					    		@money($project->amount)
				    		</span>
				    	</li>
				    	<li>
				    		<span class="lead" style="font-size: 16px;">
				    			<b>Quantity</b>: 
				    			{{ $project->qty }}
				    		</span>
				    	</li>
				    	<li>
				    		<span class="lead" style="font-size: 16px;">
				    			<b>No. of Beneficiary Students</b>: 
				    			{{ $project->students_beneficiary }}
				    		</span>
				    	</li>
				    	<li>
				    		<span class="lead" style="font-size: 16px;">
				    			<b>No. of Beneficiary Personnels</b>: 
				    			{{ $project->personnels_beneficiary }}
				    		</span>
				    	</li>
				    	<li>
				    		<span class="lead" style="font-size: 16px;">
				    			<b>Contact Person</b>: 
				    			{{ $project->accountable_person }}
				    		</span>
				    	</li>
				    	<li>
				    		<span class="lead" style="font-size: 16px;">
				    			<b>Contact#</b>: 
				    			{{ $project->contact_no }}
				    		</span>
				    	</li>					    	
				    </ul>
					
					<div class="border-top my-3"></div>

					<p class="card-text" style="font-size: 16px;">
						{{ $project->description }}
					</p>

					<div class="progress mt-auto">

			  			<?php

			  				$approvedQTY = $projects->getTotalApprovedQty($project->id)[0]->approvedQTY;
			  				$percentage = $approvedQTY / $project->qty;
			  				$percentageVal = $percentage * 100;
			  			?>

					  <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentageVal }}%;" aria-valuenow="{{ $approvedQTY }}" aria-valuemin="0" aria-valuemax="{{ $project->qty }}">
					  	{{ $approvedQTY }} / {{ $project->qty }}
					  </div>
					</div>					
			
					<a href="{{ url('/project/'.$project->id) }}" target="_blank" class="stretched-link mt-3 text-decoration-none mx-auto btn btn-sm btn-primary">View</a>			
			  </div>
				</div>
			</div>
	  	@endforeach
  		</div>
  		<div class="row mt-3">
  			<view-more-projects 
	  			v-for="project in projects" 
	  			:project="project"
  			></view-more-projects>
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

@push('guest-projects-scripts')
	<script src="{{ url('../resources/library/loadingoverlay2.1.6/loadingoverlay.min.js') }}"></script>
	<script src="{{ url('../resources/library/sweetalert2/sweetalert2.js') }}"></script>
	<script src="{{ url('../resources/library/vuejs/vue.js') }}"></script>
	<script src="{{ url('../resources/library/axios/axios.min.js') }}"></script>
	<script type="module" src="{{ url('../resources/js/guest/projects.js') }}"></script>
@endpush
