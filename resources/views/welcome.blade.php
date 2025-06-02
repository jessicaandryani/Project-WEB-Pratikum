<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Del Luna - Selamat Datang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="h-full bg-gradient-to-br from-gray-900 via-blue-900 to-purple-900 text-gray-100">
    <nav class="relative z-10 bg-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-moon text-white text-lg"></i>
                        </div>
                        <span class="text-2xl font-bold text-white">Hotel Del Luna</span>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    {{-- Selalu tampilkan Login dan Register di halaman welcome --}}
                    <a href="{{ route('login') }}" class="text-white hover:text-yellow-300 px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-yellow-600 transition duration-200 shadow">
                        Register
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative min-h-screen flex items-center justify-center -mt-20">
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="absolute inset-0 overflow-hidden">
            <div class="stars"></div>
            <div class="stars2"></div>
            <div class="stars3"></div>
        </div>
        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 py-20">
            <div class="max-w-4xl mx-auto">
                <div class="mb-8">
                    <div class="w-24 h-24 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mx-auto shadow-2xl animate-pulse">
                        <i class="fas fa-moon text-white text-4xl"></i>
                    </div>
                </div>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                    Selamat Datang di
                    <span class="block text-yellow-400 tracking-wider">Hotel Del Luna</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-2xl mx-auto">
                    Pengalaman menginap yang magis di bawah cahaya bulan. 
                    Nikmati kemewahan dan ketenangan yang tak terlupakan.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 text-left">
                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-bed text-white text-xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Kamar Mewah</h3>
                        </div>
                        <p class="text-gray-300 text-sm">Kamar dengan pemandangan bulan dan fasilitas premium.</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                         <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-utensils text-white text-xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Restoran Bintang 5</h3>
                        </div>
                        <p class="text-gray-300 text-sm">Kuliner terbaik dengan suasana romantis.</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-spa text-white text-xl"></i>
                            </div>
                             <h3 class="text-lg font-semibold text-white">Spa & Wellness</h3>
                        </div>
                        <p class="text-gray-300 text-sm">Relaksasi total dengan terapi moonlight.</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    {{-- Selalu tampilkan Daftar dan Login untuk CTA utama di welcome page --}}
                    <a href="{{ route('register') }}" class="bg-yellow-500 text-gray-900 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-yellow-400 transition duration-300 shadow-lg transform hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-gray-900 transition duration-300">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </a>
                    {{-- Tombol Pesan Sekarang bisa dipertimbangkan untuk ditampilkan di sini, 
                         atau hanya setelah user login dan masuk ke dashboard.
                         Jika ditampilkan di sini, ia akan mengarah ke halaman login jika user belum login,
                         karena route 'bookings.create' dilindungi middleware auth.
                    --}}
                    <a href="{{ route('bookings.create') }}" class="bg-teal-500 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-teal-600 transition duration-300 shadow-lg transform hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-calendar-plus mr-2"></i>
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white animate-bounce hidden md:block">
            <i class="fas fa-chevron-down text-2xl"></i>
        </div>
    </div>

    <section class="py-20 bg-gray-50 text-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Mengapa Memilih Hotel Del Luna?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Kami tidak hanya menawarkan tempat menginap, tetapi sebuah pengalaman surgawi yang dirancang khusus untuk jiwa-jiwa terpilih.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white text-center p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300">
                    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6 ring-4 ring-yellow-200">
                        <i class="fas fa-concierge-bell text-yellow-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Layanan Eksklusif</h3>
                    <p class="text-gray-600 text-sm">Pelayanan personal 24/7 yang melampaui ekspektasi Anda.</p>
                </div>
                <div class="bg-white text-center p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300">
                     <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 ring-4 ring-blue-200">
                        <i class="fas fa-moon text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Suasana Magis</h3>
                    <p class="text-gray-600 text-sm">Arsitektur unik dan pemandangan malam yang memukau.</p>
                </div>
                <div class="bg-white text-center p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300">
                     <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 ring-4 ring-green-200">
                        <i class="fas fa-utensils text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Kuliner Surgawi</h3>
                    <p class="text-gray-600 text-sm">Restoran dengan hidangan istimewa dari chef ternama.</p>
                </div>
                <div class="bg-white text-center p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6 ring-4 ring-purple-200">
                        <i class="fas fa-spa text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Ketenangan Abadi</h3>
                    <p class="text-gray-600 text-sm">Fasilitas spa dan wellness untuk relaksasi jiwa dan raga.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 items-center">
                <div class="md:col-span-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-moon text-white text-lg"></i>
                        </div>
                        <span class="text-2xl font-bold">Hotel Del Luna</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Temukan keajaiban di setiap sudutnya. Hotel Del Luna, bukan sekadar tempat menginap, melainkan destinasi.
                    </p>
                </div>
                <div class="md:col-span-1">
                    <h3 class="text-lg font-semibold mb-4 text-yellow-400">Navigasi Cepat</h3>
                    <div class="space-y-2">
                        <a href="#" class="block text-gray-300 hover:text-yellow-400 transition duration-200">Tentang Kami</a>
                        <a href="#" class="block text-gray-300 hover:text-yellow-400 transition duration-200">Tipe Kamar</a>
                        <a href="#" class="block text-gray-300 hover:text-yellow-400 transition duration-200">Galeri</a>
                        <a href="#" class="block text-gray-300 hover:text-yellow-400 transition duration-200">Hubungi Kami</a>
                        <a href="#" class="block text-gray-300 hover:text-yellow-400 transition duration-200">Kebijakan Privasi</a>
                    </div>
                </div>
                <div class="md:col-span-1">
                    <h3 class="text-lg font-semibold mb-4 text-yellow-400">Hubungi Kami</h3>
                    <div class="space-y-3 text-gray-300">
                        <p class="flex items-start"><i class="fas fa-map-marker-alt mr-3 mt-1 text-yellow-400"></i>Jl. Bulan Purnama No. 123, Kota Cahaya</p>
                        <p class="flex items-center"><i class="fas fa-phone mr-3 text-yellow-400"></i>+62 21 1234 5678</p>
                        <p class="flex items-center"><i class="fas fa-envelope mr-3 text-yellow-400"></i>reservasi@hoteldelluna.com</p>
                    </div>
                     <div class="flex space-x-4 mt-6">
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition duration-200"><i class="fab fa-facebook-f text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition duration-200"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition duration-200"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-yellow-400 transition duration-200"><i class="fab fa-youtube text-xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} Hotel Del Luna. Dirancang dengan keajaiban.</p>
            </div>
        </div>
    </footer>

    <style>
        .stars, .stars2, .stars3 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        .stars {
            background-image: 
                radial-gradient(2px 2px at 20px 30px, #eee, transparent),
                radial-gradient(2px 2px at 40px 70px, rgba(255,255,255,0.8), transparent),
                radial-gradient(1px 1px at 90px 40px, #fff, transparent),
                radial-gradient(1px 1px at 130px 80px, rgba(255,255,255,0.6), transparent),
                radial-gradient(1px 1px at 160px 120px, #ddd, transparent);
            background-repeat: repeat;
            background-size: 250px 250px;
            animation: zoom 25s infinite;
            opacity: 0;
        }
        .stars2 {
            background-image: 
                radial-gradient(1px 1px at 50px 100px, #fff, transparent),
                radial-gradient(1px 1px at 80px 40px, rgba(255,255,255,0.7), transparent),
                radial-gradient(2px 2px at 180px 80px, #eee, transparent);
            background-repeat: repeat;
            background-size: 350px 350px;
            animation: zoom 35s infinite 7s;
            opacity: 0;
        }
        .stars3 {
            background-image: 
                radial-gradient(1px 1px at 30px 50px, #fff, transparent),
                radial-gradient(1.5px 1.5px at 120px 180px, rgba(255,255,255,0.5), transparent);
            background-repeat: repeat;
            background-size: 450px 450px;
            animation: zoom 45s infinite 14s;
            opacity: 0;
        }
        @keyframes zoom {
            0% { opacity: 0; transform: scale(0.5); animation-timing-function: ease-in; }
            10% { opacity: 1; transform: scale(0.7); animation-timing-function: linear; }
            85% { opacity: 1; transform: scale(1.05); animation-timing-function: linear; }
            100% { opacity: 0; transform: scale(1.2); animation-timing-function: ease-out; }
        }
    </style>
</body>
</html>
