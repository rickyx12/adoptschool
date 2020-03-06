@extends('main')

@section('school-registration')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5 mt-3">
        <div class="card">
          <div class="card-header bg-info text-white">School Registration</div>
          <div class="card-body">
            <form>
              <div class="form-group">
                <h6>School Name</h6>
                <input type="text" id="schoolName" class="form-control" autocomplete="off">
                <span id="errorName"></span>
              </div>
              <div class="form-group">
                <h6>Region</h6>
                <select id="region" class="form-control">
                  <option value="">Select Region</option>
                  @foreach($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                  @endforeach
                </select>
                <span id="errorRegion"></span>
              </div>
              <div class="form-group">
                <h6>Division</h6>
                <select id="division" class="form-control">
                  <option value="">Select Division</option>
                </select>
                <span id="errorDivision"></span>
              </div>
              <div class="form-group">
                <h6>Type</h6>
                <select id="schoolType" class="form-control">
                  <option value="">Select School Type</option>
                  @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->type }}</option>
                  @endforeach
                </select>
                <span id="errorType"></span>
              </div>
              <div class="form-group">
                <h6>Accountable Person</h6>
                <input type="text" id="accountablePerson" class="form-control" autocomplete="off">
                <span id="errorAccountablePerson"></span>
              </div>
              <div class="form-group">
                <h6>Position</h6>
                <input type="text" id="position" class="form-control" autocomplete="off">
                <span id="errorPosition"></span>
              </div>
              <div class="form-group">
                <h6>Contact#</h6>
                <input type="text" id="contactNo" class="form-control" autocomplete="off">
                <span id="errorContact"></span>
              </div>
              <div class="form-group">
                <h6>Complete Address</h6>
                <textarea  id="address" class="form-control" rows="5" cols="5"></textarea>
                <span id="errorAddress"></span>
              </div>              
              <div class="form-group">
                <h6>Email Address (serve as your username)</h6>
                <input type="email" id="emailAdd" class="form-control" autocomplete="off">
                <span id="errorEmail"></span>
              </div>
              <div class="form-group">
                <h6>Temporary Password (change this later)</h6>
                <input type="text" id="tempPassword" class="form-control" autocomplete="off" value="123456">
                <span id="errorPass"></span>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md">
                    <h6>Anti Bot / Spam</h6>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    @captcha
                    <span style="font-size:13px;">Click the image for new captcha</span>
                  </div>
                  <div class="col-md-7 text-left">
                    <input type="text" id="captcha" class="form-control" placeholder="Enter the captcha here" autocomplete="off">
                    <span id="errorCaptcha"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md text-right">
                  <button id="schoolRegisterBtn" class="btn btn-success">Register</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-7 mt-3">
        <div class="card">
          <div class="card-header bg-info text-white">TAX INCENTIVES FOR DEPED PARTNERS</div>
          <div class="card-body">
            <img src="{{ url('../resources/img/adopt.jpg') }}" align="left" class="mr-3" />
              <b>Department of Education (DepEd)</b> recognizes the important role of the Private Sector in the promotion of quality and accessible education. As a way of recognizing the active involvement of the Private Sector in the implementation of the K to 12 Program which entailed providing various support packages to public schools , the DepEd supports the tax incentivization campaign of the Bureau of Internal Revenue.
              <br><br>
              Through the implementation of the tax incentive provision of <b>Philippine Republic Act No. 8525, “Adopt-a-School Act of 1998”</b>, private entities are given the opportunity to help public schools and these adopting entities become eligible for tax incentive claims, as such entitlement is contained in <b>Republic Act. No. 8525</b>.
              <br><br><br>
              <b>Who are qualified</b>
              <ul>
                <li>Companies</li>
                <li>Business Enterprises</li>
                <li>Foundations</li>
                <li>Civil Society Organizations</li>
                <li>International Organizations and Associations</li>
                <li>Private Schools/Universities/Colleges</li>
                <li>Private Individuals (local and abroad)</li>
              </ul>                          
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('school-registration-scripts')
    <script src="{{ url('../resources/js/school-register.js') }}"></script>
@endpush