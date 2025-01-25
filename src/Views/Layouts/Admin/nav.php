<?php
// Tentukan halaman aktif
$currentPath = $_SERVER['REQUEST_URI'];
$basePath = '/ceritayuk';
$currentPath = str_replace($basePath, '', $currentPath);

// Fungsi untuk mengecek halaman aktif
function isActive($path) {
    global $currentPath;
    return strpos($currentPath, $path) === 0 ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50';
}

// Menu items untuk admin
$menuItems = [
    [
        'path' => '/admin/dashboard',
        'icon' => 'fas fa-home',
        'label' => 'Dashboard'
    ],
    [
        'path' => '/admin/users',
        'icon' => 'fas fa-users',
        'label' => 'Users'
    ],
    [
        'path' => '/admin/content',
        'icon' => 'fas fa-book',
        'label' => 'Content'
    ],
    [
        'path' => '/admin/chat',
        'icon' => 'fas fa-comments',
        'label' => 'Chat'
    ],
    [
        'path' => '/admin/reports',
        'icon' => 'fas fa-chart-bar',
        'label' => 'Reports'
    ]
];
?>

<!-- Desktop Sidebar Navigation -->
<nav class="hidden lg:block">
    <div class="space-y-1">
        <?php foreach ($menuItems as $item): ?>
            <a href="<?= BASE_URL . $item['path'] ?>" 
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-150 ease-in-out <?= isActive($item['path']) ?>">
                <i class="<?= $item['icon'] ?> w-5"></i>
                <span class="ml-3"><?= $item['label'] ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</nav>

<!-- Mobile Navigation -->
<nav class="lg:hidden">
    <!-- Top Bar -->
    <div class="bg-white shadow-sm fixed top-0 left-0 right-0 z-50 px-4 py-3">
        <div class="flex items-center justify-between">
            <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <span class="text-lg font-semibold">CeritaYuk Admin</span>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center">
                    <img src="<?= BASE_URL ?>/assets/images/profiles/default.jpg" 
                         alt="Profile" 
                         class="w-8 h-8 rounded-full">
                </button>
                <!-- Profile Dropdown -->
                <div x-show="open" 
                     @click.away="open = false"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1">
                    <a href="<?= BASE_URL ?>/admin/profile" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                    <a href="<?= BASE_URL ?>/logout" 
                       class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Menu -->
    <div id="mobile-sidebar" 
         class="fixed inset-0 z-40 hidden" 
         role="dialog" 
         aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

        <!-- Sidebar Panel -->
        <div class="fixed inset-y-0 left-0 flex max-w-xs w-full bg-white">
            <div class="w-64 flex flex-col">
                <!-- Sidebar Header -->
                <div class="px-4 py-6 flex items-center justify-between">
                    <span class="text-xl font-bold text-blue-600">CeritaYuk</span>
                    <button id="close-sidebar" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Navigation Items -->
                <div class="flex-1 px-2 py-4 space-y-1">
                    <?php foreach ($menuItems as $item): ?>
                        <a href="<?= BASE_URL . $item['path'] ?>" 
                           class="flex items-center px-4 py-3 rounded-lg transition-colors duration-150 ease-in-out <?= isActive($item['path']) ?>">
                            <i class="<?= $item['icon'] ?> w-5"></i>
                            <span class="ml-3"><?= $item['label'] ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</nav>