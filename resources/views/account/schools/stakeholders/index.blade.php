@extends('main')

@section('schools-dashboard')
  <div class="container-fluid">
    
    <div class="row mt-3 ml-2">
		<h5 class="lead">Project Stakeholders</h5>    	
    </div>
    <div class="row">

      @foreach($projects as $project)
      	  
      	  @inject('stakeholder', 'App\Library\Services\Stakeholders')

	      <div class="col-md-4 mt-3">

	      	@if($project->approved == 0)
	      		<div class="card border border-danger">
	      	@else
				<div class="card">
			@endif  
			  <div class="card-body">
			    <h5 class="card-title">
			    	{{ ucwords($stakeholder->getInformation($project->stakeholder)[0]->name) }}  

			    	@if($project->approved == 0)
			    		<span class="text-danger ml-2" style="font-size: 11px;">(On Process)</span>
			    	@else
			    		<span class="text-muted">(@money(50000))</span>
			    	@endif

			    </h5>
			    <h6 class="card-subtitle mb-2 text-muted">{{ $project->sub_category }}</h6>
			    <ul>
			    	<li>Estimated Amount: @money($project->amount)</li>
			    	<li>Quantity: {{ $project->qty }}</li>
			    	<li>Implementation Date: @formatDate($project->implementation_date)</li>
			    	<li>No. of Beneficiary Students: {{ $project->students_beneficiary }}</li>
			    	<li>No. of Beneficiary Personnel: {{ $project->personnels_beneficiary }}</li>
			    	<li>S.Y {{ $project->school_year }}</li>
			    </ul>

			 	<div class="jumbotron">
			 		{{ $project->description }}
			 	</div>

			 	@if($project->approved == 0)
				 	<hr>
				 	<h5 class="lead mt-1">{{ ucwords($stakeholder->getInformation($project->stakeholder)[0]->name) }} Message</h5>
				 	<div class="jumbotron mb-0">
				 		{{ $project->message }}
				 	</div>
					<small class="form-text text-muted mb-2">
					  {{ ucwords($stakeholder->getInformation($project->stakeholder)[0]->name) }} wanted to be a stakeholder for this project. please expect a call from us for coordination.
					</small>
			 	@endif
			  </div>
			</div>

	      </div>
      @endforeach
    
    </div>
  </div>
@endsection