<?php include __DIR__ . '/../../layouts/student/header.php'; ?>

<div class="px-4 py-4">
    <!-- Chat List Section -->
    <div class="mb-4">
        <h1 class="text-xl font-bold text-gray-800 mb-4">Chat Konseling</h1>
        
        <!-- Start New Chat Button -->
        <a href="<?= BASE_URL ?>/student/chat/room" 
           class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg mb-6 hover:bg-blue-700 transition-colors">
            Mulai Chat Baru
        </a>

        <!-- Chat List -->
        <div class="space-y-3">
            <?php if (!empty($data['chats'])): ?>
                <?php foreach ($data['chats'] as $chat): ?>
                    <a href="<?= BASE_URL ?>/student/chat/room/<?= $chat['id'] ?>" 
                       class="block bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-800">
                                    <?= $chat['counselor_name'] ? htmlspecialchars($chat['counselor_name']) : 'Konselor Anonim' ?>
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Status: <?= $chat['status'] === 'active' ? 
                                        '<span class="text-green-600">Aktif</span>' : 
                                        '<span class="text-gray-600">Selesai</span>' ?>
                                </p>
                            </div>
                            <?php if ($chat['status'] === 'active'): ?>
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                    Aktif
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="mt-2 text-xs text-gray-500">
                            <?= date('d M Y H:i', strtotime($chat['created_at'])) ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-comments text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500">Belum ada chat aktif</p>
                    <p class="text-sm text-gray-400 mt-1">Mulai konsultasi sekarang!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/student/footer.php'; ?>