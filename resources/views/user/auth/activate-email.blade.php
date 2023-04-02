<x-user-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
			
			
			@if(isset($activeexist))
			{{ __('Email Successfully Verified. Pleasa Login.') }}
			<div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('user.login') }}">
                    {{ __('Login') }}
                </a>

                
            </div>
			
			 @else
			{{ __('Invalid User Email. Please Try Again.') }}				  
			@endif
            
        </div>

       

       <!-- <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('user.verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('user.logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Log Out') }}
                </button>
            </form> -->
        </div>
    </x-auth-card>
</x-user-guest-layout>
