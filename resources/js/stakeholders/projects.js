function getComments(url, projectId) {

	$.ajax({
		url: url+'/account/stakeholders/projects/'+projectId+'/comments',
		type:'GET',
		beforeSend: function() {
			$('#stakeholdersComments').LoadingOverlay('show');
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

			$('#stakeholdersComments').html(html);
			$('#stakeholdersComments').LoadingOverlay('hide');
		}
	});
}

$(function() {

	var baseUrl = 'http://localhost/school/public';

	$('#filterBtn').click(function() {
		$('#filterForm').submit();
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
	    		url: baseUrl+'/account/stakeholders/projects/comments/add',
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

	    			getComments(baseUrl, projectId);

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


	$('.applyBtn').click(function() {

		let projectId = $(this).data('id');

		$('#applyStakeholderBtn'+projectId).click(function(){

			let contactNo = $('#stakeholdersContactNo'+projectId).val();
			let message = $('#stakeholdersMessage'+projectId).val();
			
			let data = {
				projectId: projectId,
				contactNo: contactNo,
				message: message
			}

			$.ajax({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },				
				url: baseUrl+'/account/stakeholders/projects/stakeholders/add',
				type: 'POST',
				data:data,
				beforeSend: function() {
					$('#stakeholdersContactNo'+projectId).attr('disabled', true);
					$('#stakeholdersMessage'+projectId).attr('disabled', true);
					$('#stakeholdersMessage'+projectId).LoadingOverlay('show');
					$('#applyStakeholderBtn'+projectId).attr('disabled', true);
					$('#stakeholderCancerReqBtn'+projectId).attr('disabled', true);
				},
				success:function(result) {
					$('#stakeholdersContactNo'+projectId).attr('disabled', false);
					$('#stakeholdersMessage'+projectId).attr('disabled', false);
					$('#stakeholdersMessage'+projectId).LoadingOverlay('hide');	

					$('#applyStakeholderBtn'+projectId).attr('disabled', false);
					$('#stakeholderCancerReqBtn'+projectId).attr('disabled', false);					

					$('#stakeholdersContactNo'+projectId).val('');
					$('#stakeholdersMessage'+projectId).val('');

					$('#applyStakeholderModal'+projectId).modal('hide');

					Swal.fire(
					  'Application Sent!',
					  'Thank you for helping our students. Expect a call from us shortly',
					  'success'
					)

					$('#projectCard'+projectId).remove();
				},
				error: function(request, status, error) {

	    			let res = JSON.parse(request.responseText);

			        if(res.errors.contactNo) {

						$('#stakeholdersContactNo'+projectId).attr('disabled', false);
						$('#stakeholdersMessage'+projectId).attr('disabled', false);
						$('#stakeholdersMessage'+projectId).LoadingOverlay('hide');

						$('#applyStakeholderBtn'+projectId).attr('disabled', false);
						$('#stakeholderCancerReqBtn'+projectId).attr('disabled', false);

			        	$('#stakeholdersContactNo'+projectId).addClass('is-invalid');
			        	$('#errorStakeholderContact'+projectId).addClass('invalid-feedback');
			        	$('#errorStakeholderContact'+projectId).html(res.errors.contactNo);
			        }						
				}
			});

		});
	});

});