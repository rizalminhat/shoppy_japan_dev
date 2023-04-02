<x-user-guest-layout>
    <x-auth-card>
       <!-- <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>-->
		{{-- <div class="col-lg-3 d-none d-lg-block">
                <a href="/" class="text-decoration-none">

				<img class="img-fluid" src="{{ asset('main/img/logoshoppyJapan.png') }}" alt="Image">

                </a>
            </div> --}}

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('user.login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>
			<input type="hidden" value="1" name="active">

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>
            @if(!empty($url))
            <input type="hidden" value="{{ $url }}" name="order_url" readonly>
            <input type="hidden" value="{{ $price }}" name="order_price" readonly>
            @endif
			
			<div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="showPwd" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Show Password') }}</span>
                </label>
            </div>
            <!-- Remember Me -->
            <div class="block">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
				 
                  <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('user.register') }}">
                    {{ __('Registered?') }}
                </a>&nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; 
               
				
                @if (Route::has('user.password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('user.password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
			<!--<div class="flex items-center justify-end mt-4">
				 
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('user.register') }}">
                    {{ __('Register New Account') }}
                </a>&nbsp; 
               
				
              

               
            </div>-->
        </form>
    </x-auth-card>
</x-user-guest-layout>
<script>
$(document).ready(function () {
	$("#showPwd").click(function () {
		var x = document.getElementById("password");
	//	var y = document.getElementById("newPwd");
	//	var z = document.getElementById("confirmPwd");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	})
})

</script>
