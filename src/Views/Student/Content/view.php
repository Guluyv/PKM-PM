<?php 
$pageTitle = "Detail Materi";
$showBackButton = true;
include '../../layouts/student/header.php';
?>

<div class="pb-20">
    <!-- Content Header -->
    <div class="aspect-w-16 aspect-h-9 relative">
        <img src="<?= BASE_URL ?>/assets/images/content/video1.jpg" 
             alt="Content Thumbnail"
             class="w-full h-64 object-cover">
        <!-- Play button if video -->
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <i class="fas fa-play-circle text-white text-6xl"></i>
        </div>
    </div>

    <!-- Content Info -->
    <div class="p-4">
        <span class="text-xs font-medium text-blue-600">Video</span>
        <h1 class="text-xl font-bold text-gray-800 mt-2">Mengenali Tanda Kekerasan</h1>
        
        <!-- Meta Info -->
        <div class="flex items-center mt-2 text-sm text-gray-500">
            <div class="flex items-center mr-4">
                <i class="fas fa-clock mr-1"></i>
                <span>10 menit</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-eye mr-1"></i>
                <span>1.2k views</span>
            </div>
        </div>

        <!-- Description -->
        <div class="mt-4">
            <h2 class="font-semibold text-gray-800 mb-2">Deskripsi</h2>
            <p class="text-gray-600 text-sm">
                Video ini akan membantu Anda memahami dan mengidentifikasi tanda-tanda kekerasan seksual. 
                Pelajari cara melindungi diri dan orang lain dari potensi kekerasan.
            </p>
        </div>

        <!-- Content -->
        <div class="mt-6">
            <h2 class="font-semibold text-gray-800 mb-2">Materi</h2>
            <div class="prose prose-sm">
                <!-- Content goes here -->
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <h3>Sub Judul 1</h3>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <!-- More content -->
            </div>
        </div>
    </div>
</div>

<?php include '../../layouts/student/footer.php'; ?>