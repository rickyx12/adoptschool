import { BASE_URL } from '../baseUrl.js';

Vue.component('view-more-projects', {
	data() {
		return {
			approvedQty: 0,
			percentage: 0
		}
	},
	props:{
		project: Object,
		projectLink: String,
	},
	created() {
		this.approvedQTY(this.project.id)
	},
	computed:{
		getPercentage: function() {
			return Math.round(this.percentage);
		}
	},
	methods:{
		approvedQTY: function(projectId) {
			
			axios.get(`project/${projectId}/approved-qty`)
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
		
				<a :href="'${BASE_URL}/project/'+project.id" target="_blank" class="stretched-link mt-3 text-decoration-none mx-auto btn btn-sm btn-primary">View</a>			
		  </div>
			</div>
		</div>

  	`
})

new Vue({ 
	el: '#projectsGuest',
	data: function() 
	{
		return {
			offset: 3,
			rowCount: 3,
			projects:[]
		}
	},	
	methods: {
		viewMoreProjects: function() {

			let data = {
				offset: this.offset,
				rowCount: this.rowCount
			}

			$.LoadingOverlay('show');

			axios.post(`${BASE_URL}/projects/json`,data)
			.then((response) => {

				this.projects = this.projects.concat(response.data);
				this.offset += 3;
			})
			.catch((error) => {
				console.log(error)
			})
		}
	}		
})

// var projectsContainer = new Vue({
// 								el: '#projectsContainer',
// 								data: function()
// 								{
// 									return {
// 										showProjects: true,
// 										filteredProjects:[]
// 									}
// 								}
// 							});

// var filter = new Vue({ 
// 	el: '#filterDiv',
// 	data: function() 
// 	{
// 		return {
// 			fundSort:'',
// 			categorySort:[]
// 		}
// 	},	
// 	methods: {
// 		filterProjects: function() {

// 			let data = {
// 				fundSort: this.fundSort,
// 				categorySort: this.categorySort
// 			}

// 			axios.post(baseUrl+'/projects/filtered',data)
// 			.then((response) => {

// 				projectsContainer.filteredProjects = response.data
// 				// projectsContainer.showProjects = false;
// 				console.log(projectsContainer.filteredProjects);
// 			})
// 			.catch((error) => {
// 				console.log(error)
// 			})			
			
// 		}
// 	}
// })
