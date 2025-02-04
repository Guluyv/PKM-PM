<?php include __DIR__ . '/../layouts/student/header.php'; ?>

<div class="px-4 py-4">
    <!-- Welcome Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Hai, <?= htmlspecialchars($_SESSION['username']) ?>! 👋
        </h1>
        <p class="text-gray-600 mt-1">Selamat datang di CeritainAja</p>
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
        <a href="<?= BASE_URL ?>/student/content" 
           class="bg-green-50 p-4 rounded-xl flex flex-col items-center justify-center">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-2">
                <i class="fas fa-book text-green-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-green-900">Materi</span>
            <span class="text-xs text-green-700 mt-1">Belajar & Quiz</span>
        </a>
    </div>

    <!-- Latest Content -->
    <?php if (!empty($data['latestContent'])): ?>
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Materi Terbaru</h2>
            <a href="<?= BASE_URL ?>/student/content" class="text-sm text-blue-600">Lihat Semua</a>
        </div>
        
        <div class="space-y-4">
            <?php foreach ($data['latestContent'] as $content): ?>
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <?php if ($content['thumbnail']): ?>
                <img src="<?= BASE_URL ?>/public/assets/images/content/<?= htmlspecialchars($content['thumbnail']) ?>" 
                     alt="<?= htmlspecialchars($content['title']) ?>" 
                     class="w-full h-48 object-cover">
                <?php endif; ?>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($content['title']) ?></h3>
                    <p class="text-sm text-gray-600 mt-1">
                        <?= htmlspecialchars($content['description']) ?>
                    </p>
                    <a href="<?= BASE_URL ?>/student/content/view/<?= $content['id'] ?>" 
                       class="mt-3 inline-flex items-center text-sm text-blue-600">
                        Baca Selengkapnya
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/student/footer.php'; ?>