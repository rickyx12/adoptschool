@extends('main')

@section('schools-projects')
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col-md text-right mt-3">
      	<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#newProjectModal"> <i class="fa fa-plus"></i> New Project</button>  
      </div>
    </div>
    <div class="row">
    	<div class="col-md-2"></div>
    	<div class="col-md-8">
    		@foreach($projects as $project)
				<div class="card mb-3">
				  <div class="card-body">
				  	<div class="row">
				  		<div class="col-md">
				  			<h5 class="card-title mb-2">{{ $project->sub_category }}</h5>
				  			<h6 class="card-subtitle mb-2 text-muted">{{ strtoupper($project->category) }}</h6>	
				  		</div>
				  		<div class="col-md text-right">
				  			<span class="lead">@money($project->amount)</span>
				  			<h6 class="card-subtitle mb-2 text-muted">@formatDate($project->implementation_date)</h6>
				  		</div>
				    </div>
				    <hr class="mt-0">
				    <div class="row">
				    	<div class="col-md">
						    <ul>
						    	<li>
						    		<span class="lead" style="font-size: 18px;">
						    			<b>Estimated Amount</b>: @money($project->amount)
						    		</span>
						    	</li>
						    	<li>
						    		<span class="lead" style="font-size: 18px;">
						    			<b>Quantity</b>: {{ $project->qty }}
						    		</span>
						    	</li>
						    	<li>
						    		<span class="lead" style="font-size: 18px;">
						    			<b>Implementation Date</b>: @formatDate($project->implementation_date)
						    		</span>
						    	</li>
						    	<li>
						    		<span class="lead" style="font-size: 18px;">
						    			<b>No. of Beneficiary Students</b>: {{ $project->students_beneficiary }}
						    		</span>
						    	</li>
						    	<li>
						    		<span class="lead" style="font-size: 18px;">
						    			<b>No. of Beneficiary Personnels</b>: {{ $project->personnels_beneficiary }}
						    		</span>
						    	</li>
						    	<li>
						    		<span class="lead" style="font-size: 18px;">
						    			<b>Contact Person</b>: {{ $project->accountable_person }}
						    		</span>
						    	</li>						    	
						    	<li>
						    		<span class="lead" style="font-size: 18px;">
						    			<b>School Year</b>: {{ $project->school_year }}
						    		</span>
						    	</li>
						    </ul>
						</div>
						<div class="col-md">
							<div class="jumbotron">
								<div class="mt-n5">{{ $project->description }}</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md text-right">
							<button class="btn btn-sm btn-info updateProjectBtn" data-project="{{ $project->id }}"" data-toggle="modal" data-target="#updateModal{{ $project->id }}"><i class="fa fa-plus"></i> New Updates</button>
						</div>
					</div>
				  </div>
				</div>

				<div class="modal fade" id="updateModal{{ $project->id }}" tabindex="-1" role="dialog" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">New Updates</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				        <div class="container-fluid">
				        	<div class="row">
				        		<ul>
				        			<li>
				        				<span class="lead" style="font-size: 17px;"><b>{{ $project->sub_category }}</b></span>
				        			</li>
				        			<li>
				        				<span class="lead" style="font-size: 17px;"><b>Estimated Amount</b>: @money($project->amount)</span>
				        			</li>	
				        			<li>
				        				<span class="lead" style="font-size: 17px;"><b>Quantity</b>: {{ $project->qty }}</span>
				        			</li>
				        			<li>
				        				<span class="lead" style="font-size: 17px;"><b>Implementation</b>: @formatDate($project->implementation_date)</span>
				        			</li>				        								        						        			
				        		</ul>
				        	</div>
				        	<div class="row mb-1">
								<div class="col-md">
									<hr>
				        			<h5 class="lead">Updates</h5>									
								</div>			        		
				        	</div>
				        	<div class="row">
				        		<div class="col-md-6">
				        			<div class="form-group">
				        				<input type="text" id="dateUpdate{{ $project->id }}" class="form-control" placeholder="Select Date">
										<small class="form-text text-muted">
										  Date when your Updates happen.
										</small>
										<div id="errorDateUpdate{{ $project->id }}" style="display: block;"></div>			        				
				        			</div>
				        		</div>
				        	</div>
				        	<div class="row">
								<div class="col-md">
				        			<div class="form-group">
				        				<textarea class="form-control" id="projectUpdate{{ $project->id }}" rows="5" cols="5" placeholder="Write your Updates here."></textarea>
										<small class="form-text text-muted">
										  Updates are important so the stakeholders can track the progress of the project.
										</small>
										<div id="errorProjectUpdate{{ $project->id }}"></div>				        			
				        			</div>									
								</div>				        		
				        	</div>
				        </div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				        <button type="button" id="saveUpdateBtn{{ $project->id }}" class="btn btn-success">Save</button>
				      </div>
				    </div>
				  </div>
				</div>

    		@endforeach
    	</div>
    	<div class="col-md-2"></div>
    </div>
  </div>

<!-- New Project Modal -->
<div class="modal fade" id="newProjectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	@inject('categoryService','App\Library\Services\Category')
      	<form>
	      	<div class="form-group">
	      		<label>Needs</label>
	      		<select id="needs" class="form-control">
	      			@foreach($categories as $category)
	      				 <optgroup label="{{ strtoupper($category->name) }}">
	      				 	@foreach($categoryService->getSubCategory($category->id) as $subCategory)
	      				 		<option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
	      				 	@endforeach
	      				 </optgroup>
	      			@endforeach
	      		</select>
	      		<small class="form-text text-muted">Select from the list what your school needs.</small>
	      		<span id="errorNeeds"></span>
	      	</div>
	      	<div class="form-row mb-3">
	      		<div class="col-md-5">
	      			<label>Quantity</label>
	      			<input type="text" id="qty" class="form-control number-format" autocomplete="off">
	      			<div id="errorQTY"></div>
	      		</div>
	      	</div>
	      	<div class="form-row mb-3">
	      		<div class="col-md-6">
	      			<label>Estimated Amount</label>
	      			<input type="text" id="amount" class="form-control number-format" autocomplete="off">
	      			<small class="form-text text-muted">Estimated Amount for this project.</small>
	      			<div id="errorAmount"></div>
	      		</div>
	      	</div>
	      	<div class="form-row mb-3">
	      		<div class="col-md-8">
	      			<label>Students Benificiary</label>
	      			<input type="text" id="studentsBeneficiary" class="form-control number-format" autocomplete="off">
	      			<small class="form-text text-muted">How many students could benefit for this project.</small>
	      			<div id="errorStudentsBeneficiary"></div>
	      		</div>
	      	</div>
	      	<div class="form-row mb-3">
	      		<div class="col-md-8">
	      			<label>Personnel Benificiary</label>
	      			<input type="text" id="personnelsBeneficiary" class="form-control number-format" autocomplete="off">
	      			<small class="form-text text-muted">How many personnels could benefit for this project.</small>
	      			<div id="errorPersonnelsBeneficiary"></div>
	      		</div>
	      	</div>
	      	<div class="form-row mb-3">
	      		<div class="col-md-5">
	      			<label>Implementation Date</label>
	      			<input type="text" id="implementationDate" class="form-control pickdate" />
	      			<div id="errorImplementationDate"></div>
	      		</div>
	      	</div>
	      	<div class="form-row mb-3">
	      		<div class="col-md">
	      			<label>Accountable Person</label>
	      			<input type="text" id="accountablePerson" class="form-control" />
	      			<div id="errorAccountablePerson"></div>
	      		</div>
	      	</div>
	      	<div class="form-row mb-3">
	      		<div class="col-md">
	      			<label>Contact#:</label>
	      			<input type="text" id="contactNo" class="form-control" />
	      			<div id="errorContactNo"></div>
	      		</div>
	      	</div>	      		      	
	      	<div class="form-row mb-3">
	      		<div class="col-md-5">
	      			<label>School Year</label>
	      			<select id="schoolYear" class="form-control">
	      				@foreach($schoolYear as $sy)
	      					<option value="{{ $sy->id }}">{{ $sy->school_year }}</option>
	      				@endforeach
	      			</select>
	      		</div>
	      	</div>
	      	<div class="form-group">
	      		<label>Brief Description</label>
	      		<textarea id="description" class="form-control" rows="5" cols=5></textarea>
	      		<div id="errorDescription"></div>
	      	</div>	      	
      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="addProjectBtn" class="btn btn-success">Add Project</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('schools-projects-scripts');
	<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
	<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.4/cleave.min.js"></script>
	<script src="{{ url('../resources/js/schools/projects.js') }}"></script>
@endpush