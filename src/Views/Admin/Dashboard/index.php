<?php 
$pageTitle = "Admin Dashboard";
include '../../layouts/admin/header.php';
?>

<div class="px-4 py-4">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Siswa -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Siswa</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">1,234</h3>
                </div>
                <div class="bg-blue-100 rounded-lg p-3">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="flex items-center mt-4 text-sm">
                <span class="text-green-500 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i>
                    12%
                </span>
                <span class="text-gray-500 ml-2">dari bulan lalu</span>
            </div>
        </div>

        <!-- Chat Aktif -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm text-gray-500">Chat Aktif</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">45</h3>
                </div>
                <div class="bg-green-100 rounded-lg p-3">
                    <i class="fas fa-comments text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="flex items-center mt-4 text-sm">
                <span class="text-green-500 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i>
                    5%
                </span>
                <span class="text-gray-500 ml-2">dari minggu lalu</span>
            </div>
        </div>

        <!-- Total Konten -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Konten</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">89</h3>
                </div>
                <div class="bg-purple-100 rounded-lg p-3">
                    <i class="fas fa-book text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="flex items-center mt-4 text-sm">
                <span class="text-green-500 flex items-center">
                    <i class="fas fa-plus mr-1"></i>
                    3
                </span>
                <span class="text-gray-500 ml-2">konten baru hari ini</span>
            </div>
        </div>

        <!-- Quiz Selesai -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm text-gray-500">Quiz Selesai</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">567</h3>
                </div>
                <div class="bg-yellow-100 rounded-lg p-3">
                    <i class="fas fa-clipboard-list text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="flex items-center mt-4 text-sm">
                <span class="text-green-500 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i>
                    8%
                </span>
                <span class="text-gray-500 ml-2">tingkat penyelesaian</span>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Chat -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h2>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-user-plus text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-800">Siswa baru mendaftar</p>
                        <p class="text-sm text-gray-500">2 menit yang lalu</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <i class="fas fa-comment text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-800">Chat baru dimulai</p>
                        <p class="text-sm text-gray-500">5 menit yang lalu</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="bg-purple-100 rounded-full p-2 mr-3">
                        <i class="fas fa-book text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-800">Konten baru ditambahkan</p>
                        <p class="text-sm text-gray-500">1 jam yang lalu</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Chats -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Chat Terbaru</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-800">Anonymous User</p>
                            <p class="text-sm text-gray-500">Aktif 2 menit yang lalu</p>
                        </div>
                    </div>
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                        Baru
                    </span>
                </div>

                <!-- More chat items -->
            </div>
        </div>
    </div>

    <!-- Content Overview -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Konten Overview</h2>
            <a href="<?= BASE_URL ?>/admin/content" class="text-blue-600 text-sm">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Judul
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipe
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Views
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Mengenali Tanda Kekerasan</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Video
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            1,234
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Published
                            </span>
                        </td>
                    </tr>
                    <!-- More rows -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../layouts/admin/footer.php'; ?>