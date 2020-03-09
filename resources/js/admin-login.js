$(function() {

	var baseUrl = 'http://localhost/school/public';


	$('#loginBtn').click(function(e) {

		e.preventDefault();
		
		let emailAdd = $('#emailAddress').val();	
		let password = $('#password').val();

		let data = {
			email: emailAdd,
			password: password
		}

		authUrl = baseUrl+'/admin/authenticate';
		 $('#loginForm').attr('action', authUrl).submit();
	});

});