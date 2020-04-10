import { BASE_URL } from './baseUrl.js';
import formatDate from './formatDate.js'

Vue.component('all-comments',{
	props:{
		name: String,
		comment: String,
		date: String
	},
	filters:{
		formatName: function(value) {
			
			let str = value.toLowerCase();
	    	return str.replace(/(^([a-zA-Z\p{M}]))|([ -][a-zA-Z\p{M}])/g,
	        function($1){
	            return $1.toUpperCase();
	        });
		},
		getDate: function(value) {

			let date = value.split(" ");
			return date[0];
		},
		formatDate
	},
	template: `
 				<div class="row mb-n4">
  					<div class="col-md">
						<div class="jumbotron jumbotron-fluid pt-1 pb-1">
							<div class="container">
						    	<span class="font-weight-bold" style="font-size: 14px;">
						    		{{ name | formatName }} 
						    	</span>
						    	<span class="ml-1" style="font-size:12px;">
						    		({{ date | getDate | formatDate }})
						    	</span>
						    	<br>
						    	<span class="mt-0" style="font-size: 14px;">{{ comment }}</span>
							</div>
						</div>
					</div>
  				</div>
	`
});

new Vue({
	el:"#comments",
	data() {
		return {
			comments:[],
			userComment:'',
			latestComments: true,
			allComments: false
		}
	},
	methods: {
		getComments: function(projectId) {
			return axios.get(`${BASE_URL}/project/${projectId}/comments/all`);
		},
		addComment: function(projectId) {

			$('#comments').LoadingOverlay('show');

			let data = {
				projectId: projectId,
				comment: this.userComment
			}

			axios.post(`${BASE_URL}/account/stakeholders/projects/comments/add`, data)
			.then((response) => {

				this.userComment = '';
				
				this.getComments(projectId)
				.then((response) => {

					this.latestComments = false;
					this.allComments = true;
					this.comments = response.data;
					$('#comments').LoadingOverlay('hide');
				})
				.catch((error) => {
					console.log(error);
				})
			})
			.catch((error) => {
				console.log(error);
			})
		},
		getAllComments: function(projectId) {

			$('#comments').LoadingOverlay('show');

			this.getComments(projectId)
			.then((response) => {

				this.latestComments = false;
				this.allComments = true;
				this.comments = response.data;
			})
			.catch((error) => {
				console.log(error);
			})
			.finally(() => {
				$('#comments').LoadingOverlay('hide');
			})
		}
	}
})


// function getComments(url, projectId) {

// 	$.ajax({
// 		url: url+'/account/schools/projects/'+projectId+'/comments',
// 		type:'GET',
// 		beforeSend: function() {
// 			$('#schoolComments').LoadingOverlay('show');
// 		},
// 		success: function(result) {
			
// 			let html = '';

// 			$.each(result, function(index, value) 
// 			{
// 				html += '<div class="row mb-n4">';
// 					html += '<div class="col-md">';
// 						html += '<div class="jumbotron jumbotron-fluid pt-1 pb-1">';
// 							html += '<div class="container">';
// 								html += '<h6 class="mb-0" style="font-size: 14px;">'+value.name+'</h6>';
// 								html += '<div class="mt-0" style="font-size: 14px;">'+value.comment+'</div>';
// 							html += '</div>';
// 						html += '</div>';
// 					html += '</div>';
// 				html += '</div>';
// 			});

// 			$('#schoolComments').html(html);
// 			$('#schoolComments').LoadingOverlay('hide');
// 		}
// 	});
// }

// $(function(){
	
// 	var baseUrl = 'http://localhost/school/public';
	
// 	$('.commentField').keypress(function(event) {
// 	    var keycode = (event.keyCode ? event.keyCode : event.which);
// 	    if(keycode == '13') {
	        
// 	        let projectId = $(this).data('id');
// 	    	let comment = $(this).val();

// 	    	let data = {
// 	    		projectId: projectId,
// 	    		comment: comment
// 	    	}

// 	    	$.ajax({
// 			    headers: {
// 			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// 			    }, 	    		
// 	    		url: baseUrl+'/account/schools/projects/comments/add',
// 	    		type: 'POST',
// 	    		data: data,
// 	    		beforeSend: function() {
// 			    	$('#commentField'+projectId).prop('disabled', true);
// 			    	$('#commentField'+projectId).LoadingOverlay('show');
// 	    		},
// 	    		success: function(result) {

// 	    			$("#commentField"+projectId).val('');
// 	    			$('#commentField'+projectId).prop('disabled', false);
// 	    			$('#commentField'+projectId).LoadingOverlay('hide');

// 	    			getComments(baseUrl, projectId);

// 	    		},
// 	    		error: function(request, status, error) {

// 	    			let res = JSON.parse(request.responseText);

// 			        if(res.errors.comment) {

// 				    	$('#commentField'+projectId).prop('disabled', false);
// 				    	$('#commentField'+projectId).LoadingOverlay('hide');

// 			        	$('#commentField'+projectId).addClass('is-invalid');
// 			        	$('#errorComment'+projectId).addClass('invalid-feedback');
// 			        	$('#errorComment'+projectId).html(res.errors.comment);
// 			        }	    			
// 	    		}
// 	    	});
// 	    }
// 	});

// });