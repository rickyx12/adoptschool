import formatDate from '../formatDate.js';
import { BASE_URL } from '../baseUrl.js';


new Vue({
	el: '#schoolsProfile',
	data() {
		return {
			divisions: null,
			errorName: '',
			errorNameMsg: '',
			errorNameShow: false,
			errorAccountablePerson: '',
			errorAccountablePersonMsg: '',
			errorAccountablePersonShow: false,
			errorPosition: '',
			errorPositionMsg: '',
			errorPositionShow: false,
			errorContactNo: '',
			errorContactNoMsg: '',
			errorContactNoShow: false
		}
	},
	methods: {
		getDivision: function() {

			let region = $('#region').val();
			
			let data = {
				region: region
			}

			$('#division').LoadingOverlay('show');

			axios.get(`${BASE_URL}/region/${region}/divisions`, data)
			.then((response) => {
				this.divisions = response.data
			})
			.catch((error) => {
				console.log(error)
			})
			.finally(() => {
				$('#division').LoadingOverlay('hide');
			})
		},
		update: function(schoolId) {

			let name = $('#name').val();
			let region = $('#region').val();
			let division = $('#division').val();
			let schoolType = $('#schoolType').val();
			let accountablePerson = $('#accountablePerson').val();
			let position = $('#position').val();
			let contactNo = $('#contactNo').val();

			$.LoadingOverlay('show');

			let data = {
				schoolId: schoolId,
				name: name,
				region: region,
				division: division,
				schoolType: schoolType,
				accountablePerson: accountablePerson,
				position: position,
				contactNo: contactNo
			}

			axios.post(`${BASE_URL}/account/schools/profile/update`, data)
			.then((response) => {

				Swal.fire(
				  'Success!',
				  'Information successfully updated',
				  'success'
				)

			})
			.catch((error) => {

				if(error.response.data.errors.name) {
					this.errorNameMsg = error.response.data.errors.name[0];
					this.errorName = 'is-invalid';
					this.errorNameShow = true;
				}

				if(error.response.data.errors.accountablePerson) {
					this.errorAccountablePersonMsg = error.response.data.errors.accountablePerson[0];
					this.errorAccountablePerson = 'is-invalid';
					this.errorAccountablePersonShow = true;
				}

				if(error.response.data.errors.position) {
					this.errorPositionMsg = error.response.data.errors.position[0];
					this.errorPosition = 'is-invalid';
					this.errorPositionShow = true;
				}

				if(error.response.data.errors.contactNo) {
					this.errorContactNoMsg = error.response.data.errors.contactNo[0];
					this.errorContactNo = 'is-invalid';
					this.errorContactNoShow = true;
				}

			})
			.finally(() => {
				$.LoadingOverlay('hide');
			})

		}
	}
});

