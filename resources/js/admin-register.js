$(function() {

	var baseUrl = 'http://localhost/school/public';

	$('#registerBtn').click(function(e) {

		e.preventDefault();

		let email = $('#emailAddress').val();
		let password = $('#password').val();
		let completeName = $('#completeName').val();

		let data = {
			emailAddress: email,
			password: password,
			completeName: completeName
		};

		$.ajax({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },			
			url: baseUrl+'/admin/register',
			type:'POST',
			data:data,
			beforeSend: function() {
				$('#registrationCard').LoadingOverlay('show');
			},
			success: function(results) {

				$('#emailAddress').val('');
				$('#password').val('');
				$('#completeName').val('');
				$('#registrationCard').LoadingOverlay('hide');
				Swal.fire(
				  'Registration Success!',
				  'You may now proceed to admin login!',
				  'success'
				)
			},
		    error: function (request, status, error) {

		    	$('#registrationCard').LoadingOverlay('hide');
		    	let res = JSON.parse(request.responseText);

		        if(res.errors.emailAddress) {
		        	$('#emailAddress').addClass('is-invalid');
		        	$('#errorEmail').addClass('invalid-feedback');
		        	$('#errorEmail').html(res.errors.emailAddress);
		        }

		        if(res.errors.password) {
		        	$('#password').addClass('is-invalid');
		        	$('#errorPassword').addClass('invalid-feedback');
		        	$('#errorPassword').html(res.errors.password);
		        }

		        if(res.errors.completeName) {
		        	$('#completeName').addClass('is-invalid');
		        	$('#errorCompleteName').addClass('invalid-feedback');
		        	$('#errorCompleteName').html(res.errors.completeName);
		        }	        

		    }			
		});

	});

});