
function getSubSector(url, sectorId) {

	$.ajax({
		url: url+'/stakeholders/sector/'+sectorId+'/subsector',
		type: 'GET',
		success: function(result) {
			
			let html = '';

			html += '<ul class="list-unstyled">';

			$.each(result, function(index, value) {

				html += '<li>';
					html += '<input type="radio" id="subSector'+value.id+'" class="mr-1 mb-1" name="subSector" value="'+sectorId+'-'+value.id+'"> '+value.name;
				html += '</li>';
			});

			html += '</ul>';
			$('#sector'+sectorId).html(html);
		}
	});
}

$(function() {

	var baseUrl = 'http://localhost/school/public';

	$('#accordion').accordion({
		collapsible: true,
		heightStyle:'content',
		header: "h3", active: false
	});
	
	$.ajax({
		url: baseUrl+'/stakeholders/sector',
		type:'GET',
		success:function(result) {

			let html = '';

			$.each(result, function(index, value) {
				
				html += '<h6 id="'+value.id+'" data-id="'+value.id+'"><b>';
					html += value.sector;
				html += '</b></h6>';

				getSubSector(baseUrl, value.id);
				html += '<div id="sector'+value.id+'"></div>';
			});

			$('#sectorField').html("<div>"+html+"</div>");
		}
	});

	$('#registerBtn').click(function(e) {

		e.preventDefault();

		let companyName = $('#companyName').val();
		let sector = $('input[name=subSector]:checked').val();
		let contactNo = $('#contactNo').val();
		let emailAdd = $('#emailAdd').val();
		let tempPassword = $('#tempPassword').val();
		let captcha = $('#captcha').val();

		let data = {
			companyName: companyName,
			sector:sector,
			contactNo: contactNo,
			emailAdd: emailAdd,
			tempPassword: tempPassword,
			captcha: captcha
		};

		$.ajax({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },			
			url: baseUrl+'/stakeholders/register',
			type:'POST',
			data:data,
			success: function(results) {

			},
		    error: function (request, status, error) {

		    	let res = JSON.parse(request.responseText);

		        if(res.errors.companyName) {
		        	$('#errorName').html('<span style="color:red;">'+res.errors.companyName+'</span>');
		        }

		        if(res.errors.contactNo) {
		        	$('#errorContact').html('<span style="color:red;">'+res.errors.contactNo+'</span>');
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