<?php
// Tentukan halaman aktif
$currentPath = $_SERVER['REQUEST_URI'];
$basePath = '/ceritayuk';
$currentPath = str_replace($basePath, '', $currentPath);

// Fungsi untuk mengecek halaman aktif
function isActive($path) {
    global $currentPath;
    return strpos($currentPath, $path) === 0 ? 'text-blue-600' : 'text-gray-600';
}
?>

<!-- Bottom Navigation Bar -->
<nav class="bg-white shadow-lg fixed bottom-0 left-0 right-0 z-50">
    <div class="flex justify-around">
        <!-- Home -->
        <a href="<?= BASE_URL ?>/student/home" 
           class="flex flex-col items-center py-2 px-4 <?= isActive('/student/home') ?>">
            <i class="fas fa-home text-xl mb-1"></i>
            <span class="text-xs">Beranda</span>
        </a>

        <!-- Education -->
        <a href="<?= BASE_URL ?>/student/education" 
           class="flex flex-col items-center py-2 px-4 <?= isActive('/student/education') ?>">
            <i class="fas fa-book text-xl mb-1"></i>
            <span class="text-xs">Edukasi</span>
        </a>

        <!-- Chat -->
        <a href="<?= BASE_URL ?>/student/chat" 
           class="flex flex-col items-center py-2 px-4 <?= isActive('/student/chat') ?>">
            <i class="fas fa-comment text-xl mb-1"></i>
            <span class="text-xs">Chat</span>
        </a>

        <!-- Profile -->
        <a href="<?= BASE_URL ?>/student/profile" 
           class="flex flex-col items-center py-2 px-4 <?= isActive('/student/profile') ?>">
            <i class="fas fa-user text-xl mb-1"></i>
            <span class="text-xs">Profil</span>
        </a>
    </div>
</nav>