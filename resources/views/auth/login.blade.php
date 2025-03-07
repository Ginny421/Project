<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#FF2D20] to-[#FFD700] py-8">
        <div class="w-full max-w-4xl bg-white border border-gray-300 rounded-lg shadow-xl flex flex-col lg:flex-row mx-auto h-[85vh]">
            <!-- Branding -->
            <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-[#FF2D20] to-[#FFD700] text-white p-10 rounded-l-lg flex flex-col">
                <div class="flex items-start mb-4">
                    <!-- ปุ่มกลับ -->
                    <a href="/">
                        <img src="img/back_icon.png" alt="Back Icon" class="w-8 h-8" />
                    </a>
                </div>
                <div class="flex flex-col justify-center items-center text-center h-full">
                    <!-- Logo -->
                    <img src="\img\logo1.jpg" alt="Logo" class="mb-4 w-32 h-32 rounded-full">
                    <h1 class="text-4xl font-bold mb-2">ร้านทองเลิศสุวรรณ</h1>
                    <p class="text-sm mb-10">Welcome to the login page. <br>
                        <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                            {{ __('Not registered yet?') }}
                        </a>
                    </p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 bg-white p-8 lg:p-12 rounded-r-lg shadow-lg overflow-y-auto flex flex-col h-full">
                <!-- เลือกภาษา -->
                <div class="relative flex justify-end mb-4">
                    
                </div>

                <div class="flex-col items-center justify-center flex-grow">
                    <h1 class="text-4xl font-bold mb-2 text-red-600 flex flex-col justify-center items-center">LOGIN</h1>

                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div>
                            <x-label for="email" value="{{ __('Email') }}" class="text-[#FF2D20]" />
                            <x-input id="email" class="block mt-1 w-full border-[#FF2D20] text-black focus:ring-[#FFD700] focus:border-[#FFD700] bg-transparent rounded-lg shadow-md px-4 py-3 transition duration-300" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Password') }}" class="text-[#FF2D20]" />
                            <x-input id="password" class="block mt-1 w-full border-[#FF2D20] text-black focus:ring-[#FFD700] focus:border-[#FFD700] bg-transparent rounded-lg shadow-md px-4 py-3 transition duration-300" type="password" name="password" required autocomplete="current-password" />
                        </div>

                        <div class="block mt-4">
                            <label for="remember_me" class="flex items-center text-[#FF2D20]">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-[#FF2D20] hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FFD700]" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-button class="ms-4 bg-[#FFD700] hover:bg-[#FFB700] text-[#7D1414] rounded-lg shadow-md py-2 px-6 transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#FF2D20]">
                                {{ __('Log in') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
