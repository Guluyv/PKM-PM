<?php
// Cek session dan role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '/login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CeritaYuk Admin Dashboard">
    <title>Admin CeritaYuk - <?= $pageTitle ?? 'Dashboard' ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    <!-- Mobile Top Bar -->
    <div class="lg:hidden">
        <div class="bg-white shadow-sm fixed top-0 left-0 right-0 z-40 px-4 py-3">
            <div class="flex items-center justify-between">
                <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <span class="text-lg font-semibold text-gray-800">CeritaYuk Admin</span>
                
                <!-- Admin Profile -->
                <div x-data="{ profileOpen: false }" class="relative">
                    <button @click="profileOpen = !profileOpen" class="flex items-center">
                        <img src="<?= BASE_URL ?>/assets/images/profiles/<?= $_SESSION['profile_picture'] ?? 'default.jpg' ?>" 
                             alt="Admin" 
                             class="w-8 h-8 rounded-full object-cover">
                    </button>
                    
                    <div x-show="profileOpen" 
                         @click.away="profileOpen = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900"><?= $_SESSION['username'] ?></p>
                            <p class="text-xs text-gray-500"><?= $_SESSION['email'] ?></p>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            Profile
                        </a>
                        <a href="<?= BASE_URL ?>/admin/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            Settings
                        </a>
                        <a href="<?= BASE_URL ?>/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="lg:flex">
        <!-- Desktop Sidebar (include nav.php here) -->
        <?php include 'nav.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 min-h-screen lg:ml-64">
            <!-- Desktop Header -->
            <div class="hidden lg:block bg-white shadow-sm px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-800"><?= $pageTitle ?? 'Dashboard' ?></h1>
                    
                    <!-- Admin Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Search..." 
                                   class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        
                        <!-- Notifications -->
                        <div x-data="{ notifOpen: false }" class="relative">
                            <button @click="notifOpen = !notifOpen" 
                                    class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                                    3
                                </span>
                            </button>
                            
                            <!-- Notifications Panel -->
                            <div x-show="notifOpen" 
                                 @click.away="notifOpen = false"
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-1">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                </div>
                                <!-- Sample notifications -->
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                    <p class="text-sm text-gray-800">New user registration</p>
                                    <p class="text-xs text-gray-500 mt-1">2 minutes ago</p>
                                </a>
                            </div>
                        </div>

                        <!-- Profile -->
                        <div x-data="{ profileOpen: false }" class="relative">
                            <button @click="profileOpen = !profileOpen" 
                                    class="flex items-center space-x-3">
                                <img src="<?= BASE_URL ?>/assets/images/profiles/<?= $_SESSION['profile_picture'] ?? 'default.jpg' ?>" 
                                     alt="Admin" 
                                     class="w-8 h-8 rounded-full object-cover">
                                <span class="text-sm font-medium text-gray-700"><?= $_SESSION['username'] ?></span>
                            </button>
                            
                            <!-- Profile Dropdown -->
                            <div x-show="profileOpen" 
                                 @click.away="profileOpen = false"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1">
                                <a href="<?= BASE_URL ?>/admin/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Profile
                                </a>
                                <a href="<?= BASE_URL ?>/admin/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Settings
                                </a>
                                <a href="<?= BASE_URL ?>/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                                    Logout