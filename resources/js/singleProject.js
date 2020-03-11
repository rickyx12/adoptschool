
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

$(function(){
	
	var baseUrl = 'http://localhost/school/public';
	
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
	    		url: baseUrl+'/account/schools/projects/comments/add',
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

});