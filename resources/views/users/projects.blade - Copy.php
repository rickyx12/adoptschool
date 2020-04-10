@extends('main')

@section('stakeholders-projects')
  <div id="projectsGuest" class="container-fluid">
    <div class="row mt-3">
      <div class="col-md-3 mb-3">
			<div class="card">
			  <div class="card-header">
			    Filters
			  </div>
			  <div class="card-body">
			  	<ul class="list-unstyled">
			  		<li class="mb-2">
			  			<input type="radio"	name="fundSort" value="low_high" /> <span class="" style="font-size:17px">Lowest amount to Highest</span>
			  		</li>
			  		<li class="mb-2">
			  			<input type="radio" name="fundSort" value="high_low" /> <span class="" style="font-size:17px">Highest amount to Lowest</span>
			  		</li>		  				  		
			  	</ul>
			  	<hr>
			  	<ul class="list-unstyled">
			  		@foreach($categories as $category)
			  		<li class="mb-2">
			  			<input type="checkbox" name="categorySort" value="{{ $category->id }}" /> <span class="" style="font-size:15px">{{ strtoupper($category->name) }}</span>
			  		</li>	
			  		@endforeach
			  	</ul>
			  </div>
			  <div class="card-footer text-center">
			  	<button id="filterBtn" class="btn btn-info btn" @click="filterProjects"><i class="fa fa-search"></i> Filter</button>
			  </div>
			</div>
		</form>
      </div>
	  <div id="projectsContainer" class="col-md-9">
	  	@foreach($projects as $project)
	  		
	  		@inject('comments', 'App\Library\Services\Comment')
	  		@inject('updates', 'App\Library\Services\Updates')

			<div id="projectCard{{ $project->id }}" class="card mb-3 ml-1 pb-0" v-if="showProjects">
			  <div class="card-body">
			  	<div class="row">
			  		<div class="col-md">
			  			<h5 class="card-title mb-2">{{ $project->sub_category }}</h5>
			  			<h6 class="card-subtitle mb-2 text-muted">{{ strtoupper($project->school) }}</h6>	
			  		</div>
			  		<div class="col-md text-right">
			  			<span class="lead">@money($project->amount)</span>
			  		</div>
			    </div>
			    <hr class="mt-0">
			    <div class="row">
			    	<div class="col-md">
					    <ul>
					    	<li>
					    		<span class="lead" style="font-size: 18px;">
						    		<b>Estimated Amount</b>: 
						    		@money($project->amount)
					    		</span>
					    	</li>
					    	<li>
					    		<span class="lead" style="font-size: 18px;">
					    			<b>Quantity</b>: 
					    			{{ $project->qty }}
					    		</span>
					    	</li>
					    	<li>
					    		<span class="lead" style="font-size: 18px;">
					    			<b>No. of Beneficiary Students</b>: 
					    			{{ $project->students_beneficiary }}
					    		</span>
					    	</li>
					    	<li>
					    		<span class="lead" style="font-size: 18px;">
					    			<b>No. of Beneficiary Personnels</b>: 
					    			{{ $project->personnels_beneficiary }}
					    		</span>
					    	</li>
					    	<li>
					    		<span class="lead" style="font-size: 18px;">
					    			<b>Contact Person</b>: 
					    			{{ $project->accountable_person }}
					    		</span>
					    	</li>
					    	<li>
					    		<span class="lead" style="font-size: 18px;">
					    			<b>Contact#</b>: 
					    			{{ $project->contact_no }}
					    		</span>
					    	</li>					    	
					    </ul>
					</div>
					<div class="col-md">
						<div class="jumbotron">
							<div> {{ $project->description }} </div>
						</div>
					</div>
				</div>
				<div class="row mt-0">
					<div class="col-md">
						<h4 class="lead">
							<a href="#" class="mr-2 text-decoration-none text-dark">2 Stakeholders</a> 
							<a href="#" data-toggle="modal" data-target="#viewModal{{ $project->id }}" class="text-decoration-none text-dark">{{ count($comments->getComments($project->id)) }} Comments</a>
						</h4>
					</div>
					<div class="col-md text-right">

						<small class="text-muted mr-2">
						    Login to be a Stakeholder.
						</small>
					   

						<button 
							class="openModalBtn btn btn-primary btn-sm" 
							data-toggle="modal" 
							data-target="#viewModal{{$project->id}}"
						>
							<i class="fa fa-list"></i> View
						</button>
					</div>
				</div>
			  </div>
			</div>
			
			<view-project-modal 
				:key="{{ $project->id }}"
				modal_id="{{ 'viewModal'.$project->id }}"
				sub_category="{{ $project->sub_category }}"
				amount="{{ $project->amount }}"
				qty="{{ $project->qty }}"
				implementation_date="{{ $project->implementation_date }}"
				students_beneficiary="{{ $project->students_beneficiary }}"
				personnels_beneficiary="{{ $project->personnels_beneficiary }}"
				contact_person="{{ $project->accountable_person }}"
				contact_no="{{ $project->contact_no }}"
				school="{{ $project->school }}"
				description="{{ $project->description }}"
			>
					
			</view-project-modal>

	  	@endforeach
	  		<div class="row">
	  			<view-more-projects 
		  			v-for="project in projects" 
		  			:project="project"
	  			></view-more-projects>
		  	</div>
		  	<div class="row">
			  	<div class="col-md-4"></div>
			  	<div class="col-md-4">
			  		<button class="btn btn-success mb-2" v-if="btnVisible" @click="viewMoreProjects">View More Projects</button>
			  	</div>
			  	<div class="col-md-4"></div>
	  		</div>
	  </div>
    </div>
  </div>
@endsection

@push('stakeholders-projects-scripts')
	<script src="{{ url('../resources/library/loadingoverlay2.1.6/loadingoverlay.min.js') }}"></script>
	<script src="{{ url('../resources/library/sweetalert2/sweetalert2.js') }}"></script>
	<script src="{{ url('../resources/library/vuejs/vue.js') }}"></script>
	<script src="{{ url('../resources/library/axios/axios.min.js') }}"></script>
	<script src="{{ url('../resources/js/stakeholders/projects.js') }}"></script>
	<script src="{{ url('../resources/js/guest/projects.js') }}"></script>
@endpush
