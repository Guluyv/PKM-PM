<?php 
$pageTitle = "Content Management";
include '../../layouts/admin/header.php';
?>

<div class="px-4 py-4">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Konten</h1>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Konten
        </button>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Konten</label>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Semua Tipe</option>
                    <option value="video">Video</option>
                    <option value="article">Artikel</option>
                    <option value="infographic">Infografis</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Semua Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                <input type="text" 
                       placeholder="Cari judul konten..." 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
        </div>
    </div>

    <!-- Content List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Content Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="relative">
                <img src="/assets/images/content/sample.jpg" 
                     alt="Content Thumbnail"
                     class="w-full h-48 object-cover">
                <span class="absolute top-2 right-2 px-2 py-1 bg-blue-600 text-white text-xs rounded-full">
                    Video
                </span>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-800">Mengenali Tanda Kekerasan</h3>
                <p class="text-sm text-gray-600 mt-1">
                    Pelajari cara mengidentifikasi tanda-tanda kekerasan seksual.
                </p>
                <div class="flex items-center justify-between mt-4">
                    <span class="text-xs text-gray-500">Published: 20 Jan 2024</span>
                    <div class="flex items-center space-x-2">
                        <a href="edit.php" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- More content cards -->
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        <div class="flex space-x-2">
            <button class="px-3 py-1 border rounded-md text-sm">Previous</button>
            <button class="px-3 py-1 border rounded-md text-sm bg-blue-600 text-white">1</button>
            <button class="px-3 py-1 border rounded-md text-