@extends('main')

@section('single-project')
	
	@inject('updates', 'App\Library\Services\Updates')
	@inject('comments', 'App\Library\Services\Comment')
	@inject('projects', 'App\Library\Services\Projects')

	<div class="container-fluid mt-3">
	  <div class="row">
	  	<div class="col-md-2"></div>
	  	<div class="col-md-8">
			<div class="card">
			  <div class="card-body">
			  	<div class="row">
			  		<div class="col-md">
				  		<h4 class="card-title">{{ $project[0]->sub_category }}</h4>
				  		<h6 class="card-subtitle text-muted">{{ $project[0]->school }}</h6>			  			
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
		  			</div>
		  		</div>
		  		<div class="row">
		  			<div class="col-md mt-2">
	
				  		<h6 class="lead">Project Progress</h6>
				  		<div class="progress">

				  			<?php

				  				$approvedQTY = $projects->getTotalApprovedQty($project[0]->id)[0]->approvedQTY;
				  				$percentage = $approvedQTY / $project[0]->qty;
				  				$percentageVal = $percentage * 100;
				  			?>

							<div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentageVal }}%;" aria-valuenow="{{ $approvedQTY }}" aria-valuemin="0" aria-valuemax="{{ $project[0]->qty }}">
								{{ $approvedQTY }} / {{ $project[0]->qty }}
							</div>
						</div>	  				
		  			</div>
		  			<div id="comments" class="col-md mt-2">

		  				<h6>Comments</h6>

	      				<div v-if="latestComments" id="schoolComments">
		      				@foreach($comments->getComments($project[0]->id) as $comment)
			      				<div class="row mb-n4">
			      					<div class="col-md">
										<div class="jumbotron jumbotron-fluid pt-1 pb-1">
											<div class="container">
										    	<span class="font-weight-bold" style="font-size: 14px;">
										    		{{ ucwords($comment->name) }}
										    	</span>
										    	<span class="ml-1" style="font-size:12px;">
										    		
										    		<?php
										    			$date = explode(" ", $comment->date_added)
										    		?>

										    		(@formatDate($date[0]))
				
										    	</span>
										    	<br>										    	
										    	<span class="mt-0" style="font-size: 14px;">{{ $comment->comment }}</span>
											</div>
										</div>
									</div>
			      				</div>
		      				@endforeach
	      				</div>

	      				<div v-if="allComments">
	      					<all-comments
	      						v-for="comment in comments"
	      						:key="comment.id"
	      						:name="comment.name"
	      						:comment="comment.comment"
	      						:date="comment.date_added"
	      					></all-comments>
	      				</div>

	      				<div class="row">
	      					<div class="col-md">
	      						<a href="#" v-if="latestComments" @click.prevent="getAllComments({{ $project[0]->id }})" class="text-decoration-none" style="font-size: 13px;">View more comments</a>
	      						@if(Auth::guard('schools')->check() || Auth::guard('stakeholders')->check() || Auth::guard('admin')->check())
		      						<textarea @keyup.13="addComment({{ $project[0]->id }})" v-model="userComment" class="form-control commentField" cols="5" rows="2" placeholder="Write comment here then Press Enter."></textarea>
							        <div id="errorComment{{ $project[0]->id }}"></div>
							    @else
							    	<br>
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
	  	<div class="col-md-2"></div>
	  </div>
	</div>
@endsection

@push('single-project-scripts')
	<script src="{{ url('../resources/library/vuejs/vue.js') }}"></script>
	<script src="{{ url('../resources/library/axios/axios.min.js') }}"></script>
	<script src="{{ url('../resources/library/loadingoverlay2.1.6/loadingoverlay.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/singleProject.js') }}"></script>
@endpush