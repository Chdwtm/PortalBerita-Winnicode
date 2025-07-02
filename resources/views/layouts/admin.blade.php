<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Portal Berita') }} - Admin Dashboard</title>
    
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
        
        @media (max-width: 768px) {
            .sidebar-open {
                overflow: hidden;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }
            .sidebar-open .sidebar-overlay {
                display: block;
            }
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 2px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Sidebar Toggle Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="h-full bg-white border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <span class="text-xl font-bold text-gray-800">Admin<span class="text-red-600">Panel</span></span>
                </a>
                <button onclick="toggleSidebar()" class="md:hidden text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto custom-scrollbar">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-600' : '' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <a href="{{ route('admin.analytics.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.analytics.*') ? 'bg-red-50 text-red-600' : '' }}">
                    <i class="fas fa-chart-line w-5"></i>
                    <span class="ml-3">Analytics</span>
                </a>

                <a href="{{ route('admin.berita.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.berita.*') ? 'bg-red-50 text-red-600' : '' }}">
                    <i class="fas fa-newspaper w-5"></i>
                    <span class="ml-3">Berita</span>
                </a>

                <a href="{{ route('admin.kategori.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.kategori.*') ? 'bg-red-50 text-red-600' : '' }}">
                    <i class="fas fa-tags w-5"></i>
                    <span class="ml-3">Kategori</span>
                </a>

                <a href="{{ route('admin.komentar.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.komentar.*') ? 'bg-red-50 text-red-600' : '' }}">
                    <i class="fas fa-comments w-5"></i>
                    <span class="ml-3">Komentar</span>
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'bg-red-50 text-red-600' : '' }}">
                    <i class="fas fa-users w-5"></i>
                    <span class="ml-3">Users</span>
                </a>
            </nav>

            <!-- User Menu -->
            <div class="border-t border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-circle text-2xl text-gray-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <div class="ml-auto">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-red-600">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="md:ml-64 min-h-screen flex flex-col">
        <!-- Top Bar -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <button onclick="toggleSidebar()" class="md:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" 
                           class="text-gray-500 hover:text-red-600"
                           title="View Site"
                           target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-bell"></i>
                            </button>
                            <!-- Notifications dropdown could be added here -->
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumbs -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
                @yield('breadcrumbs')
            </div>

            <!-- Content -->
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Portal Berita') }}. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    <script>
        function toggleSidebar() {
            const body = document.body;
            const sidebar = document.getElementById('sidebar');
            body.classList.toggle('sidebar-open');
            sidebar.classList.toggle('-translate-x-full');
        }
    </script>

    @stack('scripts')
</body>
</html> 