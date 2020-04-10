@extends('main')

@section('schools-projects')
  	<div id="projectsSchool" class="container">
	    <div class="row mb-3">
	      <div class="col-md-4 mt-3">
	      	<select v-model="projectFilter" @change="filterProjects" class="form-control">
	      		<option value="dateEncoded">Order by Date Encoded</option>
	      		<option value="implementationDate">Order by Implementation Date</option>
	      	</select>
	      </div>
	      <div class="col-md text-right mt-3">
	      	<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#newProjectModal"> <i class="fa fa-plus"></i> New Project</button>  
	      </div>
	    </div>
		<div class="row mt-3">
			<projects 
				v-for="project in projects" 
				:project="project"
				@delete="deleteProject(project.id)"
			></projects>
	  	</div>    
	  	<div class="row">
		  	<div class="col-md-5"></div>
		  	<div class="col-md-2">
		  		<button class="btn btn-sm btn-success mb-2 mx-auto" @click="viewMoreProjects">View More</button>
		  	</div>
		  	<div class="col-md-5"></div>
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
			      		<select v-model="needs" class="form-control" :class="errorNeedsMsgInvalid">
			      			@foreach($categories as $category)
			      				 <optgroup label="{{ strtoupper($category->name) }}">
			      				 	@foreach($categoryService->getSubCategory($category->id) as $subCategory)
			      				 		<option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
			      				 	@endforeach
			      				 </optgroup>
			      			@endforeach
			      		</select>
			      		<small class="form-text text-muted">Select from the list what your school needs.</small>
			      		<span v-if="errorNeeds" class="invalid-feedback" style="display: block;">@{{ errorNeedsMsg }}</span>
			      	</div>
			      	<div class="form-row mb-3">
			      		<div class="col-md-5">
			      			<label>Quantity</label>
			      			<input type="text" v-model="qty" class="form-control number-format" :class="errorQtyInvalid" autocomplete="off">
			      			<div v-if="errorQty" class="invalid-feedback">@{{ errorQtyMsg }}</div>
			      		</div>
			      	</div>
			      	<div class="form-row mb-3">
			      		<div class="col-md-6">
			      			<label>Estimated Amount</label>
			      			<input type="text" v-model="amount" class="form-control number-format" :class="errorAmountInvalid" autocomplete="off">
			      			<small class="form-text text-muted">Estimated Amount for this project.</small>
			      			<div v-if="errorAmount" class="invalid-feedback">@{{ errorAmountMsg }}</div>
			      		</div>
			      	</div>
			      	<div class="form-row mb-3">
			      		<div class="col-md-8">
			      			<label>Students Benificiary</label>
			      			<input type="text" v-model="studentsBeneficiary" class="form-control number-format" :class="errorStudentsBeneficiaryInvalid" autocomplete="off">
			      			<small class="form-text text-muted">How many students could benefit for this project.</small>
			      			<div v-if="errorStudentsBeneficiary" class="invalid-feedback">@{{ errorStudentsBeneficiaryMsg }}</div>
			      		</div>
			      	</div>
			      	<div class="form-row mb-3">
			      		<div class="col-md-8">
			      			<label>Personnel Benificiary</label>
			      			<input type="text" v-model="personnelsBeneficiary" class="form-control number-format" :class="errorPersonnelsBeneficiaryInvalid" autocomplete="off">
			      			<small class="form-text text-muted">How many personnels could benefit for this project.</small>
			      			<div v-if="errorPersonnelsBeneficiary" class="invalid-feedback">@{{ errorPersonnelsBeneficiaryMsg }}</div>
			      		</div>
			      	</div>
			      	<div class="form-row mb-3">
			      		<div class="col-md-7">
			      			<label>Implementation Date</label>
			      			<input type="text" id="implementationDate" class="form-control pickdate" :class="errorImplementationDateInvalid" />
			      			<div v-if="errorImplementationDate" class="invalid-feedback" style="display: block;">@{{ errorImplementationDateMsg }}</div>
			      		</div>
			      	</div>
			      	<div class="form-row mb-3">
			      		<div class="col-md">
			      			<label>Accountable Person</label>
			      			<input type="text" v-model="accountablePerson" class="form-control" :class="errorAccountablePersonInvalid" />
			      			<div v-if="errorAccountablePerson" class="invalid-feedback">@{{ errorAccountablePersonMsg }}</div>
			      		</div>
			      	</div>
			      	<div class="form-row mb-3">
			      		<div class="col-md">
			      			<label>Contact#:</label>
			      			<input type="text" v-model="contactNo" class="form-control" :class="errorContactNoInvalid" />
			      			<div v-if="errorContactNo" class="invalid-feedback">@{{ errorContactNoMsg }}</div>
			      		</div>
			      	</div>	      		      	
			      	<div class="form-row mb-3">
			      		<div class="col-md-5">
			      			<label>School Year</label>
			      			<select v-model="schoolYear" class="form-control" :class="errorSchoolYearInvalid">
			      				@foreach($schoolYear as $sy)
			      					<option value="{{ $sy->id }}">{{ $sy->school_year }}</option>
			      				@endforeach
			      			</select>
			      			<div v-if="errorSchoolYear" class="invalid-feedback">@{{ errorSchoolYearMsg }}</div>
			      		</div>
			      	</div>
			      	<div class="form-group">
			      		<label>Brief Description</label>
			      		<textarea v-model="description" class="form-control" :class="errorDescriptionInvalid" rows="5" cols=5></textarea>
			      		<div v-if="errorDescription" class="invalid-feedback">@{{ errorDescriptionMsg }}</div>
			      	</div>	      	
		      	</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="button" @click="newProject" class="btn btn-success">Add Project</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
@endsection

@push('schools-projects-scripts');
	<script src="{{ url('../resources/library/gijgo/dist/combined/js/gijgo.min.js') }}" type="text/javascript"></script>
	<link href="{{ url('../resources/library/gijgo/dist/combined/css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
	<script src="{{ url('../resources/library/loadingoverlay2.1.6/loadingoverlay.min.js') }}"></script>
	<script src="{{ url('../resources/library/sweetalert2/sweetalert2.js') }}"></script>
	<script src="{{ url('../resources/library/vuejs/vue.js') }}"></script>
	<script src="{{ url('../resources/library/axios/axios.min.js') }}"></script>	
	<script src="{{ url('../resources/library/cleavejs1.5.4/cleave.min.js') }}"></script>
	<script type="module" src="{{ url('../resources/js/schools/projects.js') }}"></script>
@endpush