<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-[#D43F00] to-[#FFC107] py-8">
        <div class="w-full max-w-4xl bg-white border border-gray-300 rounded-lg shadow-xl flex flex-col lg:flex-row mx-auto h-[85vh]">
            <!-- Branding -->
            <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-[#D43F00] to-[#FFC107] text-white p-10 rounded-l-lg flex flex-col justify-center ">
                <div class="flex justify-start mb-4">
                    <!-- ปุ่ม กลับ -->
                    <a href="/">
                        <img src="img/back_icon.png" alt="Back Icon" class="w-8 h-8" />
                    </a>
                </div>
                <div class="flex flex-col justify-center items-center text-center h-full">
                    <!-- Logo -->
                    <img src="img\logo1.jpg" alt="Logo" class="mb-4 w-32 h-32 rounded-full">
                    <h1 class="text-4xl font-bold mb-2">ร้านทองเลิศสุวรรณ</h1>
                    <p class="text-sm mb-10">Create your account. It’s free and only takes a minute.
                    <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                    </p>
                </div>
            </div>

            <!-- Form -->
            <div class="w-full lg:w-1/2 bg-white p-10 rounded-r-lg shadow-lg flex flex-col justify-center items-center">
                <form method="POST" action="{{ route('register') }}" class="space-y-6 w-full">
                    @csrf

                    <div>
                        <h1 class="text-4xl font-bold mb-2 text-red-600 flex flex-col justify-center items-center">register</h1>
                    </div>

                    <!-- Name -->
                    <div>
                        <x-label for="name" value="{{ __('Name') }}" class="text-red-600" />
                        <x-input id="name" class="block mt-1 w-full border-2 border-[#FFC107] focus:ring-red-500 p-3" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" class="text-red-600" />
                        <x-input id="email" class="block mt-1 w-full border-2 border-[#FFC107] focus:ring-red-500 p-3" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-label for="password" value="{{ __('Password') }}" class="text-red-600" />
                        <x-input id="password" class="block mt-1 w-full border-2 border-[#FFC107] focus:ring-red-500 p-3" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-red-600" />
                        <x-input id="password_confirmation" class="block mt-1 w-full border-2 border-[#FFC107] focus:ring-red-500 p-3" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div>
                            <x-label for="terms" class="text-red-600">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />
                                    <div class="ms-2 text-sm text-gray-600">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-red-600 hover:text-red-800">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-red-600 hover:text-red-800">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    <div class="flex items-center justify-center mt-4 space-x-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-button class="bg-red-600 hover:bg-[#FFC107] text-white border-none rounded-md py-2 px-6 transition-all ease-in-out duration-300">
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
