
<x-user-guest-layout>
    <x-auth-card>
       <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
		<!--<div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">

				<img class="img-fluid" src="{{ asset('main/img/logoshoppyJapan.png') }}" alt="Image">

                </a>
            </div>-->
		

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('user.register') }}">
            @csrf

            <!-- Name -->
			
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" placeholder="Full Name" class="block mt-1 w-full" type="text" oninput="this.value = this.value.toUpperCase()" name="name" :value="old('name')" required autofocus />
            </div>

			 <!-- Phone No -->
            <div class="mt-4">
                <x-label for="phone" :value="__('Phone No.')" />

                <x-input id="phone" placeholder="Phone No." class="block mt-1 w-full" oninput="this.value=this.value.replace(/[^0-9]/g,'');" type="text" name="phone" :value="old('phone')" required />
            </div>
			
            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" placeholder="Email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
			
			<!-- Permenent Address -->
            <div class="mt-4">
                <x-label for="peraddress" :value="__('Permanent Address')" />

                <x-input id="peraddress1" placeholder="Address 1" class="block mt-1 w-full" oninput="this.value = this.value.toUpperCase()" type="text" name="peraddress1" :value="old('peraddress1')" required />
				<x-input id="peraddress2" placeholder="Address 2" class="block mt-1 w-full" oninput="this.value = this.value.toUpperCase()" type="text" name="peraddress2" :value="old('peraddress2')" />
				<x-input id="peraddress3" placeholder="Address 3" class="block mt-1 w-full" oninput="this.value = this.value.toUpperCase()" type="text" name="peraddress3" :value="old('peraddress3')" />
            </div>
			
			 <!-- Postcode -->
            <div class="mt-4">
                <x-label for="perpostcode" :value="__('Postcode')" />

                <x-input id="perpostcode" placeholder="Postcode" class="block mt-1 w-full" type="text" oninput="this.value = this.value.toUpperCase()" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="perpostcode" :value="old('perpostcode')" required />
            </div>
			
			 <!-- City -->
            <div class="mt-4">
                <x-label for="percity" :value="__('City')" />

                <x-input id="percity" oninput="this.value = this.value.toUpperCase()" placeholder="City" class="block mt-1 w-full" type="text" name="percity" :value="old('percity')" required />
            </div>
			
			<div class="mt-4">
                <x-label for="perstate" :value="__('State')" />
				
				
				
            <select name="perstate" id="perstate" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
				
				
                <option value="" @if (old('perstate') == "") {{ 'selected' }} @endif>Choose</option>
				@foreach($liststate as $liststate)
											
					<option value="{{$liststate->state_in}}">{{ strtoupper($liststate->state_name) }}</option>								
													
				@endforeach
               <!-- <option value="1" @if (old('perstate') == "1") {{ 'selected' }} @endif>Johor</option>
                <option value="2" @if (old('perstate') == "2") {{ 'selected' }} @endif>Kedah</option>-->
            </select>
				
				
				

              <!--  <x-input id="perstate" placeholder="State" class="block mt-1 w-full" type="text" name="perstate" :value="old('perstate')" required />
				
				
				<select class="block mt-1 w-full">
													<option>Choose option</option>
													<option>Option one</option>
													<option>Option two</option>
													<option>Option three</option>
													<option>Option four</option>
												</select>-->
            </div>
			
			<div class="mt-4">
                <x-label for="percountry" :value="__('Country')" />

              <!--  <x-input id="percountry" placeholder="Country" class="block mt-1 w-full" type="text" name="percountry" :value="old('percountry')" required /> -->
				 <select name="percountry" id="percountry" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
              
                <option value="132" @if (old('percountry') == "132") {{ 'selected' }} @endif>MALAYSIA</option>
                <!--<option value="2" @if (old('percountry') == "2") {{ 'selected' }} @endif>Kedah</option>-->
            </select>
            </div>
            
			<!-- Mailing Address -->
			 
            <div class="mt-4">
                <x-label for="mailaddress" :value="__('Mailing Address')" />
				<input type="checkbox" id="myCheck" onclick="myFunction()"> Same as Permanent Address
				

                <x-input id="mailaddress1" placeholder="Address 1" class="block mt-1 w-full" oninput="this.value = this.value.toUpperCase()" type="text" name="mailaddress1" :value="old('mailaddress1')" required />
				<x-input id="mailaddress2" placeholder="Address 2" class="block mt-1 w-full" oninput="this.value = this.value.toUpperCase()" type="text" name="mailaddress2" :value="old('mailaddress2')" />
				<x-input id="mailaddress3" placeholder="Address 3" class="block mt-1 w-full" oninput="this.value = this.value.toUpperCase()" type="text" name="mailaddress3" :value="old('mailaddress3')" />
            </div>
            
			 <div class="mt-4">
                <x-label for="mailpostcode" :value="__('Postcode')" />

                <x-input id="mailpostcode" placeholder="Postcode" class="block mt-1 w-full" type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="mailpostcode" :value="old('mailpostcode')" required />
            </div>
			
			 <!-- City -->
            <div class="mt-4">
                <x-label for="mailcity" :value="__('City')" />

                <x-input id="mailcity" oninput="this.value = this.value.toUpperCase()" placeholder="City" class="block mt-1 w-full" type="text" name="mailcity" :value="old('mailcity')" required />
            </div>
			
			<div class="mt-4">
                <x-label for="mailstate" :value="__('State')" />
				
				
				
            <select name="mailstate" id="mailstate" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
				
				
                <option value="" @if (old('mailstate') == "") {{ 'selected' }} @endif>Choose</option>
				@foreach($liststate2 as $liststate2)
											
					<option value="{{$liststate2->state_in}}">{{ strtoupper($liststate2->state_name) }}</option>								
													
				@endforeach
               <!-- <option value="1" @if (old('perstate') == "1") {{ 'selected' }} @endif>Johor</option>
                <option value="2" @if (old('perstate') == "2") {{ 'selected' }} @endif>Kedah</option>-->
            </select>
				
            </div>
			
			<div class="mt-4">
                <x-label for="mailcountry" :value="__('Country')" />

              <!--  <x-input id="percountry" placeholder="Country" class="block mt-1 w-full" type="text" name="percountry" :value="old('percountry')" required /> -->
				 <select name="mailcountry" id="mailcountry" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
              
                <option value="132" @if (old('mailcountry') == "132") {{ 'selected' }} @endif>MALAYSIA</option>
                <!--<option value="2" @if (old('percountry') == "2") {{ 'selected' }} @endif>Kedah</option>-->
            </select>
            </div>
			
            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

			<div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="showPwd" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Show Password') }}</span>
                </label>
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('user.login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-user-guest-layout>
<script>
  function myFunction() {
    var checkBox = document.getElementById("myCheck");  
    var peradd1 = document.getElementById("peraddress1");  
	var peradd2 = document.getElementById("peraddress2");   
	var peradd3 = document.getElementById("peraddress3"); 
	var perpost = document.getElementById("perpostcode"); 
	var percity = document.getElementById("percity"); 
	var perstate = document.getElementById("perstate"); 
	  
    var mailadd1 = document.getElementById("mailaddress1"); 
	var mailadd2 = document.getElementById("mailaddress2"); 
	var mailadd3 = document.getElementById("mailaddress3"); 
	var mailpost = document.getElementById("mailpostcode"); 
	var mailcity = document.getElementById("mailcity"); 
	var mailstate = document.getElementById("mailstate");
    if (checkBox.checked == true){
          mailadd1.value=peradd1.value;
		  mailadd2.value=peradd2.value;
		  mailadd3.value=peradd3.value;
		  mailpost.value=perpost.value;
		  mailcity.value=percity.value;
		  mailstate.value=perstate.value;
    } else {
          mailadd1.value="";
		  mailadd2.value="";
		  mailadd3.value="";
		  mailpost.value="";
		  mailcity.value="";
		  mailstate.value="";
    }
  }
	
	$(document).ready(function () {
		$("#showPwd").click(function () {
			var x = document.getElementById("password");
			var y = document.getElementById("password_confirmation");
		//	var z = document.getElementById("confirmPwd");
			if (x.type === "password") {
				x.type = "text";
				y.type = "text";
			} else {
				x.type = "password";
				y.type = "password";
			}
		})
	})


</script>
