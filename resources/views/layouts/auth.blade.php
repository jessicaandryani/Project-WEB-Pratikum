<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi') - Hotel Del Luna</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Figtree', sans-serif; } /* Anda bisa menggunakan font kustom jika mau */
        .auth-bg {
            background-image: url('https://source.unsplash.com/random/1920x1080/?night,moon,hotel,luxury'); /* Contoh background random */
            background-size: cover;
            background-position: center;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full auth-bg"> {{-- Menggunakan kelas untuk background --}}
    <div class="min-h-full flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-6">
            <div>
                <a href="{{ route('home') }}" class="flex justify-center items-center space-x-3 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center shadow-2xl transform hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-moon text-white text-3xl"></i>
                    </div>
                </a>
                <h1 class="text-center text-4xl font-extrabold tracking-tight text-white">
                    Hotel Del Luna
                </h1>
                <h2 class="mt-3 text-center text-2xl font-bold tracking-tight text-gray-200">
                    @yield('auth_title', 'Selamat Datang Kembali')
                </h2>
            </div>

            {{-- Konten form login atau register akan masuk di sini --}}
            <div class="bg-white bg-opacity-90 backdrop-blur-md dark:bg-gray-800 dark:bg-opacity-90 shadow-2xl rounded-xl p-8 sm:p-10">
                @yield('content')
            </div>

            <div class="text-center">
                @if (Route::currentRouteName() == 'login')
                    <p class="text-sm text-gray-300">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-yellow-400 hover:text-yellow-300">
                        Daftar sekarang
                    </a>
                    </p>
                @elseif (Route::currentRouteName() == 'register')
                     <p class="text-sm text-gray-300">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-yellow-400 hover:text-yellow-300">
                        Masuk di sini
                    </a>
                    </p>
                @endif
                 @if (Route::currentRouteName() != 'home' && Route::currentRouteName() != 'welcome' )
                 <p class="mt-4 text-sm">
                    <a href="{{ route('home') }}" class="font-medium text-gray-400 hover:text-yellow-400">
                        &larr; Kembali ke Beranda
                    </a>
                </p>
                @endif
            </div>

            <p class="mt-8 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} Hotel Del Luna. Semua hak dilindungi.
            </p>
        </div>
    </div>
     @stack('scripts')
</body>
</html>
