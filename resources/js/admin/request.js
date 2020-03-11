$(function() {

	var baseUrl = 'http://localhost/school/public';

	$('.number-format').toArray().forEach(function(field){
		new Cleave(field, {
			numeral: true,
			numeralThousandsGroupStyle: 'thousand'
		});
	})


    $('.transactionDate').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });


    $('.approveBtn').click(function() {

    	let requestId = $(this).data('id');


	    $('#approveNowBtn'+requestId).click(function() {

	    	let monetaryValue = $('#monetaryValue'+requestId).val().replace(',','');
	    	let quantity = $('#quantity'+requestId).val();
	    	let referrence = $('#referrence'+requestId).val();
	    	let transactionDate = $('#transactionDate'+requestId).val();

	    	let data = {
	    		requestId: requestId,
	    		monetaryValue: monetaryValue,
	    		quantity: quantity,
	    		referrence: referrence,
	    		transactionDate: transactionDate
	    	}

	    	$.ajax({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },    		
	    		url: baseUrl+'/account/admin/request/approved',
	    		type:'POST',
	    		data:data,
	    		beforeSend: function() {
	    			$('#approveModalBody'+requestId).LoadingOverlay('show');
	    			$('#approveNowBtn'+requestId).attr('disabled',true);
	    			$('#cancelApproveBtn'+requestId).attr('disabled',true);
	    		},
	    		success:function(result) {

	    			$('#approveModalBody'+requestId).LoadingOverlay('hide');
	    			$('#approveNowBtn'+requestId).attr('disabled',false);
	    			$('#cancelApproveBtn'+requestId).attr('disabled',false);

	    			$('#approvedModal'+requestId).modal('hide');
	    			$('#requestContainer'+requestId).remove();

					Swal.fire(
					  'Success!',
					  'Stakeholder Request Approved!',
					  'success'
					)	    				    			
	    		},
	    		error: function(request, status, error) {

	    			$('#approveModalBody'+requestId).LoadingOverlay('hide');
	    			$('#approveNowBtn'+requestId).attr('disabled',false);
	    			$('#cancelApproveBtn'+requestId).attr('disabled',false);	    			

	    			let res = JSON.parse(request.responseText);

			        if(res.errors.monetaryValue) {
			        	$('#monetaryValue'+requestId).addClass('is-invalid');
			        	$('#errorMonetaryValue'+requestId).addClass('invalid-feedback');
			        	$('#errorMonetaryValue'+requestId).html(res.errors.monetaryValue);
			        }

			        if(res.errors.quantity) {
			        	$('#quantity'+requestId).addClass('is-invalid');
			        	$('#errorQuantity'+requestId).addClass('invalid-feedback');
			        	$('#errorQuantity'+requestId).html(res.errors.quantity);
			        }

			        if(res.errors.referrence) {
			        	$('#referrence'+requestId).addClass('is-invalid');
			        	$('#errorReferrence'+requestId).addClass('invalid-feedback');
			        	$('#errorReferrence'+requestId).html(res.errors.referrence);
			        }

			        if(res.errors.transactionDate) {
			        	$('#transactionDate'+requestId).addClass('is-invalid');
			        	$('#errorTransactionDate'+requestId).addClass('invalid-feedback');
			        	$('#errorTransactionDate'+requestId).html(res.errors.transactionDate);
			        }			        			            			
	    		}
	    	});

	    });
    });


});