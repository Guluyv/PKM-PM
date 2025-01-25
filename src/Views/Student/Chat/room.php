<?php 
$pageTitle = "Chat Konselor";
$showBackButton = true;
include '../../layouts/student/header.php';
?>

<div class="flex flex-col h-screen bg-gray-100">
    <!-- Chat Header -->
    <div class="bg-white shadow-sm px-4 py-3 flex items-center">
        <button onclick="history.back()" class="mr-3">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </button>
        <div>
            <h1 class="font-medium text-gray-800">Konselor Anonim</h1>
            <p class="text-xs text-gray-500">Online</p>
        </div>
    </div>

    <!-- Chat Messages -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4">
        <!-- System Message -->
        <div class="flex justify-center">
            <span class="bg-gray-200 text-gray-600 rounded-full px-4 py-1 text-xs">
                Percakapan ini bersifat rahasia
            </span>
        </div>

        <!-- Received Message -->
        <div class="flex items-start">
            <div class="bg-white rounded-lg p-3 shadow-sm max-w-[80%]">
                <p class="text-gray-800">Halo, ada yang bisa saya bantu?</p>
                <span class="text-xs text-gray-500 mt-1">14:22</span>
            </div>
        </div>

        <!-- Sent Message -->
        <div class="flex items-start justify-end">
            <div class="bg-blue-600 text-white rounded-lg p-3 shadow-sm max-w-[80%]">
                <p>Ya, saya ingin berkonsultasi</p>
                <span class="text-xs text-blue-100 mt-1">14:23</span>
            </div>
        </div>
    </div>

    <!-- Chat Input -->
    <div class="bg-white border-t p-4">
        <form class="flex items-center space-x-2">
            <input type="text" 
                   placeholder="Ketik pesan..." 
                   class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:border-blue-500">
            <button type="submit" 
                    class="bg-blue-600 text-white rounded-full p-2 w-10 h-10 flex items-center justify-center">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<?php include '../../layouts/student/footer.php'; ?>