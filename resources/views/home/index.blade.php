@extends('main')

@section('home')
	<div class="container-fluid mt-3">
	  <div class="row">
	  	<div class="col-md-6">
	  		<div id="category" class="ml-3">
	  			
	  			@inject('categoryService','App\Library\Services\Category')
	  			
	  			@foreach($categories as $category)
	  				<h3><i class="{{ $category->icon }} mr-2"></i> {{ strtoupper($category->name) }}</h3>
	  				<div>
	  					<table class="table table-hover">
	  						@foreach($categoryService->getSubCategory($category->id) as $subCategory)
	  							<tr>
	  								<td>{{ $subCategory->name }}</td>
	  								<td>23</td>
	  							</tr>
	  						@endforeach
	  					</table>
	  				</div>
	  			@endforeach
	  		</div>
	  	</div>
	  	<div class="col-md-6">
	  		<h6>SENIOR HIGH SCHOOL LOOKING FOR WORK IMMERSION VENUE & WORK</h6>
	  		<label>We are looking for industry partners who can provide our graduating students and Senior High School graduates with:</label>
	  		<ul>
	  			<li>Work immersion venue</li>
	  			<li>Work</li>
	  		</ul>
	  		<label>We have numerous skilled Senior High School graduates and graduating students waiting for your call.</label>
	  		<img src="{{ url('../resources/img/senior-hi.jpg') }}" class="ml-5" />
	  	</div>
	  </div>
	</div>
@endsection

@push('home-scripts')
    <script src="{{ url('../resources/js/home.js') }}"></script>
@endpush