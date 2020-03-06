$(function() {

	var baseUrl = 'http://localhost/school/public';


	$('#region').change(function(e) {
		e.preventDefault();

		let html = '';
		let region = $('#region option:selected').val();

		let data = {
			regionId: region
		}

		$.ajax({
			url: baseUrl+'/region/'+region+'/divisions',
			type:'GET',
			data: data,
			success: function(result) {

				$.each(result, function(index, value) {
					html += "<option value='"+value.id+"'>"+value.name+"</option>";
				});

				$('#division').html(html);
			}
		});
	});

	$('#schoolRegisterBtn').click(function(e) {

		e.preventDefault();
	
		let schoolName = $('#schoolName').val();
		let region = $('#region option:selected').val();
		let division = $('#division option:selected').val();
		let schoolType = $('#schoolType option:selected').val();
		let accountablePerson = $('#accountablePerson').val();
		let position = $('#position').val();
		let contactNo = $('#contactNo').val();
		let address = $('#address').val();
		let emailAdd = $('#emailAdd').val();
		let tempPassword = $('#tempPassword').val();
		let captcha = $('#captcha').val();

		data = {
			schoolName: schoolName,
			region: region,
			division: division,
			schoolType: schoolType,
			accountablePerson: accountablePerson,
			position: position,
			contactNo: contactNo,
			address: address,
			emailAdd: emailAdd,
			tempPassword: tempPassword,
			captcha: captcha
		}

		$.ajax({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },			
			url: baseUrl+'/school/register',
			type:'POST',
			data: data,
			success: function(result) {

				console.log(result);
			},
			error: function(request, status, error) {

				let res = JSON.parse(request.responseText);

		        if(res.errors.schoolName) {
		        	$('#errorName').html('<span style="color:red;">'+res.errors.schoolName+'</span>');
		        }

		        if(res.errors.region) {
		        	$('#errorRegion').html('<span style="color:red;">'+res.errors.region+'</span>');
		        }

		        if(res.errors.division) {
		        	$('#errorDivision').html('<span style="color:red;">'+res.errors.division+'</span>');
		        }

		        if(res.errors.schoolType) {
		        	$('#errorType').html('<span style="color:red;">'+res.errors.schoolType+'</span>');
		        }

		        if(res.errors.accountablePerson) {
		        	$('#errorAccountablePerson').html('<span style="color:red;">'+res.errors.accountablePerson+'</span>');
		        }

		        if(res.errors.position) {
		        	$('#errorPosition').html('<span style="color:red;">'+res.errors.position+'</span>');
		        }

		        if(res.errors.contactNo) {
		        	$('#errorContact').html('<span style="color:red;">'+res.errors.contactNo+'</span>');
		        }

		        if(res.errors.address) {
		        	$('#errorAddress').html('<span style="color:red;">'+res.errors.address+'</span>');
		        }

		        if(res.errors.emailAdd) {
		        	$('#errorEmail').html('<span style="color:red;">'+res.errors.emailAdd+'</span>');
		        }

		        if(res.errors.tempPassword) {
		        	$('#errorPass').html('<span style="color:red;">'+res.errors.tempPassword+'</span>');
		        }

		        if(res.errors.captcha) {
		        	$('#errorCaptcha').html('<span style="color:red;">'+res.errors.captcha+'</span>');
		        }		        		        		        		        		        
			}
		});

	});

});