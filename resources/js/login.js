$(function() {

	var baseUrl = 'http://localhost/school/public';


	$('#loginBtn').click(function(e) {

		e.preventDefault();
		
		let emailAdd = $('#emailAddress').val();	
		let password = $('#password').val();
		let loginAs = $("input[name='loginAs']:checked").val();
		let authUrl = '';

		let data = {
			email: emailAdd,
			password: password
		}

		if(loginAs === 'stakeholders') {
			authUrl = baseUrl+'/stakeholders/authenticate';
		}else {
			authUrl = baseUrl+'/school/authenticate';
		}	

		 $('#loginForm').attr('action', authUrl).submit();
	});

});