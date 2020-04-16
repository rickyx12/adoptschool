import { BASE_URL } from '../baseUrl.js';


new Vue({ 
	el: '#stakeholdersProfile',
	data: function() 
	{
		return {
			errorName: false,
			errorNameClass: '',
			errorNameMsg: '',
			subsectors:[]
		}
	},
	methods:{
		getSubSector: function() {
			
			$('#subSector').LoadingOverlay('show');

			let sector = $('#sector').val();

			axios.get(`${BASE_URL}/stakeholders/sector/${sector}/subsector`)
			.then((response) => {
				this.subsectors = response.data;
			})
			.catch((error) => {
				console.log(error);
			})
			.finally(() => {
				$('#subSector').LoadingOverlay('hide');
			})

		},
		save: function(stakeholderId) {

			let name = $('#name').val();
			let sector = $('#sector').val();
			let subSector = $('#subSector').val();

			let data = {
				name: name,
				sector: sector,
				subSector: subSector,
				stakeholderId: stakeholderId
			}

			$.LoadingOverlay('show');

			axios.post(`${BASE_URL}/account/stakeholders/profile/update`, data)
			.then((response) => {
				
					Swal.fire(
					  'Success!',
					  'Successfully updated',
					  'success'
					)				
			})
			.catch((error) => {
				
				if(error.response.data.errors.name) {
					this.errorName = true;
					this.errorNameClass = 'is-invalid';
					this.errorNameMsg = error.response.data.errors.name[0];
				}
			})
			.finally(() => {
				$.LoadingOverlay('hide')
			})
		}
	}		
})



