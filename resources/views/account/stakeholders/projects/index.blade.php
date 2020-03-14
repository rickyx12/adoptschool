@extends('main')

@section('stakeholders-projects')
  <div class="container-fluid">
    <div class="row mt-3">
      <div class="col-md-3 mb-3">
      	@if(Auth::guard('stakeholders')->guest() && Auth::guard('schools')->guest())
      		<form id="filterForm" method="GET" action="{{ url('/projects/filtered') }}">
      	@else
      		<form id="filterForm" method="GET" action="{{ url('/account/stakeholders/projects/filtered') }}">
      	@endif
      		@csrf
      		<input type="hidden" name="page" value="1">
			<div class="card">
			  <div class="card-header">
			    Filters
			  </div>
			  <div class="card-body">
			  	<ul class="list-unstyled">
			  		<li class="mb-2">
			  			<input type="radio" name="fundSort" value="low_high" /> <span class="" style="font-size:17px">Lowest amount to Highest</span>
			  		</li>
			  		<li class="mb-2">
			  			<input type="radio" name="fundSort" value="high_low" /> <span class="" style="font-size:17px">Highest amount to Lowest</span>
			  		</li>		  				  		
			  	</ul>
			  	<hr>
			  	<ul class="list-unstyled">
			  		@foreach($categories as $category)
			  		<li class="mb-2">
			  			<input type="checkbox" name="categorySort[]" value="{{ $category->id }}" /> <span class="" style="font-size:15px">{{ strtoupper($category->name) }}</span>
			  		</li>	
			  		@endforeach
			  	</ul>
			  </div>
			  <div class="card-footer text-center">
			  	<button id="filterBtn" class="btn btn-info btn"><i class="fa fa-search"></i> Filter</button>
			  </div>
			</div>
		</form>
      </div>
	  <div class="col-md-9">
	  	@foreach($projects as $project)
	  		
	  		@inject('comments', 'App\Library\Services\Comment')
	  		@inject('updates', 'App\Library\Services\Updates')

			<div id="projectCard{{ $project->id }}" class="card mb-3 ml-1 pb-0">
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
							<div class="mt-n5"> {{ $project->description }} </div>
						</div>
					</div>
				</div>
				<div class="row mt-0">
					<div class="col-md">
						<h4 class="lead">
							<a href="#" class="mr-2 text-decoration-none text-dark">2 Stakeholders</a> 
							<a href="#" class="text-decoration-none text-dark">{{ count($comments->getComments($project->id)) }} Comments</a></h4>
					</div>
					<div class="col-md text-right">

						@auth('stakeholders')
							<button 
								class="btn btn-success btn-sm applyBtn" 
								data-toggle="modal" 
								data-target="#applyStakeholderModal{{ $project->id }}"
								data-id="{{ $project->id }}"
							/>
								<i class="fa fa-hands-helping"></i> I want to be a Stakeholder
							</button>
						@endauth

						@guest('stakeholders')
						    <small class="text-muted mr-2">
						      Login to be a Stakeholder.
						    </small>
					    @endguest

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
	  
			<div id="viewModal{{$project->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewModal" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header pb-1">
			      		<h4 class="modal-title">{{ $project->sub_category }}</h4>

				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>			      		
			      </div>
			      <div class="modal-body">
			      	<div class="container-fluid">
			      		<div class="row pt-3">
			      			<div class="col-md">
			      				<ul class="list-unstyled">
			      					<li>
			      						<span class="lead" style="font-size: 17px">
			      							<b>Estimated Amount</b>: 
			      							@money($project->amount)
			      						</span>
			      					</li>
			      					<li>
			      						<span class="lead" style="font-size: 17px">
			      							<b>Quantity</b>:
			      							{{$project->qty}}
			      						</span>
			      					</li>
			      					<li>
			      						<span class="lead" style="font-size: 17px;">
			      							<b>Implementation Date</b>: 
			      							@formatDate($project->implementation_date)
			      						</span>
			      					</li>
			      					<li>
			      						<span class="lead" style="font-size: 17px;">
			      							<b>Beneficiary Students</b>: 
			      							{{ $project->students_beneficiary }} 
			      						</span>
			      					</li>
			      					<li>
			      						<span class="lead" style="font-size: 17px;">
			      							<b>Beneficiary Personnels</b>: 
			      							{{ $project->personnels_beneficiary }} 
			      						</span>
			      					</li>
			      					<li>
			      						<span class="lead" style="font-size: 17px;"><b>Contact Person</b>: 
			      							{{ $project->accountable_person }} </span>
			      					</li>
			      					<li>
			      						<span class="lead" style="font-size: 17px;">
			      							<b>Contact No</b>:
			      							{{ $project->contact_no }}
			      						</span>
			      					</li>
			      					<li>
			      						<span class="lead" style="font-size: 17px;">
			      							<b>School</b>:
			      							{{ $project->school }}
			      						</span>
			      					</li>
			      					<li>
			      						<span class="lead" style="font-size: 17px;">
			      							<b>Stakeholders</b>:
			      						</span>
			      					</li>
			      					<li>
			      						<ul>
			      							<li>Juan Dela Cruz</li>
			      							<li>Pedro Cruz</li>
			      						</ul>
			      					</li>			      					
			      				</ul>
			      			</div>
			      			<div class="col-md">
			      				<div class="jumbotron">
			      					<div class="mt-n5"> {{ $project->description }} </div>
			      				</div>
			      			</div>
			      		</div>
			      		<div class="row">
			      			<div class="col-md">
			      				<h6>Updates</h6>

			      				@foreach($updates->getProjectUpdates($project->id) as $update)
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

			      				<div id="stakeholdersComments">
				      				@foreach($comments->getComments($project->id) as $comment)
					      				<div class="row mb-n4">
					      					<div class="col-md">
												<div class="jumbotron jumbotron-fluid pt-1 pb-1">
													<div class="container">
												    	<h6 class="mb-0" style="font-size: 14px;">{{ ucwords($comment->name) }}</h6>
												    	<span class="mt-0" style="font-size: 14px;">{{ $comment->comment }}</span>
													</div>
												</div>
											</div>
					      				</div>
				      				@endforeach
			      				</div>
			      				<div class="row">
			      					<div class="col-md">
			      						@if(Auth::guard('stakeholders')->check())
				      						<textarea id="commentField{{ $project->id }}" class="form-control commentField" data-id="{{ $project->id }}" cols="5" rows="2" placeholder="Write comment here then Press Enter."></textarea>
									        <div id="errorComment{{ $project->id }}"></div>
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
			  </div>
			</div>


			<!-- Modal -->
			<div class="modal fade" id="applyStakeholderModal{{ $project->id }}" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Stakeholders Application</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <div class="container-fluid">
			        	<div class="row">
			        		<div class="col-md">
			        			<ul>
			        				<li>
			        					<span style="font-size: 17px;">{{ $project->sub_category }}</span>
			        				</li>
			        				<li>
			        					<span style="font-size: 17px;">Estimated Amount:  @money($project->amount)</span>
			        				</li>
			        				<li>
			        					<span style="font-size: 17px;">Quantity: {{ $project->qty }}</span>
			        				</li>
			        				<li>
			        					<span style="font-size: 17px;">Implementation Date: @formatDate($project->implementation_date)</span>
			        				</li>			        							        				
			        			</ul>
			        		</div>
			        	</div>
			        	<hr>
			        	<div class="row">
							<div class="col-md-7">
								<div class="form-group">
									<h6>Contact No#:</h6>
									<input id="stakeholdersContactNo{{ $project->id }}" type="text" class="form-control" />
									<small class="form-text text-muted">
									 	Our staff will be contacting you.
									</small>
									<div id="errorStakeholderContact{{ $project->id }}"></div>									
								</div>
							</div>			        		
			        	</div>
			        	<div class="row">
			        		<div class="col-md">
			        			<div class="form-group">
			        				<h6>Message <span style="font-size: 15px;">(Optional)</span></h6>
			        				<textarea id="stakeholdersMessage{{ $project->id }}" class="form-control" rows="5" cols="5"></textarea>
			        			</div>
			        		</div>
			        	</div>
			        </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" id="stakeholderCancerReqBtn{{ $project->id }}" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			        <button type="button" id="applyStakeholderBtn{{ $project->id }}" class="btn btn-success">Apply as Stakeholder</button>
			      </div>
			    </div>
			  </div>
			</div>

	  	@endforeach
		<div class="row">
			<div class="col"></div>
		  	<div class="col-auto">
		  		{{ $projects->links() }}
		  	</div>	
		</div>	  	
	  </div>
    </div>
  </div>
@endsection

@push('stakeholders-projects-scripts')
	<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	<script src="{{ url('../resources/js/stakeholders/projects.js') }}"></script>
@endpush
