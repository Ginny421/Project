<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ร้านจำนำทอง</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @livewire('wellcome-navigation-menu')

    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold text-center">รายชื่อลูกค้าที่มาใช้บริการ</h1>
        <div class="mt-6">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">ชื่อ</th>
                        <th class="border px-4 py-2">เบอร์โทร</th>
                        <th class="border px-4 py-2">ที่อยู่</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr class="text-center">
                            <td class="border px-4 py-2">{{ $customer->name }}</td>
                            <td class="border px-4 py-2">{{ $customer->phone_number }}</td>
                            <td class="border px-4 py-2">{{ $customer->address }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @livewire('footer')
</body>
</html>
