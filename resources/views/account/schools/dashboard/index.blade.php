@extends('main')

@section('schools-dashboard')
  <div class="container">
     <div class="row">
        <div class="four col-md-3">
            <div class="counter-box"> <i class="fa fa-tasks"></i> <span class="counter">{{ count($projects) }}</span>
                <p>Projects</p>
            </div>
        </div>
        <div class="four col-md-3">
            <div class="counter-box"> <i class="fa fa-hands-helping"></i> <span class="counter">{{ count($stakeholders) }}</span>
                <p>Stakeholders</p>
            </div>
        </div>
        <div class="four col-md-3">
            <div class="counter-box"> <i class="fa fa-money-bill"></i> <span class="counter">@money($contributions)</span>
                <p>Contributions</p>
            </div>
        </div>
        <div class="four col-md-3">
            <div class="counter-box"> <i class="fa fa-cogs"></i> <span class="counter">{{ count($onProcess) }}</span>
                <p>On Process</p>
            </div>
        </div>        
    </div>
  </div>
@endsection

@push('schools-dashboard-scripts')
	<link rel="stylesheet" type="text/css" href="{{ url('../resources/css/dashboard.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('../resources/css/fontawesome-free/css/fontawesome.min.css') }}">
@endpush