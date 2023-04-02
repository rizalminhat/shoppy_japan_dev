@extends('user.layouts.main')
@section('content')
<li class="breadcrumb-item"><a href="{{ route('user.profile') }}">Profile</a></li>
</ol>
</nav>
        <!-- page content -->
        <div class="page-title">
  <div class="title_left">
    <h3>Profile</h3>
  </div>

  
</div>
            
<div class="clearfix"></div>

<div class="row">
	<div class="col-md-12 col-sm-12 ">
		<div class="x_panel">
			<div class="x_title">
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					{{-- <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="#">Settings 1</a>
						<a class="dropdown-item" href="#">Settings 2</a>
						</div>
					</li> --}}
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="col-md-12 col-sm-12 ">
					<form action="{{ route('user.updateprofile')}}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
						@csrf
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Profile Image <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 ">
								<div class="profile_img">
									<div id="crop-avatar">
										<!-- Current avatar -->
										<img class="img-responsive avatar-view" src="{{ (!empty($userinfo->user_image) ?  asset('storage/upload/user_image/'.$userinfo->user_image): asset('main/img/person_icon.png'))}}" alt="user-img" title="Change the avatar" width="150px"/>
									</div>
								</div>
								<a href="{{ route('user.viewprofileimg') }}" class="btn btn-sm btn-primary my-2">Update Profile Image</a>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Name <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 ">
								<input type="text" id="name" value="{{$userinfo->name}}" name="name" required="required" oninput="this.value = this.value.toUpperCase()" class="form-control ">
								<input id="user_id" class="form-control" type="hidden" name="user_id" value="{{ $userinfo->id }}">
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Phone No. <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 ">
								<input type="text" id="phone" value="{{$userinfo->phone}}" name="phone" required="required" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="form-control ">
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Email <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 ">
								<input type="text" id="email" value="{{$userinfo->email}}" name="email" required="required" readonly="readonly" class="form-control ">
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Permanent Address <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 ">
								<input type="text" id="address1" value="{{$userinfo->address1}}" name="address1" placeholder="Address 1" oninput="this.value = this.value.toUpperCase()" required="required" class="form-control ">
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">
							</label>
							<div class="col-md-6 col-sm-6 ">
								<input type="text" id="address2" value="{{$userinfo->address2}}" name="address2"  oninput="this.value = this.value.toUpperCase()" placeholder="Address 2" class="form-control ">
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">
							</label>
							<div class="col-md-6 col-sm-6 ">
								<input type="text" id="address3" value="{{$userinfo->address3}}" name="address3"  oninput="this.value = this.value.toUpperCase()" placeholder="Address 3" class="form-control ">
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Postcode <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 ">
								<input type="text" id="postcode" value="{{$userinfo->postcode}}" name="postcode" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Postcode" required="required" class="form-control ">
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">City <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6 ">
								<input type="text" id="city" value="{{$userinfo->city}}" name="city" oninput="this.value = this.value.toUpperCase()" placeholder="City" required="required" class="form-control ">
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">State <span class="text-danger">*</span></label>
							<div class="col-md-6 col-sm-6 ">
								<select name="state" id="state" class="form-control" required>
									<option value="">--PLEASE CHOOSE--</option>
									@foreach($liststate as $liststate)
									<option value="{{$liststate->state_in}}" @if ($userinfo->state == $liststate->state_in) {{ 'selected' }} @endif>{{ strtoupper($liststate->state_name) }}</option>	
									@endforeach
								</select>
							</div>
						</div>
				                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Country <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												 <select name="country" id="country" class="form-control" required>
                
				@foreach($listcountry as $listcountry)
							<option value="{{$listcountry->country_id}}" @if ($userinfo->country == $listcountry->country_id) {{ 'selected' }} @endif>{{ strtoupper($listcountry->country_name) }}</option>	
				@endforeach
            </select>
											</div>
										</div>
										@if(!empty($mailingaddress->id))	
						      
											
						             <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Mailing Address <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="mailaddress1" value="{{$mailingaddress->address1}}" name="mailaddress1" placeholder="Mailing Address 1" oninput="this.value = this.value.toUpperCase()" required="required" class="form-control ">
												 <input id="mailing_id" class="form-control" type="hidden" name="mailing_id" value="{{ $mailingaddress->id }}">
											</div>
										</div>
				                       <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="mailaddress2" value="{{$mailingaddress->address2}}" name="mailaddress2"  oninput="this.value = this.value.toUpperCase()" placeholder="Mailing Address 2" class="form-control ">
											</div>
											
											
										</div>
				                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="mailaddress3" value="{{$mailingaddress->address3}}" name="mailaddress3"  oninput="this.value = this.value.toUpperCase()" placeholder="Mailing Address 3" class="form-control ">
											</div>
											
											
										</div>
						        
						                 <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Postcode <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="mailpostcode" value="{{$mailingaddress->postcode}}" name="mailpostcode" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Mailing Postcode" required="required" class="form-control ">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">City <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="mailcity" value="{{$mailingaddress->city}}" name="mailcity" oninput="this.value = this.value.toUpperCase()" placeholder="Mailing City" required="required" class="form-control ">
											</div>
										</div>
				                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">State <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												 <select name="mailstate" id="mailstate" class="form-control" required>
                <option value="">--PLEASE CHOOSE--</option>
				@foreach($liststate2 as $liststate2)
							<option value="{{$liststate2->state_in}}" @if ($mailingaddress->state == $liststate2->state_in) {{ 'selected' }} @endif>{{ strtoupper($liststate2->state_name) }}</option>	
				@endforeach
            </select>
											</div>
										</div>
				                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Country <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												 <select name="mailcountry" id="mailcountry" class="form-control" required>
                
				@foreach($listcountry2 as $listcountry2)
							<option value="{{$listcountry2->country_id}}" @if ($mailingaddress->country == $listcountry2->country_id) {{ 'selected' }} @endif>{{ strtoupper($listcountry2->country_name) }}</option>	
				@endforeach
            </select>
											</div>
										</div>
						              @else	
				                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Mailing Address <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="mailaddress1" name="mailaddress1" placeholder="Mailing Address 1" oninput="this.value = this.value.toUpperCase()" required="required" class="form-control ">
												
											</div>
											
											
										</div>
				                      <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="mailaddress2"  name="mailaddress2"  oninput="this.value = this.value.toUpperCase()" placeholder="Mailing Address 2" class="form-control ">
											</div>
											
											
										</div>
				                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="mailaddress3"  name="mailaddress3"  oninput="this.value = this.value.toUpperCase()" placeholder="Mailing Address 3" class="form-control ">
											</div>
											
											
										</div>
						        
						                 <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Postcode <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="mailpostcode"  name="mailpostcode" oninput="this.value = this.value.toUpperCase()" placeholder="Mailing Postcode" required="required" class="form-control ">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">City <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="mailcity" name="mailcity" oninput="this.value = this.value.toUpperCase()" placeholder="Mailing City" required="required" class="form-control ">
											</div>
										</div>
				 <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">State <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												 <select name="mailstate" id="mailstate" class="form-control" required>
                <option value="">--PLEASE CHOOSE--</option>
				@foreach($liststate2 as $liststate2)
							<option value="{{$liststate2->state_in}}">{{ strtoupper($liststate2->state_name) }}</option>	
				@endforeach
            </select>
											</div>
										</div>
				                        <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Country <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												 <select name="mailcountry" id="mailcountry" class="form-control" required>
                
				@foreach($listcountry2 as $listcountry2)
							<option value="{{$listcountry2->country_id}}">{{ strtoupper($listcountry2->country_name) }}</option>	
				@endforeach
            </select>
											</div>
										</div>
				
							@endif
						  
										<!--<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align">Gender</label>
											<div class="col-md-6 col-sm-6 ">
												<div id="gender" class="btn-group" data-toggle="buttons">
													<label class="btn btn-secondary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
														<input type="radio" name="gender" value="male" class="join-btn"> &nbsp; Male &nbsp;
													</label>
													<label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
														<input type="radio" name="gender" value="female" class="join-btn"> Female
													</label>
												</div>
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align">Date Of Birth <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input id="birthday" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
												<script>
													function timeFunctionLong(input) {
														setTimeout(function() {
															input.type = 'text';
														}, 60000);
													}
												</script>
											</div>
										</div> -->
										<div class="ln_solid"></div>
				<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<!--<button class="btn btn-primary" type="button">Cancel</button>-->
												<button class="btn btn-primary" type="reset">RESET</button>
												 
												<button type="submit" class="btn btn-success">SAVE</button>
											</div>
										</div>
										<!--<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												
												<a href="{{ url('user/order/neworder') }}"><input type="button" class="btn btn-primary" value="Cancel" /></a>
												<button class="btn btn-primary" type="reset">Reset</button>
												<button type="submit" class="btn btn-success">Save</button>
											</div>
										</div>-->

									</form>
          <!-- start of user-activity-graph -->
          
          <!-- end of user-activity-graph -->

          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

        <!-- /page content -->

@endsection
