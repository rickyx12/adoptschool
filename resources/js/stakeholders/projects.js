import { BASE_URL } from '../baseUrl.js';
import formatDate from '../formatDate.js';

var projectMixins = {
	data() {
		return {
			requestContactNo: '',
			requestStakeholdersMessage: ''
		}
	}
}

Vue.component('projects', {
	mixins:[projectMixins],
	data() {
		return {
			approvedQty: 0,
			percentage: 0			
		}
	},
	props:{
		project: Object,
		requestErrorContactNo: String,
		requestErrorContactNoMessage: String,
		requestErrorContactNoMessageShow: Boolean
	},
	filters: {
		formatDate
	},
	created() {
		this.approvedQTY(this.project.id)
	},
	computed:{
		getPercentage: function() {
			return Math.round(this.percentage);
		}
	},	
	methods: {
		sendRequest() {
			this.$emit('request');
		},
		getContactNo() {
			this.$emit('contactno', this.requestContactNo);
		},
		getMessage() {
			this.$emit('message', this.requestStakeholdersMessage);
		},
		approvedQTY: function(projectId) {
			
			axios.get(`${BASE_URL}/project/${projectId}/approved-qty`)
			.then((response) => {
				if(response.data[0].approvedQTY > 0) {

					let getPercentage = 0;

					this.approvedQty = response.data[0].approvedQTY;
					getPercentage = response.data[0].approvedQTY / this.project.qty;
					this.percentage = getPercentage * 100;

				}else {
					this.approvedQty = 0;
				}
			})
			.catch((error) => {
				console.log(error);
			})
			.finally(() => {
				$.LoadingOverlay('hide');
			})
		}		
	},		
  	template: `
  		
  		<div class="col-md-4 mb-3">
			<div :id="'projectCard'+project.id" class="card h-100">
		  <div class="card-body d-flex flex-column">
		  	<div class="row">
		  		<div class="col-md">
		  			<h5 class="card-title">{{ project.sub_category }}</h5>
		  			<h6 class="card-subtitle mb-2 text-muted">{{ project.school }}</h6>	
		  		</div>
		    </div>
		   
		    	
			    <ul>
			    	<li>
			    		<span class="lead" style="font-size: 16px;">
				    		<b>Estimated Amount</b>: 
				    		₱{{ project.amount.toLocaleString() }}
			    		</span>
			    	</li>
			    	<li>
			    		<span class="lead" style="font-size: 16px;">
			    			<b>Quantity</b>: 
			    			{{ project.qty }}
			    		</span>
			    	</li>
			    	<li>
			    		<span class="lead" style="font-size: 16px;">
			    			<b>No. of Beneficiary Students</b>: 
			    			{{ project.students_beneficiary }}
			    		</span>
			    	</li>
			    	<li>
			    		<span class="lead" style="font-size: 16px;">
			    			<b>No. of Beneficiary Personnels</b>: 
			    			{{ project.personnels_beneficiary }}
			    		</span>
			    	</li>
			    	<li>
			    		<span class="lead" style="font-size: 16px;">
			    			<b>Implementation Date</b>: 
			    			{{ project.implementation_date | formatDate }}
			    		</span>
			    	</li>
			    	<li>
			    		<span class="lead" style="font-size: 16px;">
			    			<b>Contact Person</b>: 
			    			{{ project.accountable_person }}
			    		</span>
			    	</li>
			    	<li>
			    		<span class="lead" style="font-size: 16px;">
			    			<b>Contact#</b>: 
			    			{{ project.contact_no }}
			    		</span>
			    	</li>
			    	<li v-if="project.fundedProject !== null && project.fundedProjectStatus === 1">
			    		<span class="text-success" style="font-size: 16px;">
			    			<b>You Contributed to this project</b>
			    		</span>
			    	</li>
			    	<li v-else-if="project.fundedProject !== null && project.fundedProjectStatus === 0">
			    		<span class="text-danger" style="font-size: 16px;">
			    			<b>You have Pending Request to this project </b>
			    		</span>
			    	</li>			    						    	
			    </ul>
				
				<div class="border-top my-3"></div>

					<p class="card-text" style="font-size: 16px;">
						{{ project.description }}
					</p>

					<div class="progress mt-auto">
					  <div class="progress-bar bg-success" role="progressbar" :style="'width:'+getPercentage+'%;'" :aria-valuenow="this.approvedQty" aria-valuemin="0" :aria-valuemax="project.qty">
					  	{{ this.approvedQty }} / {{ project.qty }}
					  </div>
					</div>

					<div class="d-flex d-row justify-content-center">
						<a href="#" 
							data-toggle="modal" 
							v-if="project.fundedProject === null"
							:data-target="'#applyStakeholderModal'+project.id" 
							class="mt-3 text-decoration-none mb-auto m-1 btn btn-sm btn-primary"
							title="Send request to become stakeholders of this project"
						>
							Send Request
						</a>	

						<a :href="'${BASE_URL}/project/'+project.id" target="_blank" class="mt-3 text-decoration-none mb-auto m-1 btn btn-sm btn-primary">View Project</a>			
			  		</div>													
		  		</div>
			</div>

			<div class="modal fade" v-if="project.fundedProject === null" :id="'applyStakeholderModal'+project.id" tabindex="-1" role="dialog" aria-hidden="true">
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
			        					<span style="font-size: 17px;">{{ project.sub_category }}</span>
			        				</li>
			        				<li>
			        					<span style="font-size: 17px;">Estimated Amount:  ₱{{ project.amount.toLocaleString() }}</span>
			        				</li>
			        				<li>
			        					<span style="font-size: 17px;">Quantity: {{ project.qty }}</span>
			        				</li>
			        				<li>
			        					<span style="font-size: 17px;">Implementation Date: {{ project.implementation_date | formatDate }}</span>
			        				</li>			        							        				
			        			</ul>
			        		</div>
			        	</div>
			        	<hr>
			        	<div class="row">
							<div class="col-md-7">
								<div class="form-group">
									<h6>Contact No#:</h6>
									<input v-model="requestContactNo" @keyup="getContactNo" type="text" class="form-control" :class="requestErrorContactNo" >
									<small class="form-text text-muted">
									 	Our staff will be contacting you.
									</small>
									<div class="invalid-feedback">{{ requestErrorContactNoMessage }}</div>								
								</div>
							</div>			        		
			        	</div>
			        	<div class="row">
			        		<div class="col-md">
			        			<div class="form-group">
			        				<h6>Message <span style="font-size: 15px;">(Optional)</span></h6>
			        				<textarea v-model="requestStakeholdersMessage" @keyup="getMessage" class="form-control" rows="5" cols="5"></textarea>
			        			</div>
			        		</div>
			        	</div>
			        </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			        <button type="button" class="btn btn-success" @click="sendRequest">Send Request</button>
			      </div>
			    </div>
			  </div>
			</div>

		</div>
  	`
})

new Vue({ 
	el: '#projectsStakeholders',
	mixins: [projectMixins],
	data: function() 
	{
		return {
			offset: 0,
			rowCount: 3,
			projects:[],
			requestErrorContactNo: '',
			requestErrorContactNoMessage: '',
			requestErrorContactNoMessageShow: false
		}
	},
	created() {

		$.LoadingOverlay('show');

		this.getProjects({offset: this.offset, rowCount: this.rowCount})
		.then((response) => {

			this.projects = response.data;
			this.offset += 3;
		})
		.catch((error) => {
			console.log(error)
		})
		.finally(() => {

			$.LoadingOverlay('hide');
		})
	},	
	methods: {
		getProjects: function(data) {

			return axios.post(`${BASE_URL}/account/stakeholders/projects/json`,data)
		},
		viewMoreProjects: function() {

			$.LoadingOverlay('show');

			this.getProjects({offset: this.offset, rowCount: this.rowCount})
			.then((response) => {

				this.projects = this.projects.concat(response.data);
				this.offset += 3;
			})
			.catch((error) => {
				console.log(error)
			})
			.finally(() => {

				$.LoadingOverlay('hide');
			})
		},
		sendRequest: function(projectId) {

			let data = {
				projectId: projectId,
				contactNo: this.requestContactNo,
				message: this.requestStakeholdersMessage
			}
			
			$.LoadingOverlay('show');

			axios.post(`${BASE_URL}/account/stakeholders/projects/stakeholders/add`, data)
			.then(() => {
			
				let data = {
					offset: 0,
					rowCount: this.offset
				}

				axios.post(`${BASE_URL}/account/stakeholders/projects/json`,data)
				.then((response) => {

					$('#applyStakeholderModal'+projectId).modal('hide');

					Swal.fire(
					  'Application Sent!',
					  'Thank you for helping our students. Expect a call from us shortly',
					  'success'
					)

					this.projects = response.data;					
				})
				.catch((error) => {
					
					console.log(error);
				})
				.finally(() => {

					$.LoadingOverlay('hide');
				})
			
			})
			.catch((error) => {

				$.LoadingOverlay('hide');

				this.requestErrorContactNo = 'is-invalid';
				this.requestErrorContactNoMessageShow = true;
				this.requestErrorContactNoMessage = error.response.data.errors.contactNo[0];

				console.log(this.requestErrorContactNoMessage+"\n"+this.requestErrorContactNo);
			})
		}		
	}		
})