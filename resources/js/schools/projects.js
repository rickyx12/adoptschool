import formatDate from '../formatDate.js';
import { BASE_URL } from '../baseUrl.js';

var newProjectMixin = {
	data() {
		return {
			errorNeeds: false,
			errorNeedsMsg: '',
			errorNeedsMsgInvalid: '',
			errorQty: false,
			errorQtyMsg: '',
			errorQtyInvalid: '',
			errorAmount: false,
			errorAmountMsg: '',
			errorAmountInvalid: '',
			errorStudentsBeneficiary: false,
			errorStudentsBeneficiaryMsg: '',
			errorStudentsBeneficiaryInvalid: '',
			errorPersonnelsBeneficiary: false,
			errorPersonnelsBeneficiaryMsg: '',
			errorPersonnelsBeneficiaryInvalid: '',
			errorImplementationDate: false,
			errorImplementationDateMsg: '',
			errorImplementationDateInvalid: '',
			errorAccountablePerson: false,
			errorAccountablePersonMsg: '',
			errorAccountablePersonInvalid: '',
			errorContactNo: false,
			errorContactNoMsg: '',
			errorContactNoInvalid: '',
			errorSchoolYear: false,
			errorSchoolYearMsg: '',
			errorSchoolYearInvalid: '',
			errorDescription: false,
			errorDescriptionMsg: '',
			errorDescriptionInvalid: ''
		}
	}
}

Vue.component('projects',{
	props: {
		project: Object
	},
	data() {
		return {
			approvedQty: 0,
			percentage: 0			
		}
	},
	created() {
		this.approvedQTY(this.project.id)
	},
	filters:{
		formatDate
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
			.finally(() => {
				$.LoadingOverlay('hide');
			})
		},
		deleteProject() {
			this.$emit('delete')
		}				
	},
	template:`

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
					    	<li>
					    		<span class="lead" style="font-size: 16px;">
					    			<b>Date Encoded</b>: 
					    			{{ project.date_added | formatDate }}
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
							<a :href="'${BASE_URL}/project/'+project.id" target="_blank" class="mt-3 text-decoration-none mb-auto m-1 btn btn-sm btn-primary">
								View
							</a>
							<a href="#" data-toggle="modal" :data-target="'#deleteModal'+project.id" class="mt-3 text-decoration-none mb-auto m-1 btn btn-sm btn-danger">
								Delete
							</a>								
				  		</div>			
				  </div>

					<div class="modal fade" :id="'deleteModal'+project.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        Delete Project in <b>{{ project.sub_category }}</b>?
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <button type="button" @click="deleteProject" class="btn btn-danger">Delete</button>
					      </div>
					    </div>
					  </div>
					</div>

				</div>
			</div>		

	`
});

new Vue({ 
	el: '#projectsSchool',
	mixins:[newProjectMixin],
	data: function() 
	{
		return {
			offset: 0,
			rowCount: 3,
			projects:[],
			needs:'',
			qty:'',
			amount:'',
			studentsBeneficiary:'',
			personnelsBeneficiary:'',
			accountablePerson:'',
			contactNo:'',
			schoolYear:'',
			description:'',
			projectFilter: 'dateEncoded'
		}
	},
	created() {

		this.getProjectByDateEncoded({offset: this.offset, rowCount: this.rowCount})
		.then((response) => {
			this.projects = response.data;
			this.offset += 3;
		})
		.catch((errors) => {
			console.log(errors);
		})
		.finally(() => {
			$.LoadingOverlay('hide');
		})
	},
	methods: {
		getProjectByDateEncoded: function(data) {

			$.LoadingOverlay('show');
			return axios.post(`${BASE_URL}/account/schools/projects/json`, data);
		},
		getProjectByImplementationDate: function(data) {

			$.LoadingOverlay('show');
			return axios.post(`${BASE_URL}/account/schools/projects/implementation-date`, data);
		},
		newProject: function() {

			$.LoadingOverlay('show');

			let data = {
				needs: this.needs,
				qty: this.qty,
				amount: this.amount,
				studentsBeneficiary: this.studentsBeneficiary,
				personnelsBeneficiary: this.personnelsBeneficiary,
				implementationDate: $('#implementationDate').val(),
				accountablePerson: this.accountablePerson,
				contactNo: this.contactNo,
				schoolYear: this.schoolYear,
				description: this.description
			}

			axios.post(`${BASE_URL}/account/schools/projects/add`, data)
			.then((response) => {

				$('#newProjectModal').modal('toggle');

				this.needs = '';
				this.qty = '';
				this.amount = '';
				this.studentsBeneficiary = '';
				this.personnelsBeneficiary = '';
				this.implementationDate = '';
				this.accountablePerson = '';
				this.contactNo = '';
				this.schoolYear = '';
				this.description = '';

				this.errorNeeds = false;
				this.errorNeedsMsg = '';
				this.errorNeedsMsgInvalid = '';
				this.errorQty = false;
				this.errorQtyMsg = '';
				this.errorQtyInvalid = '';
				this.errorAmount = false;
				this.errorAmountMsg = '';
				this.errorAmountInvalid = '';
				this.errorStudentsBeneficiary = false;
				this.errorStudentsBeneficiaryMsg = '';
				this.errorStudentsBeneficiaryInvalid = '';
				this.errorPersonnelsBeneficiary = false;
				this.errorPersonnelsBeneficiaryMsg = '';
				this.errorPersonnelsBeneficiaryInvalid = '';
				this.errorImplementationDate = false;
				this.errorImplementationDateMsg = '';
				this.errorImplementationDateInvalid = '';
				this.errorAccountablePerson = false;
				this.errorAccountablePersonMsg = '';
				this.errorAccountablePersonInvalid = '';
				this.errorContactNo = false;
				this.errorContactNoMsg = '';
				this.errorContactNoInvalid = '';
				this.errorSchoolYear = false;
				this.errorSchoolYearMsg = '';
				this.errorSchoolYearInvalid = '';
				this.errorDescription = false;
				this.errorDescriptionMsg = '';
				this.errorDescriptionInvalid = '';

				this.offset = 0;
				this.getProjectByDateEncoded({offset: this.offset, rowCount: 3})
				.then((response) => {
					this.projects = response.data;
					this.offset += 3;
				})
				.catch((errors) => {
					console.log(errors);
				})
				.finally(() => {

					$.LoadingOverlay('hide');

					Swal.fire(
					  'Success!',
					  'New Project added',
					  'success'
					)
				})				
			})
			.catch((error) => {

				$.LoadingOverlay('hide');
				
				if(error.response.data.errors.needs) {
					this.errorNeeds = true;
					this.errorNeedsMsgInvalid = 'is-invalid';
					this.errorNeedsMsg = error.response.data.errors.needs[0];					
				}

				if(error.response.data.errors.qty) {
					this.errorQty = true;
					this.errorQtyInvalid = 'is-invalid';
					this.errorQtyMsg = error.response.data.errors.qty[0];
				}

				if(error.response.data.errors.amount) {
					this.errorAmount = true;
					this.errorAmountInvalid = 'is-invalid';
					this.errorAmountMsg = error.response.data.errors.amount[0];
				}

				if(error.response.data.errors.studentsBeneficiary) {
					this.errorStudentsBeneficiary = true;
					this.errorStudentsBeneficiaryInvalid = 'is-invalid';
					this.errorStudentsBeneficiaryMsg = error.response.data.errors.studentsBeneficiary[0];
				}

				if(error.response.data.errors.personnelsBeneficiary) {
					this.errorPersonnelsBeneficiary = true;
					this.errorPersonnelsBeneficiaryInvalid = 'is-invalid';
					this.errorPersonnelsBeneficiaryMsg = error.response.data.errors.personnelsBeneficiary[0];
				}

				if(error.response.data.errors.implementationDate) {
					this.errorImplementationDate = true;
					this.errorImplementationDateInvalid = 'is-invalid';
					this.errorImplementationDateMsg = error.response.data.errors.implementationDate[0];
				}

				if(error.response.data.errors.accountablePerson) {
					this.errorAccountablePerson = true;
					this.errorAccountablePersonInvalid = 'is-invalid';
					this.errorAccountablePersonMsg = error.response.data.errors.accountablePerson[0];
				}

				if(error.response.data.errors.contactNo) {
					this.errorContactNo = true;
					this.errorContactNoInvalid = 'is-invalid';
					this.errorContactNoMsg = error.response.data.errors.contactNo[0];
				}

				if(error.response.data.errors.schoolYear) {
					this.errorSchoolYear = true;
					this.errorSchoolYearInvalid = 'is-invalid';
					this.errorSchoolYearMsg = error.response.data.errors.schoolYear[0];
				}

				if(error.response.data.errors.description) {
					this.errorDescription = true;
					this.errorDescriptionInvalid = 'is-invalid';
					this.errorDescriptionMsg = error.response.data.errors.description[0];
				}
			})
			.finally(() => {
				$.LoadingOverlay('hide');
			})

		},
		viewMoreProjects: function() {

			let projectSource = null;

			if(this.projectFilter === "implementationDate") {
				projectSource = this.getProjectByImplementationDate({offset: this.offset, rowCount: this.rowCount});
			}else {
				projectSource = this.getProjectByDateEncoded({offset: this.offset, rowCount: this.rowCount});
			}

			projectSource
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
		deleteProject: function(projectId) {

			let projectSource;

			let data = {
				projectId: projectId
			}

			$.LoadingOverlay('show');

			axios.post(`${BASE_URL}/account/schools/projects/delete`, data)
			.then((response) => {
				
				if(this.projectFilter === "implementationDate") {
					this.offset = 0
					projectSource = this.getProjectByImplementationDate({offset: this.offset, rowCount: 3});
					this.offset += 3;
				}else {
					this.offset = 0;
					projectSource = this.getProjectByDateEncoded({offset: this.offset, rowCount: 3});
					this.offset += 3;
				}

				projectSource
				.then((response) => {
					this.projects = response.data;
					$('#deleteModal'+projectId).modal('toggle');
				})
				.catch((errors) => {
					console.log(errors);
				})
				.finally(() => {
					$.LoadingOverlay('hide');
				})

			})
			.catch((errors) => {
				console.log(errors);
			})
			.finally(() => {
				$.LoadingOverlay('hide')
			})
		},
		filterProjects: function() {
			
			let projectSource = null;

			if(this.projectFilter ==="implementationDate") {
				this.offset = 0;
				projectSource = this.getProjectByImplementationDate({offset: this.offset, rowCount: this.rowCount});
				this.offset += 3;
			}else {
				this.offset = 0;
				projectSource = this.getProjectByDateEncoded({offset: this.offset, rowCount: this.rowCount});
				this.offset += 3;
			}


			projectSource.then((response) => {
				this.projects = response.data
			})
			.catch((errors) => {
				console.log(errors);
			})
			.finally(() => {
				$.LoadingOverlay('hide')
			})
		}		
	}		
})

function publishControl(baseUrl) {

	 $('[data-toggle="tooltip"]').tooltip();

	$('.unpublishBtn, .publishBtn').click(function(e) {

		e.preventDefault();

		let projectId = $(this).data('project');
		let action = $(this).data('action');

		let data = {
			projectId: projectId,
			action: action
		}

		$.ajax({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },			
			// url: baseUrl+'/account/schools/projects/publish',
			type: 'POST',
			data: data,
			beforeSend: function() {
				$('#projectCard'+projectId).LoadingOverlay('show');
			},
			success: function(result) {
				
				$('#projectCard'+projectId).LoadingOverlay('hide');
				let html = '';


				if(action == 'publish') 
				{
					$('#publishBtn'+projectId).remove();

					html += "<button id='unpublishBtn"+projectId+"' class='btn btn-sm btn-danger unpublishBtn' data-project='"+projectId+"' data-action='unpublish' data-toggle='tooltip' data-placement='top' title='Unpublish make this project hidden from all projects list.'>";
						html += "<i class='fa fa-times'></i>";
						html += " Unpublish";
					html += "</button>";

					$('#projectCardBody'+projectId).removeClass('border border-danger');
					$('#publishBtnContainer'+projectId).html(html);
					// publishControl(baseUrl);
				}else 
				{
					$('#unpublishBtn'+projectId).remove();

					html += "<button id='publishBtn"+projectId+"' class='btn btn-sm btn-success publishBtn' data-project='"+projectId+"' data-action='publish' data-toggle='tooltip' data-placement='top' title='Publish make this project visible from all projects list.'>";
						html += "<i class='fa fa-check'></i>";
						html += " Publish";
					html += "</button>";

					$('#projectCardBody'+projectId).addClass('border border-danger');	
					$('#publishBtnContainer'+projectId).html(html);	
					// publishControl(baseUrl);			
				}

			}
		});

	});
}

function getComments(url, projectId) {

	$.ajax({
		url: url+'/account/schools/projects/'+projectId+'/comments',
		type:'GET',
		beforeSend: function() {
			$('#schoolComments').LoadingOverlay('show');
		},
		success: function(result) {
			
			let html = '';

			$.each(result, function(index, value) 
			{
				html += '<div class="row mb-n4">';
					html += '<div class="col-md">';
						html += '<div class="jumbotron jumbotron-fluid pt-1 pb-1">';
							html += '<div class="container">';
								html += '<h6 class="mb-0" style="font-size: 14px;">'+value.name+'</h6>';
								html += '<div class="mt-0" style="font-size: 14px;">'+value.comment+'</div>';
							html += '</div>';
						html += '</div>';
					html += '</div>';
				html += '</div>';
			});

			$('#schoolComments').html(html);
			$('#schoolComments').LoadingOverlay('hide');
		}
	});
}

$(function() {

	// $('.number-format').toArray().forEach(function(field){
	// 	new Cleave(field, {
	// 		numeral: true,
	// 		numeralThousandsGroupStyle: 'thousand'
	// 	});
	// })

	$('.updateProjectBtn').click(function() {

		let projectId = $(this).data('project');

	    $('#dateUpdate'+projectId).datepicker({
	        uiLibrary: 'bootstrap4',
	        format: 'yyyy-mm-dd'
	    });

	    $('#saveUpdateBtn'+projectId).click(function() {

	    	let dateUpdate = $('#dateUpdate'+projectId).val();
	    	let projectUpdate = $('#projectUpdate'+projectId).val();

	    	let data = {
	    		projectId: projectId,
	    		projectUpdate: projectUpdate,
	    		updateDate: dateUpdate
	    	}

	    	$.ajax({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },	    		
	    		// url: baseUrl+'/account/schools/projects/updates/add',
	    		type: 'POST',
	    		data: data,
	    		beforeSend: function() {
	    			
	    			$('#projectUpdate'+projectId).attr('disabled', true);
	    			$('#dateUpdate'+projectId).attr('disabled', true);
	    			$('#projectUpdate'+projectId).LoadingOverlay('show');
	    		},
	    		success: function(result) {
	    			
	    			$('#projectUpdate'+projectId).attr('disabled', false);
	    			$('#dateUpdate'+projectId).attr('disabled', false);
	    			$('#projectUpdate'+projectId).LoadingOverlay('hide');
	    			$('#updateModal'+projectId).modal('hide');
	    		},
	    		error: function(request, status, error) {

	    			$('#projectUpdate'+projectId).attr('disabled', false);
	    			$('#dateUpdate'+projectId).attr('disabled', false);
	    			$('#projectUpdate'+projectId).LoadingOverlay('hide');

	    			let res = JSON.parse(request.responseText);

			        if(res.errors.updateDate) {
			        	$('#dateUpdate'+projectId).addClass('is-invalid');
			        	$('#errorDateUpdate'+projectId).addClass('invalid-feedback');
			        	$('#errorDateUpdate'+projectId).html(res.errors.updateDate);
			        }


			        if(res.errors.projectUpdate) {
			        	$('#projectUpdate'+projectId).addClass('is-invalid');
			        	$('#errorProjectUpdate'+projectId).addClass('invalid-feedback');
			        	$('#errorProjectUpdate'+projectId).html(res.errors.projectUpdate);
			        }	
	    		}
	    	});

	    });

	});

    $('#implementationDate').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });

    $('#addProjectBtn').click(function() {

    	let needs = $('#needs option:selected').val();
    	let qty = $('#qty').val().replace(',','');
    	let amount = $('#amount').val().replace(',','');
    	let studentsBeneficiary = $('#studentsBeneficiary').val().replace(',','');
    	let personnelsBeneficiary = $('#personnelsBeneficiary').val().replace(',','');
    	let implementationDate = $('#implementationDate').val();
    	let accountablePerson = $('#accountablePerson').val();
    	let contactNo = $('#contactNo').val();
    	let schoolYear = $('#schoolYear option:selected').val();
    	let description = $('#description').val();

    	let data = {
    		needs: needs,
    		qty: qty,
    		amount: amount,
    		studentsBeneficiary: studentsBeneficiary,
    		personnelsBeneficiary: personnelsBeneficiary,
    		implementationDate: implementationDate,
    		accountablePerson: accountablePerson,
    		contactNo: contactNo,
    		schoolYear: schoolYear,
    		description: description
    	}

    	$.ajax({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },    		
    		// url: baseUrl+'/account/schools/projects/add',
    		type: 'POST',
    		data: data,
    		beforeSend: function() {

    			$('#newProjectModal').LoadingOverlay('show');
    		},
    		success: function(result) {
    			
    			$('#newProjectModal').LoadingOverlay('hide');
    			$('#newProjectModal').modal('toggle');

			    $('#qty').val('');
			    $('#amount').val('');
				$('#studentsBeneficiary').val('');
				$('#personnelsBeneficiary').val('');
				$('#implementationDate').val('');
				$('#description').val('');

				Swal.fire(
				  'Success!',
				  'New Project added',
				  'success'
				)					
    		},
    		error: function(request, status, error) {

    			$('#newProjectModal').LoadingOverlay('hide');

    			let res = JSON.parse(request.responseText);

		        if(res.errors.qty) {
		        	$('#qty').addClass('is-invalid');
		        	$('#errorQTY').addClass('invalid-feedback');
		        	$('#errorQTY').html(res.errors.qty);
		        }

		        if(res.errors.amount) {
		        	$('#amount').addClass('is-invalid');
		        	$('#errorAmount').addClass('invalid-feedback');
		        	$('#errorAmount').html(res.errors.amount);
		        }

		        if(res.errors.studentsBeneficiary) {
		        	$('#studentsBeneficiary').addClass('is-invalid');
		        	$('#errorStudentsBeneficiary').addClass('invalid-feedback');
		        	$('#errorStudentsBeneficiary').html(res.errors.studentsBeneficiary);
		        }

		        if(res.errors.personnelsBeneficiary) {
		        	$('#personnelsBeneficiary').addClass('is-invalid');
		        	$('#errorPersonnelsBeneficiary').addClass('invalid-feedback');
		        	$('#errorPersonnelsBeneficiary').html(res.errors.personnelsBeneficiary);
		        }

		        if(res.errors.implementationDate) {
		        	$('#implementationDate').addClass('is-invalid');
		        	$('#errorImplementationDate').addClass('invalid-feedback');
		        	$('#errorImplementationDate').html(res.errors.implementationDate);
		        }

		        if(res.errors.accountablePerson) {
		        	$('#accountablePerson').addClass('is-invalid');
		        	$('#errorAccountablePerson').addClass('invalid-feedback');
		        	$('#errorAccountablePerson').html(res.errors.accountablePerson);
		        }

		        if(res.errors.contactNo) {
		        	$('#contactNo').addClass('is-invalid');
		        	$('#errorContactNo').addClass('invalid-feedback');
		        	$('#errorContactNo').html(res.errors.contactNo);
		        }

		        if(res.errors.description) {
		        	$('#description').addClass('is-invalid');
		        	$('#errorDescription').addClass('invalid-feedback');
		        	$('#errorDescription').html(res.errors.description);
		        }		        		        		        		        		            			
    		}
    	});

    });


	$('.commentField').keypress(function(event) {
	    var keycode = (event.keyCode ? event.keyCode : event.which);
	    if(keycode == '13') {
	        
	        let projectId = $(this).data('id');
	    	let comment = $(this).val();

	    	let data = {
	    		projectId: projectId,
	    		comment: comment
	    	}

	    	$.ajax({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }, 	    		
	    		// url: baseUrl+'/account/schools/projects/comments/add',
	    		type: 'POST',
	    		data: data,
	    		beforeSend: function() {
			    	$('#commentField'+projectId).prop('disabled', true);
			    	$('#commentField'+projectId).LoadingOverlay('show');
	    		},
	    		success: function(result) {

	    			$("#commentField"+projectId).val('');
	    			$('#commentField'+projectId).prop('disabled', false);
	    			$('#commentField'+projectId).LoadingOverlay('hide');

	    			// getComments(baseUrl, projectId);

	    		},
	    		error: function(request, status, error) {

	    			let res = JSON.parse(request.responseText);

			        if(res.errors.comment) {

				    	$('#commentField'+projectId).prop('disabled', false);
				    	$('#commentField'+projectId).LoadingOverlay('hide');

			        	$('#commentField'+projectId).addClass('is-invalid');
			        	$('#errorComment'+projectId).addClass('invalid-feedback');
			        	$('#errorComment'+projectId).html(res.errors.comment);
			        }	    			
	    		}
	    	});
	    }
	});


	// publishControl(baseUrl);

});