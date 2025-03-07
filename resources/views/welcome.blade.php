<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ร้านทองเลิศสุวรรณ </title>
        <link rel="icon" href="{{ asset('img/logo1.jpg') }}" type="image/x-icon">

        <!-- Font Awesome for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-red-800 via-red-600 to-yellow-500 text-white">
        <div class="min-h-screen flex flex-col items-center justify-center">
            <div class="w-full max-w-4xl px-6 lg:max-w-7xl">
                
                <!-- Header -->
                <header class="flex justify-between items-center py-6 border-b border-yellow-300">
                    <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-white">
                        ร้านทองเลิศสุวรรณ
                    </h1>
                    @if (Route::has('login'))
                        <nav class="flex space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-yellow-200 hover:text-white transition duration-300">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-yellow-200 hover:text-white transition duration-300">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-yellow-200 hover:text-white transition duration-300">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <!-- Hero Section -->
                <section class="mt-10 text-center">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-lg p-10">
                        <h2 class="text-3xl font-semibold">รับจำนำทอง ดอกเบี้ยต่ำ</h2>
                        <p class="mt-4 text-lg">ร้านทองที่คุณวางใจ ให้ราคาดีที่สุด</p>
                        <a href="tel:086-5537119" class="mt-6 inline-block bg-yellow-400 text-red-900 px-6 py-3 rounded-full font-bold text-lg transition hover:bg-yellow-300">
                            📞 ติดต่อเรา
                        </a>
                    </div>
                </section>

                <!-- Services -->
                <section class="mt-12 grid md:grid-cols-3 gap-6">
                    <div class="p-6 bg-white/10 rounded-xl text-center shadow-lg backdrop-blur-md">
                        <i class="fas fa-gem text-4xl text-yellow-300"></i>
                        <h3 class="text-lg font-semibold mt-3">ทองแท้มาตรฐาน</h3>
                        <p class="text-sm mt-2">รับประกันคุณภาพทองแท้ 100%</p>
                    </div>
                    <div class="p-6 bg-white/10 rounded-xl text-center shadow-lg backdrop-blur-md">
                        <i class="fas fa-hand-holding-usd text-4xl text-yellow-300"></i>
                        <h3 class="text-lg font-semibold mt-3">ราคาดีที่สุด</h3>
                        <p class="text-sm mt-2">ให้ราคาสูง คิดดอกเบี้ยต่ำ</p>
                    </div>
                    <div class="p-6 bg-white/10 rounded-xl text-center shadow-lg backdrop-blur-md">
                        <i class="fas fa-shield-alt text-4xl text-yellow-300"></i>
                        <h3 class="text-lg font-semibold mt-3">ปลอดภัย มั่นใจได้</h3>
                        <p class="text-sm mt-2">บริการซื่อตรง เชื่อถือได้</p>
                    </div>
                </section>

                <!-- Footer -->
                <footer class="bg-red-700 text-yellow-200 py-8 mt-12 rounded-t-2xl">
                    <div class="max-w-5xl mx-auto px-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            
                            <!-- ที่อยู่ -->
                            <div>
                                <h5 class="text-lg font-semibold">📍 ที่อยู่</h5>
                                <p class="text-sm mt-2">62/210 ถ.กลางเมือง ต.ในเมือง</p>
                                <p class="text-sm">จ.ขอนแก่น รหัสไปรษณีย์ 40000</p>
                            </div>

                            <!-- ช่องทางติดต่อ -->
                            <div>
                                <h5 class="text-lg font-semibold">📢 ช่องทางติดต่อ</h5>
                                <div class="flex space-x-4 mt-3">
                                    <a href="#" class="hover:text-white transition duration-300">
                                        <i class="fab fa-facebook-f"></i> Facebook
                                    </a>
                                    <a href="#" class="hover:text-white transition duration-300">
                                        <i class="fab fa-twitter"></i> Twitter
                                    </a>
                                    <a href="#" class="hover:text-white transition duration-300">
                                        <i class="fab fa-instagram"></i> Instagram
                                    </a>
                                </div>
                            </div>

                            <!-- เบอร์ติดต่อ -->
                            <div>
                                <h5 class="text-lg font-semibold">☎️ เบอร์ติดต่อ</h5>
                                <p class="text-sm mt-2">
                                    <a href="tel:043-238231" class="hover:text-white transition duration-300">043-238231</a>
                                </p>
                                <p class="text-sm">
                                    <a href="tel:086-5537119" class="hover:text-white transition duration-300">086-5537119</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Copyright -->
                    <div class="mt-6 border-t border-yellow-300 pt-4 text-center">
                        <p class="text-sm">&copy; {{ date('Y') }} ร้านทองเลิศสุวรรณ. All rights reserved.</p>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
