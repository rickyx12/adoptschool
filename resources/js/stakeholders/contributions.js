import { BASE_URL } from '../baseUrl.js';
import formatDate from '../formatDate.js';

Vue.component('contributions', {
	data() {
		return {
			approvedQty: 0,
			percentage: 0			
		}
	},
	props:{
		project: Object
	},
	filters: {
		formatDate
	},
	created() {
		this.approvedQTY(this.project.projectId)
	},
	computed:{
		getPercentage: function() {
			return Math.round(this.percentage);
		}
	},	
	methods: {
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
		},
		cancelContribution() {
			this.$emit('cancel');
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
				    		<b>Contribution</b>: 
				    		₱{{ project.monetary_value_donation.toLocaleString() }}
			    		</span>
			    	</li>
			    	<li>
			    		<span class="lead" style="font-size: 16px;">
				    		<b>Quantity</b>: 
				    		{{ project.quantity_donation }} / {{ project.qty }}
			    		</span>
			    	</li>
			    	
			    	<li>
			    		<span class="lead" style="font-size: 16px;">
				    		<b>Application</b>: 
				    		{{ project.date_application | formatDate }}
			    		</span>
			    	</li>

			    	<li v-if="project.transaction_date">
			    		<span class="lead" style="font-size: 16px;">
				    		<b>Approved</b>: 
				    		{{ project.transaction_date | formatDate }}
			    		</span>
			    	</li>

			    	<li v-else>
			    		<span class="lead" style="font-size: 16px;">
				    		<b>Approved</b>: 
				    		<b class="text-danger">Pending</b>
			    		</span>
			    	</li>


			    	<li v-if="project.approved_by">
			    		<span class="lead" style="font-size: 16px;">
				    		<b>Approved By:</b>: 
				    		{{ project.approved_by }}
			    		</span>
			    	</li>			    				    				    				    						    	
			    </ul>
				
				<div class="border-top my-3"></div>

					<div class="progress mt-auto">
					  <div class="progress-bar bg-success" role="progressbar" :style="'width:'+getPercentage+'%;'" :aria-valuenow="this.approvedQty" aria-valuemin="0" :aria-valuemax="project.qty">
					  	{{ this.approvedQty }} / {{ project.qty }}
					  </div>
					</div>
					<div class="d-flex d-row justify-content-center">
						<a :href="'${BASE_URL}/project/'+project.projectId" target="_blank" class="mt-3 text-decoration-none mb-auto m-1 btn btn-sm btn-primary">
							View
						</a>

						<a v-if="project.approved == 0" href="#" data-toggle="modal" :data-target="'#cancelModal'+project.contributionId" class="mt-3 text-decoration-none mb-auto m-1 btn btn-sm btn-danger">
							Cancel
						</a>


						<div class="modal fade" v-if="project.approved == 0" :id="'cancelModal'+project.contributionId" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Cancel Request</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						        Are you sure want to cancel the request for contribution:
						        <ul class="mt-2">
						        	<li>
						        		{{ project.school }}
						        	</li>
						        	<li>
						        		{{ project.sub_category }}
						        	</li>
						        	<li>
						        		Date Application: {{ project.date_application | formatDate }}
						        	</li>
						        </ul>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						        <button type="button" class="btn btn-danger" @click="cancelContribution">Cancel Contribution</button>
						      </div>
						    </div>
						  </div>
						</div>


		  			</div>
		  		</div>
			</div>

		</div>
  	`
})

new Vue({ 
	el: '#contributionsStakeholders',
	data: function() 
	{
		return {
			offset: 0,
			rowCount: 3,
			projects:[]
		}
	},
	created() {

		this.getContributions({offset: this.offset, rowCount: this.rowCount})
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
		getContributions: function(data) {

			$.LoadingOverlay('show');
			return axios.post(`${BASE_URL}/account/stakeholders/contributions/json`,data)
		},
		viewMoreContributions: function() {

			this.getContributions({offset: this.offset, rowCount: this.rowCount})
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
		cancelContribution: function(contributionId) {

			let data = {
				contributionId: contributionId
			}

			$.LoadingOverlay('show');

			axios.post(`${BASE_URL}/account/stakeholders/contributions/cancel`,data)
			.then((response) => {

				// $('#cancelModal'+contributionId).modal('toggle');
				// $.LoadingOverlay('hide');

				this.getContributions({offset: this.offset, rowCount: this.rowCount})
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
			})
			.catch((error) => {
				console.log(error);
			})
			.finally(() => {
				$('#cancelModal'+contributionId).modal('toggle');
				$.LoadingOverlay('hide');
			})
		}	
	}		
})
