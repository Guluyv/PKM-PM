<?php 
$pageTitle = "Home"; 
include '../layouts/student/header.php';
?>

<div class="px-4 py-4">
    <!-- Welcome Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Hai, <?= $_SESSION['username'] ?>! 👋
        </h1>
        <p class="text-gray-600 mt-1">Selamat datang di CeritaYuk</p>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <!-- Chat Button -->
        <a href="<?= BASE_URL ?>/student/chat" 
           class="bg-blue-50 p-4 rounded-xl flex flex-col items-center justify-center">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                <i class="fas fa-comments text-blue-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-blue-900">Chat Anonim</span>
            <span class="text-xs text-blue-700 mt-1">Konsultasi rahasia</span>
        </a>

        <!-- Materi Button -->
        <a href="<?= BASE_URL ?>/student/education" 
           class="bg-green-50 p-4 rounded-xl flex flex-col items-center justify-center">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-2">
                <i class="fas fa-book text-green-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-green-900">Materi</span>
            <span class="text-xs text-green-700 mt-1">Belajar & Quiz</span>
        </a>
    </div>

    <!-- Latest Content -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Materi Terbaru</h2>
            <a href="<?= BASE_URL ?>/student/education" class="text-sm text-blue-600">Lihat Semua</a>
        </div>
        
        <div class="space-y-4">
            <!-- Content Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <img src="<?= BASE_URL ?>/assets/images/content/article1.jpg" 
                     alt="Artikel 1" 
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 mb-1">Memahami Kekerasan Seksual</h3>
                    <p class="text-sm text-gray-600 mb-3">
                        Pelajari tentang bentuk-bentuk kekerasan seksual dan cara mengidentifikasinya.
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">5 menit yang lalu</span>
                        <a href="#" class="text-sm text-blue-600">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>

            <!-- Content Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="aspect-w-16 aspect-h-9">
                    <div class="bg-gray-100 w-full h-48 flex items-center justify-center">
                        <i class="fas fa-play-circle text-4xl text-gray-400"></i>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 mb-1">Video: Cara Melindungi Diri</h3>
                    <p class="text-sm text-gray-600 mb-3">
                        Tips praktis untuk menjaga keamanan diri dari potensi kekerasan.
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">1 jam yang lalu</span>
                        <a href="#" class="text-sm text-blue-600">Tonton Video</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Section -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Quiz Tersedia</h2>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-800">Quiz Mingguan</h3>
                    <p class="text-sm text-gray-600 mt-1">Uji pemahamanmu tentang materi minggu ini</p>
                </div>
                <a href="#" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Mulai Quiz
                </a>
            </div>
        </div>
    </div>

    <!-- Progress Section -->
    <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Progress Belajar</h2>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Materi Selesai</span>
                        <span class="text-sm text-gray-600">60%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 60%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Quiz Selesai</span>
                        <span class="text-sm text-gray-600">40%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 40%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../layouts/student/footer.php'; ?>