<?php 
$pageTitle = "Detail Materi";
$showBackButton = true;
include __DIR__ . '/../../layouts/student/header.php';
// Di awal file view
echo '<pre>';
var_dump($data);
echo '</pre>';

use Helpers\VideoHelper;
?>

<!-- src/Views/student/content/view.php -->
<?php if ($content['content_type'] === 'video'): ?>
    <div class="aspect-w-16 aspect-h-9 mb-6">
        <iframe 
            src="<?= VideoHelper::getYoutubeEmbedUrl($content['content']) ?>" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen
            class="w-full h-full rounded-lg">
        </iframe>
    </div>
    <div class="mt-4">
        <h1 class="text-2xl font-bold"><?= $content['title'] ?></h1>
        <p class="text-gray-600 mt-2"><?= $content['description'] ?></p>
    </div>
<?php endif; ?>

<div class="pb-20">
    <!-- Content Info -->
    <div class="p-4">
        <span class="text-xs font-medium 
            <?php echo $content['content_type'] === 'video' ? 'text-blue-600' : 
                  ($content['content_type'] === 'article' ? 'text-green-600' : 'text-purple-600'); ?>">
            <?= ucfirst($content['content_type']) ?>
        </span>
        <h1 class="text-xl font-bold text-gray-800 mt-2"><?= $content['title'] ?></h1>
        
        <!-- Meta Info -->
        <div class="flex items-center mt-2 text-sm text-gray-500">
            <?php if ($content['content_type'] === 'video'): ?>
                <div class="flex items-center mr-4">
                    <i class="fas fa-clock mr-1"></i>
                    <span>5 menit</span>
                </div>
            <?php endif; ?>
            <div class="flex items-center">
                <i class="fas fa-calendar mr-1"></i>
                <span><?= date('d M Y', strtotime($content['created_at'])) ?></span>
            </div>
        </div>

        <!-- Description -->
        <div class="mt-4">
            <h2 class="font-semibold text-gray-800 mb-2">Deskripsi</h2>
            <p class="text-gray-600 text-sm">
                <?= $content['description'] ?>
            </p>
        </div>

        <!-- Content -->
        <div class="mt-6">
            <h2 class="font-semibold text-gray-800 mb-2">Materi</h2>
            <div class="prose prose-sm">
                <?= $content['content'] ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/student/footer.php'; ?>