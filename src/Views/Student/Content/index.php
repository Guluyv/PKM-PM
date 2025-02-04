<?php 
$pageTitle = "Materi Edukasi";
include __DIR__ . '/../../layouts/student/header.php'; ?>


<div class="px-4 py-4">
    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative">
            <input type="text" 
                   placeholder="Cari materi..." 
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
    </div>

    <!-- Categories -->
    <div class="mb-6">
        <div class="flex overflow-x-auto space-x-2 pb-2 no-scrollbar">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm whitespace-nowrap">
                Semua
            </button>
            <button class="bg-white text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap">
                Video
            </button>
            <button class="bg-white text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap">
                Artikel
            </button>
            <button class="bg-white text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap">
                Infografis
            </button>
        </div>
    </div>

    <!-- Content List -->
    <div class="space-y-4">
        <!-- Video Content -->
        <a href="<?= BASE_URL ?>/student/content/view/1" 
           class="block bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="aspect-w-16 aspect-h-9 relative">
                <img src="<?= BASE_URL ?>/assets/images/content/video1.jpg" 
                     alt="Video Thumbnail"
                     class="w-full h-48 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                    <i class="fas fa-play-circle text-white text-4xl"></i>
                </div>
            </div>
            <div class="p-4">
                <span class="text-xs font-medium text-blue-600">Video</span>
                <h3 class="font-semibold text-gray-800 mt-1">Mengenali Tanda Kekerasan</h3>
                <p class="text-sm text-gray-600 mt-1">Pelajari cara mengidentifikasi tanda-tanda kekerasan seksual.</p>
                <div class="flex items-center mt-2 text-sm text-gray-500">
                    <i class="fas fa-clock mr-2"></i>
                    <span>10 menit</span>
                </div>
            </div>
        </a>

        <!-- Article Content -->
        <a href="<?= BASE_URL ?>/student/content/view/2" 
           class="block bg-white rounded-lg shadow-sm overflow-hidden">
            <img src="<?= BASE_URL ?>/assets/images/content/article1.jpg" 
                 alt="Article Thumbnail"
                 class="w-full h-48 object-cover">
            <div class="p-4">
                <span class="text-xs font-medium text-green-600">Artikel</span>
                <h3 class="font-semibold text-gray-800 mt-1">Cara Melindungi Diri</h3>
                <p class="text-sm text-gray-600 mt-1">Tips dan strategi untuk melindungi diri dari kekerasan seksual.</p>
                <div class="flex items-center mt-2 text-sm text-gray-500">
                    <i class="fas fa-book-reader mr-2"></i>
                    <span>5 menit baca</span>
                </div>
            </div>
        </a>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/student/footer.php'; ?>