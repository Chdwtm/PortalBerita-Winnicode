<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Portal Berita') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .breaking-news-container {
            overflow: hidden;
            white-space: nowrap;
        }
        .breaking-news {
            display: inline-block;
            animation: scroll-left 20s linear infinite;
        }
        @keyframes scroll-left {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        @media (max-width: 768px) {
            .mobile-menu-open {
                overflow: hidden;
            }
            .mobile-menu-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }
            .mobile-menu-open .mobile-menu-overlay {
                display: block;
            }
        }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
        /* Custom styles for mobile menu */
        @media (max-width: 1023px) {
            .mobile-menu-open {
                overflow: hidden;
            }
            .mobile-menu-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }
            .mobile-menu-open .mobile-menu-overlay {
                display: block;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Top Bar -->
    <div class="bg-red-600 text-white py-1">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center text-sm">
                <div class="flex items-center justify-center sm:justify-start space-x-4 mb-2 sm:mb-0">
                    <span class="text-xs sm:text-sm">{{ now()->format('l, d F Y') }}</span>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="hover:text-gray-200"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="hover:text-gray-200"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-gray-200"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="flex items-center justify-center sm:justify-end space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-xs sm:text-sm hover:text-gray-200">Login</a>
                        <a href="{{ route('register') }}" class="text-xs sm:text-sm hover:text-gray-200">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-xs sm:text-sm hover:text-gray-200">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline" id="logout-form">
                            @csrf
                            <button type="submit" class="text-xs sm:text-sm hover:text-gray-200 bg-transparent border-0 p-0 cursor-pointer">
                                Logout
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-30">
        <div class="container mx-auto px-4 py-4">
            <!-- Logo and Navigation Container -->
            <div class="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-2xl sm:text-3xl font-bold text-red-600">
                    PORTAL<span class="text-gray-800">BERITA</span>
                </a>
                
                <!-- Desktop Navigation -->
                <nav class="hidden lg:block flex-1 px-6 max-w-4xl overflow-hidden">
                    <div class="flex items-center justify-center">
                        <a href="{{ route('home') }}" class="px-3 py-2 text-sm text-gray-700 hover:text-red-600 whitespace-nowrap">Beranda</a>
                        <div class="flex items-center space-x-1 overflow-x-auto scrollbar-hide">
                            @foreach(\App\Models\Kategori::all() as $kategori)
                                <a href="{{ route('berita.kategori', $kategori) }}" 
                                   class="px-3 py-2 text-sm text-gray-700 hover:text-red-600 whitespace-nowrap">
                                    {{ $kategori->nama }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </nav>
                
                <!-- Search and Mobile Menu -->
                <div class="flex items-center space-x-4">
                    <form action="{{ route('berita.search') }}" method="GET" class="hidden lg:block">
                        <div class="relative">
                            <input type="text" name="q" 
                                   class="bg-gray-100 rounded-full py-2 px-4 pl-10 w-48 xl:w-64 focus:outline-none focus:ring-2 focus:ring-red-600"
                                   placeholder="Cari berita...">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </form>
                    <button class="lg:hidden text-gray-700" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Category Navigation -->
            <div class="lg:hidden mt-4 overflow-x-auto scrollbar-hide">
                <nav class="flex space-x-4 pb-3 px-2">
                    <a href="{{ route('home') }}" class="flex-none px-3 py-2 text-sm text-gray-700 hover:text-red-600 whitespace-nowrap">Beranda</a>
                    @foreach(\App\Models\Kategori::all() as $kategori)
                        <a href="{{ route('berita.kategori', $kategori) }}" 
                           class="flex-none px-3 py-2 text-sm text-gray-700 hover:text-red-600 whitespace-nowrap">
                            {{ $kategori->nama }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" onclick="toggleMobileMenu()"></div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden fixed top-0 right-0 w-4/5 sm:w-64 h-full bg-white shadow-lg z-50 transform transition-transform duration-300 ease-in-out translate-x-full">
        <div class="p-4">
            <button onclick="toggleMobileMenu()" class="absolute top-4 right-4 text-gray-700">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <div class="mt-12">
                <form action="{{ route('berita.search') }}" method="GET" class="mb-6">
                    <div class="relative">
                        <input type="text" name="q" 
                               class="w-full bg-gray-100 rounded-full py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-red-600"
                               placeholder="Cari berita...">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </form>
                <nav class="space-y-4">
                    <a href="{{ route('home') }}" class="block text-gray-700 hover:text-red-600 py-2">Beranda</a>
                    @foreach(\App\Models\Kategori::all() as $kategori)
                        <a href="{{ route('berita.kategori', $kategori) }}" 
                           class="block text-gray-700 hover:text-red-600 py-2">
                            {{ $kategori->nama }}
                        </a>
                    @endforeach

                    @auth
                        <a href="{{ route('dashboard') }}" class="block text-gray-700 hover:text-red-600 py-2">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline" id="mobile-logout-form">
                            @csrf
                            <button type="submit" class="w-full text-left text-gray-700 hover:text-red-600 py-2 bg-transparent border-0 cursor-pointer">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block text-gray-700 hover:text-red-600 py-2">Login</a>
                        <a href="{{ route('register') }}" class="block text-gray-700 hover:text-red-600 py-2">Register</a>
                    @endauth
                </nav>
            </div>
        </div>
    </div>

    <!-- Breaking News -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 py-2">
            <div class="flex items-center">
                <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs sm:text-sm font-semibold whitespace-nowrap">BREAKING NEWS</span>
                <div class="ml-4 breaking-news-container flex-1 overflow-hidden">
                    <div class="breaking-news text-gray-700 text-sm">
                        @foreach(\App\Models\Berita::latest()->take(5)->get() as $breakingNews)
                            <span class="mx-4">{{ $breakingNews->judul }}</span> •
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-4 sm:py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-8">
        <div class="container mx-auto px-4 py-8 sm:py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl sm:text-2xl font-bold mb-4">PORTAL<span class="text-red-600">BERITA</span></h3>
                    <p class="text-gray-400 text-sm">Portal berita terpercaya dengan informasi terkini dan akurat.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kategori</h4>
                    <nav class="space-y-2">
                        @foreach(\App\Models\Kategori::all() as $kategori)
                            <a href="{{ route('berita.kategori', $kategori) }}" 
                               class="block text-gray-400 hover:text-white text-sm">
                                {{ $kategori->nama }}
                            </a>
                        @endforeach
                    </nav>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Tautan</h4>
                    <nav class="space-y-2">
                        <a href="#" class="block text-gray-400 hover:text-white text-sm">Tentang Kami</a>
                        <a href="#" class="block text-gray-400 hover:text-white text-sm">Kontak</a>
                        <a href="#" class="block text-gray-400 hover:text-white text-sm">Kebijakan Privasi</a>
                        <a href="#" class="block text-gray-400 hover:text-white text-sm">Syarat dan Ketentuan</a>
                    </nav>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white text-2xl">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white text-2xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white text-2xl">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white text-2xl">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} PortalBerita. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const body = document.body;
            const menu = document.getElementById('mobileMenu');
            body.classList.toggle('mobile-menu-open');
            menu.classList.toggle('hidden');
            menu.classList.toggle('translate-x-full');
        }
    </script>
</body>

</html>