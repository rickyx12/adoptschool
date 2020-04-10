@extends('main')

@section('single-project')
	
	@inject('updates', 'App\Library\Services\Updates')
	@inject('comments', 'App\Library\Services\Comment')
	@inject('projects', 'App\Library\Services\Projects')

	<div class="container-fluid mt-3">
	  <div class="row">
	  	<div class="col-md-1"></div>
	  	<div class="col-md-10">
			<div class="card">
			  <div class="card-body">
			  	<div class="row">
			  		<div class="col-md">
				  		<h4 style="font-size: 23px;">{{ $project[0]->sub_category }}</h4>
				  		<h6 class="text-muted">{{ $project[0]->school }}</h6>
				  		<hr>			  			
			  		</div>
			  	</div>
			  	<div class="row">
			  		<div class="col-md">
				  		<ul class="mt-3">
				  			<li style="font-size: 18px;"><span style="font-weight: 400;">Estimated Amount</span>: @money($project[0]->amount)</li>
				  			<li style="font-size: 18px;"><span style="font-weight: 400;">Quantity</span>: {{ $project[0]->qty }}</li>
				  			<li style="font-size: 18px;"><span style="font-weight: 400;">Implementation Date</span>: @formatDate($project[0]->implementation_date)</li>
				  			<li style="font-size: 18px;"><span style="font-weight: 400">Beneficiary Students</span>: {{ $project[0]->students_beneficiary }}</li>
				  			<li style="font-size: 18px;"><span style="font-weight: 400">Beneficiary Personnels</span>: {{ $project[0]->personnels_beneficiary }}</li>
				  			<li style="font-size: 18px;"><span style="font-weight: 400">Contact Person</span>: {{ $project[0]->accountable_person }}</li>
				  			<li style="font-size: 18px;"><span style="font-weight: 400">Contact#:</span> {{ $project[0]->contact_no }}</li>
				  			<li style="font-size: 18px;"><span style="font-weight: 400">School Year:</span> {{ $project[0]->school_year }}</li>
				  			<li>Stakeholders:
				  				<ul>
				  					@foreach($projects->getProjectStakeholders($project[0]->id) as $proj)
				  						<li>{{ ucwords($proj->name) }}</li>
				  					@endforeach
				  				</ul>
				  			</li>
				  		</ul>
		  			</div>
		  			<div class="col-md">
		  				<h5 class="lead">Project Description</h5>
				  		<div class="jumbotron">
				  			{{ $project[0]->description }}
				  		</div>


				  		<h6 class="lead">Project Progress</h6>
				  		<div class="progress">
							<div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
								25%
							</div>
						</div>			  				  				
		  			</div>
		  		</div>
		  		<div class="row mt-3">
		  			<div class="col-md">
		  				<h6>Updates</h6>

	      				@foreach($updates->getProjectUpdates($project[0]->id) as $update)
		      				<div class="row mb-n4">
		      					<div class="col-md">
									<div class="jumbotron jumbotron-fluid pt-1 pb-1">
										<div class="container">
									    	<h6 class="mb-0" style="font-size: 14px;">@formatDate($update->date_update)</h6>
									    	<span class="mt-0" style="font-size: 14px;">{{ $update->update_message }}</span>
										</div>
									</div>
								</div>
		      				</div>
	      				@endforeach		  				
		  			</div>
		  			<div class="col-md">
		  				<h6>Comments</h6>

	      				<div id="schoolComments">
		      				@foreach($comments->getComments($project[0]->id) as $comment)
			      				<div class="row mb-n4">
			      					<div class="col-md">
										<div class="jumbotron jumbotron-fluid pt-1 pb-1">
											<div class="container">
										    	<h6 class="mb-0" style="font-size: 14px;">
										    		{{ ucwords($comment->name) }}</h6>
										    	<span class="mt-0" style="font-size: 14px;">{{ $comment->comment }}</span>
											</div>
										</div>
									</div>
			      				</div>
		      				@endforeach
	      				</div>
	      				<div class="row">
	      					<div class="col-md">
	      						@if(Auth::guard('schools')->check() || Auth::guard('stakeholders')->check() || Auth::guard('admin')->check())
		      						<textarea id="commentField{{ $project[0]->id }}" class="form-control commentField" data-id="{{ $project[0]->id }}" cols="5" rows="2" placeholder="Write comment here then Press Enter."></textarea>
							        <div id="errorComment{{ $project[0]->id }}"></div>
							    @else
								    <small class="text-muted mr-2">
								      Login to comment.
								    </small>									    	
						        @endif
	      					</div>
	      				</div>		  				
		  			</div>
		  		</div>
			  </div>
			</div>	  		
	  	</div>
	  	<div class="col-md-1"></div>
	  </div>
	</div>
@endsection

@push('single-project-scripts')
	<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
    <script src="{{ url('../resources/js/singleProject.js') }}"></script>
@endpush