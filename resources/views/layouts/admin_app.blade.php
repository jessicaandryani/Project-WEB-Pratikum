<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100"> {{-- Menggunakan bg-gray-100 untuk admin --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Hotel Del Luna') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Figtree', sans-serif; } /* Contoh jika Figtree adalah font utama Anda */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full">
    <div class="min-h-full">
        <div class="sticky top-0 z-40 bg-white shadow-sm border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white">
                                {{-- Ganti dengan ikon admin atau logo hotel --}}
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <span class="text-xl font-semibold text-gray-800 dark:text-white">HOTEL DEL LUNA <span class="text-sm text-indigo-600">Admin</span></span>
                        </a>
                    </div>

                    <div class="flex-1 ml-6 hidden md:block">
                        <h1 class="text-lg font-medium text-gray-700 dark:text-gray-200">@yield('page-title', 'Admin Dashboard')</h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button class="p-2 text-gray-400 hover:text-gray-500 dark:text-gray-300 dark:hover:text-white relative">
                            <i class="fas fa-bell text-lg"></i>
                            {{-- Contoh badge notifikasi --}}
                            {{-- <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span> --}}
                        </button>

                        @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                <div class="w-8 h-8 bg-indigo-200 dark:bg-indigo-500 rounded-full flex items-center justify-center">
                                    <span class="text-indigo-700 dark:text-indigo-100 font-medium text-sm">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                                </div>
                                <span class="hidden md:block text-sm font-medium text-gray-700 dark:text-gray-200">{{ Auth::user()->name ?? 'Admin' }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-400 dark:text-gray-500"></i>
                            </button>

                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border dark:border-gray-700 py-1 z-50"
                                 x-cloak>
                                
                                <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-user-circle mr-3 text-gray-400 dark:text-gray-500"></i>
                                    Profil Saya
                                </a>
                                {{-- Tambahkan link admin-specific settings jika ada --}}
                                {{-- <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-cog mr-3 text-gray-400 dark:text-gray-500"></i>
                                    Pengaturan Admin
                                </a> --}}
                                <hr class="my-1 dark:border-gray-700">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-700/50">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <main class="flex-1">
            {{-- Konten utama halaman akan dimasukkan di sini --}}
            @yield('content')
        </main>

        <footer>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} Hotel Del Luna. Dirancang dengan keajaiban.</p>
            </div>
        </footer>
    </div>

    @yield('scripts') {{-- Untuk script tambahan per halaman --}}
</body>
</html>
