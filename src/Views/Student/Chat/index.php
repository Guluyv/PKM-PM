<?php 
$pageTitle = "Chat";
$showBackButton = true;
include '../../layouts/student/header.php';
?>

<div class="px-4 py-4">
    <!-- Chat List Section -->
    <div class="mb-4">
        <h1 class="text-xl font-bold text-gray-800 mb-4">Chat Konseling</h1>
        
        <!-- Start New Chat Button -->
        <a href="<?= BASE_URL ?>/student/chat/room/new" 
           class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg mb-6">
            Mulai Chat Baru
        </a>

        <!-- Chat List -->
        <div class="space-y-3">
            <!-- Active Chat Item -->
            <a href="<?= BASE_URL ?>/student/chat/room/1" 
               class="block bg-white rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-medium text-gray-800">Konselor Anonim</h3>
                        <p class="text-sm text-gray-500 mt-1">Terakhir aktif: 5 menit yang lalu</p>
                    </div>
                    <!-- Unread Badge -->
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        2 pesan baru
                    </span>
                </div>
            </a>

            <!-- Past Chat Item -->
            <a href="<?= BASE_URL ?>/student/chat/room/2" 
               class="block bg-white rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-medium text-gray-800">Konselor Anonim</h3>
                        <p class="text-sm text-gray-500 mt-1">Sesi selesai - 2 hari yang lalu</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include '../../layouts/student/footer.php'; ?>