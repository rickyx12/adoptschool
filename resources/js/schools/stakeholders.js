import formatDate from '../formatDate.js';
import formatWord from '../formatWord.js';
import { BASE_URL } from '../baseUrl.js';

Vue.component('stakeholders',{
	props: {
		stakeholders: Object
	},
	filters:{
		formatWord,
		formatDate
	},
	template:`

	  		<div class="col-md-4 mb-3">
				<div class="card h-100">
				  <div class="card-body d-flex flex-column">
				  	<div class="row">
				  		<div class="col-md">
				  			<h5 class="card-title">{{ stakeholders.stakeholderName | formatWord }}</h5>
				  			<h6 class="card-subtitle mb-2 text-muted">{{ stakeholders.sub_category }}</h6>	

				  			<ul v-if="stakeholders.approved == 1">
				  				<li>Contribution: ₱{{ stakeholders.contributedAmount.toLocaleString() }}</li>
				  				<li>Quantity: {{ stakeholders.contributedQTY }} / {{ stakeholders.neededQTY }} </li>
				  				<li>Contact#: {{ stakeholders.stakeholder_contact }}</li>
				  				<li>Application: {{ stakeholders.date_application | formatDate }}</li>
				  				<li>Approved: {{ stakeholders.transaction_date | formatDate }}</li>
				  				<li>Staff: {{ stakeholders.staff | formatWord }}</li>
				  			</ul>

				  			<ul v-else>
				  				<li>Application: {{ stakeholders.date_application | formatDate }}</li>
				  				<li>Contact#: {{ stakeholders.stakeholder_contact }}</li>
				  				<li>Approved: <span class="text-danger">On Process</span></li>
				  			</ul>

				  			<div v-if="stakeholders.approved == 0 && stakeholders.message !== null" class="jumbotron">
				  				{{ stakeholders.message }}
				  			</div>

				  			<div v-if="stakeholders.approved == 0 && stakeholders.message === null" class="jumbotron">
				  				<i>No Message from stakeholder</i>
				  			</div>

							<small v-if="stakeholders.approved == 0" class="form-text text-muted mt-n4">
							  Our staff will coordinate to you.
							</small>				  			
				  		</div>
				    </div>

					<div class="d-flex d-row justify-content-center mt-auto">
						<a :href="'${BASE_URL}/project/'+stakeholders.projectId" target="_blank" class="mt-3 text-decoration-none mb-auto btn btn-sm btn-primary">
							View
						</a>							
					</div>    			
				  </div>
				</div>
			</div>		
	`
});

new Vue({ 
	el: '#stakeholdersSchool',
	data: function() 
	{
		return {
			offset: 0,
			rowCount: 3,
			stakeholders:[]
		}
	},
	created() {

		$.LoadingOverlay('show');

		this.getStakeholders({offset: this.offset, rowCount: this.rowCount})
		.then((response) => {
			this.stakeholders = response.data;
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
		getStakeholders: function(data) {
			return axios.post(`${BASE_URL}/account/schools/stakeholders/json`, data)
		},
		viewMoreProjects: function() {

			$.LoadingOverlay('show');

			this.getStakeholders({offset: this.offset, rowCount: this.rowCount})
			.then((response) => {

				this.stakeholders = this.stakeholders.concat(response.data);
				this.offset += 3;
			})
			.catch((error) => {
				console.log(error)
			})
			.finally(() => {
				$.LoadingOverlay('hide');
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