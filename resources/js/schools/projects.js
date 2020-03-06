$(function() {

	var baseUrl = 'http://localhost/school/public';

	$('.number-format').toArray().forEach(function(field){
		new Cleave(field, {
			numeral: true,
			numeralThousandsGroupStyle: 'thousand'
		});
	})

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
	    		url: baseUrl+'/account/schools/projects/updates/add',
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
    		url: baseUrl+'/account/schools/projects/add',
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

});