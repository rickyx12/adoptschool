@extends('main')

@section('admin-request')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md mt-3">
      	<h5>Stakeholders Requeest</h5>
      </div>
    </div>
    <div class="row">
      @foreach($projects as $project)
      	  
      	  @inject('stakeholder', 'App\Library\Services\Stakeholders')

	      <div id="requestContainer{{ $project->requestId }}" class="col-md-4 mt-3">
			<div class="card">
			  <div class="card-body d-flex flex-column">
			    <h5 class="card-title">
			    	{{ ucwords($stakeholder->getInformation($project->stakeholder)[0]->name) }}  
			    </h5>
			    <h6 class="card-subtitle mb-2 text-muted">{{ $project->stakeholder_contact }}</h6>
				<h6 class="lead mt-1" style="font-size: 15px;">@formatDate($project->date_application)</h6>	
			
				<ul>
					<li>{{ ucwords($project->sub_category) }}</li>
					<li>Est. Amount: @money($project->amount)</li>
					<li>{{ ucwords($project->school) }}</li>
				</ul>

			 	<div class="jumbotron mb-0">
			 		{{ $project->message }}
			 	</div>
		
			 	<button class="btn btn-sm btn-success mt-2 approveBtn mx-auto" data-id="{{ $project->requestId }}" data-toggle="modal" data-target="#approvedModal{{ $project->requestId }}">
			 		View
			 	</button>
			  	

			  </div>
			</div>

	      </div>

		<!-- Modal -->
		<div class="modal fade" id="approvedModal{{ $project->requestId }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Approve</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div id="approveModalBody{{ $project->requestId }}" class="modal-body">
		        <div class="container-fluid">
		        	<div class="row">
		        		<div class="col-md border-right">
		        			<h5>{{ ucwords($stakeholder->getInformation($project->stakeholder)[0]->name) }}</h5>
		        			<h6 class="card-subtitle mb-2 text-muted">{{ $project->stakeholder_contact }}</h6>
		        			<div class="jumbotron">
		        				{{ $project->message }}
		        			</div>
		        			<div class="form-group">
		        				<label>Monetary Value of Donation:</label>
		        				<input type="text" id="monetaryValue{{ $project->requestId }}" class="form-control number-format" autocomplete="off" />
		        				<div id="errorMonetaryValue{{ $project->requestId }}"></div>
		        			</div>
		        			<div class="form-group">
		        				<label>Quantity of Donation:</label>
		        				<input type="text" id="quantity{{ $project->requestId }}" class="form-control" autocomplete="off" />
		        				<div id="errorQuantity{{ $project->requestId }}"></div>
		        			</div>	
		        			<div class="form-group">
		        				<label>Referrence Document:</label>
		        				<input type="text" id="referrence{{ $project->requestId }}" class="form-control" autocomplete="off" />
								<small class="form-text text-muted">
								 	Any documents referencing to the donation like Check#. 
								</small>
								<div id="errorReferrence{{ $project->requestId }}"></div>		        				
		        			</div>
		        			<div class="form-group">
		        				<label>Date:</label>
		        				<input type="text" id="transactionDate{{ $project->requestId }}" class="form-control transactionDate" autocomplete="off" />
								<small class="form-text text-muted">
								 	Date when the transaction happen. 
								</small>
								<div id="errorTransactionDate{{ $project->requestId }}" style="display: block;"></div>		        				
		        			</div>		        						        				        			
		        		</div>
		        		<div class="col-md">
		        			<h5>{{ $project->school }}</h5>
		        			<h6 class="card-subtitle mb-2 text-muted">{{ $project->sub_category }}</h6>
		        			<ul>
		        				<li>Estimated Amoount: @money($project->amount)</li>
		        				<li>Quantity: {{ $project->qty }}</li>
		        				<li>Contact Person: {{ $project->accountable_person }}</li>
		        				<li>Contact No#: {{ $project->contact_no }}</li>
		        			</ul>
		        			<h6>Brief Description</h6>
		        			<div class="jumbotron">
		        				{{ $project->description }}
		        			</div>
		        		</div>
		        	</div>
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" id="cancelApproveBtn{{ $project->requestId }}" class="btn btn-danger" data-dismiss="modal">Close</button>
		        <button type="button" id="approveNowBtn{{ $project->requestId }}" class="btn btn-success">Approved</button>
		      </div>
		    </div>
		  </div>
		</div>

      @endforeach
    </div>
  </div>
@endsection

@push('admin-request-scripts')
	<script src="{{ url('../resources/library/gijgo/dist/combined/js/gijgo.min.js') }}" type="text/javascript"></script>
	<link href="{{ url('../resources/library/gijgo/dist/combined/css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
	<script src="{{ url('../resources/library/sweetalert2/sweetalert2.js') }}"></script>
	<script src="{{ url('../resources/library/loadingoverlay2.1.6/loadingoverlay.min.js') }}"></script>
	<script src="{{ url('../resources/library/cleavejs1.5.4/cleave.min.js') }}"></script>
	<script src="{{ url('../resources/js/admin/request.js') }}"></script>
@endpush