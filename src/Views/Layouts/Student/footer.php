</main>
    <!-- Bottom Navigation -->
    <nav class="bg-white shadow-lg fixed bottom-0 left-0 right-0 z-50">
        <div class="flex justify-around">
            <a href="../student/home" 
               class="flex flex-col items-center py-2 px-4 <?= $page === 'home' ? 'text-blue-600' : 'text-gray-600' ?>">
                <i class="fas fa-home text-xl"></i>
                <span class="text-xs mt-1">Beranda</span>
            </a>
            <a href="../student/content" 
               class="flex flex-col items-center py-2 px-4 <?= $page === 'content' ? 'text-blue-600' : 'text-gray-600' ?>">
                <i class="fas fa-book text-xl"></i>
                <span class="text-xs mt-1">Edukasi</span>
            </a>
            <a href="../student/chat" 
               class="flex flex-col items-center py-2 px-4 <?= $page === 'Chat' ? 'text-blue-600' : 'text-gray-600' ?>">
                <i class="fas fa-comment text-xl"></i>
                <span class="text-xs mt-1">Chat</span>
            </a>
        </div>
    </nav>

    <!-- AlpineJS untuk dropdown -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Fungsi untuk handling active state di bottom navigation
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('nav a');
            
            navLinks.forEach(link => {
                if (currentPath.includes(link.getAttribute('href'))) {
                    link.classList.add('text-blue-600');
                    link.classList.remove('text-gray-600');
                }
            });
        });
    </script>
</body>
</html>