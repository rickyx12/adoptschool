$(function() {

	var baseUrl = 'http://localhost/school/public';

	$('#category').accordion({
		collapsible: true,
		heightStyle:'content',
		header: "h3", active: false,
		icons:null
	});
	
	// $.ajax({
	// 	url: baseUrl+'/category',
	// 	type:'GET',
	// 	success:function(result) {

	// 		let html = '';

	// 		$.each(result, function(index, value) {

	// 			html += '<h3>'+value.name+'</h3>';
	// 		});

	// 		$('#category-container').html(html);
	// 	}
	// });
});