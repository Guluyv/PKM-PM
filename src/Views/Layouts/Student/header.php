<?php
// Cek session
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CeritainAja - Platform Edukasi">
    <title>CeritainAja - <?= $pageTitle ?? 'Platform Edukasi' ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        .aspect-w-16 {
    position: relative;
    padding-bottom: 56.25%;
}
.aspect-w-16 iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
        
    </style>
</head>
<body class="bg-gray-50 no-scrollbar">
    <!-- Header/Top Navigation -->
    <header class="bg-white shadow-sm fixed top-0 left-0 right-0 z-50">
        <div class="max-w-screen mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Left: Back button if needed -->
                <div class="flex items-center">
                    <?php if (isset($showBackButton) && $showBackButton): ?>
                        <button onclick="history.back()" class="mr-4 text-gray-500">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </button>
                    <?php endif; ?>
                    
                    <!-- Title -->
                    <h1 class="text-lg font-semibold text-gray-800">
                        <?= $pageTitle ?? 'CeritainAja' ?>
                    </h1>
                </div>

                <!-- Right: Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div x-data="{ notifOpen: false }" class="relative">
                        <button @click="notifOpen = !notifOpen" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bell text-xl"></i>
                            <!-- Notification badge if needed -->
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                                2
                            </span>
                        </button>
                        
                        <!-- Notifications dropdown -->
                        <div x-show="notifOpen" 
                             @click.away="notifOpen = false"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-1 z-50">
                            <!-- Notifications list -->
                            <div class="px-4 py-2 border-b border-gray-100">
                                <h3 class="text-sm font-semibold text-gray-900">Notifikasi</h3>
                            </div>
                            <!-- Sample notification -->
                            <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                <p class="text-sm text-gray-800">Materi baru telah ditambahkan</p>
                                <p class="text-xs text-gray-500 mt-1">5 menit yang lalu</p>
                            </a>
                        </div>
                    </div>

                    <!-- Profile -->
                    <div x-data="{ profileOpen: false }" class="relative">
                        <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2">
                            <img src="<?= BASE_URL ?>/assets/images/profiles/<?= $_SESSION['profile_picture'] ?? 'default.jpg' ?>" 
                                 alt="Profile" 
                                 class="w-8 h-8 rounded-full object-cover">
                        </button>
                        
                        <!-- Profile dropdown -->
                        <div x-show="profileOpen" 
                             @click.away="profileOpen = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900"><?= $_SESSION['username'] ?></p>
                                <p class="text-xs text-gray-500"><?= $_SESSION['email'] ?></p>
                            </div>
                            <a href="<?= BASE_URL ?>/student/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Profile
                            </a>
                            <a href="<?= BASE_URL ?>/student/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
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
    </header>

    <!-- Main Content Wrapper -->
    <main class="pt-16 pb-20">