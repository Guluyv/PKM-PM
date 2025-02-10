<?php 
$pageTitle = "Materi Edukasi";
include __DIR__ . '/../../layouts/student/header.php'; 
use Helpers\VideoHelper;
?>

<div class="px-4 py-4">
    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative">
            <input type="text" 
                   id="searchInput"
                   placeholder="Cari materi..." 
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
    </div>

    <!-- Categories -->
    <div class="mb-6">
        <div class="flex overflow-x-auto space-x-2 pb-2 no-scrollbar">
            <button onclick="filterContent('all')" class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm whitespace-nowrap">
                Semua
            </button>
            <button onclick="filterContent('video')" class="bg-white text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap hover:bg-blue-50">
                Video
            </button>
            <button onclick="filterContent('article')" class="bg-white text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap hover:bg-blue-50">
                Artikel
            </button>
            <button onclick="filterContent('infographic')" class="bg-white text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap hover:bg-blue-50">
                Infografis
            </button>
        </div>
    </div>

    <!-- Content List yang benar -->
<div class="space-y-4">
    <?php foreach ($data['groupedContents'] as $type => $contents): ?>
        <?php foreach ($contents as $content): ?>
            <a href="<?= BASE_URL ?>/student/content/view/<?= $content['id'] ?>" 
               class="block bg-white rounded-lg shadow-sm overflow-hidden content-item"
               data-type="<?= $content['content_type'] ?>">
                
                <?php if ($content['content_type'] === 'video'): ?>
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe 
                            src="<?= VideoHelper::getYoutubeEmbedUrl($content['content']) ?>" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="w-full h-48">
                        </iframe>
                    </div>
                <?php else: ?>
                    <img src="<?= BASE_URL ?>/public/assets/images/thumbnails/<?= $content['thumbnail'] ?>" 
                         alt="<?= $content['title'] ?>"
                         class="w-full h-48 object-cover">
                <?php endif; ?>

                <div class="p-4">
                    <?php 
                    $typeColors = [
                        'video' => 'text-blue-600',
                        'article' => 'text-green-600',
                        'infographic' => 'text-purple-600'
                    ];
                    $typeColor = $typeColors[$content['content_type']] ?? 'text-gray-600';
                    ?>
                    <span class="text-xs font-medium <?= $typeColor ?>"><?= ucfirst($content['content_type']) ?></span>
                    <h3 class="font-semibold text-gray-800 mt-1"><?= $content['title'] ?></h3>
                    <p class="text-sm text-gray-600 mt-1"><?= $content['description'] ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<script>
function filterContent(type) {
    const items = document.querySelectorAll('.content-item');
    items.forEach(item => {
        if (type === 'all' || item.dataset.type === type) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });

    // Update active button state
    const buttons = document.querySelectorAll('.rounded-full');
    buttons.forEach(button => {
        if (button.textContent.trim().toLowerCase() === type || 
           (type === 'all' && button.textContent.trim() === 'Semua')) {
            button.classList.add('bg-blue-600', 'text-white');
            button.classList.remove('bg-white', 'text-gray-700');
        } else {
            button.classList.remove('bg-blue-600', 'text-white');
            button.classList.add('bg-white', 'text-gray-700');
        }
    });
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.content-item');
    
    items.forEach(item => {
        const title = item.querySelector('h3').textContent.toLowerCase();
        const description = item.querySelector('p').textContent.toLowerCase();
        
        if (title.includes(searchTerm) || description.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>

<?php include __DIR__ . '/../../layouts/student/footer.php'; ?>