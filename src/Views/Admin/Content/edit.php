<?php 
$pageTitle = "Edit Content";
$showBackButton = true;
include '../../layouts/admin/header.php';
?>

<div class="px-4 py-4">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Konten</h1>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Basic Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Dasar</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Konten
                        </label>
                        <input type="text" 
                               name="title"
                               value="Mengenali Tanda Kekerasan"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipe Konten
                        </label>
                        <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="video">Video</option>
                            <option value="article">Artikel</option>
                            <option value="infographic">Infografis</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Singkat
                        </label>
                        <textarea name="description" 
                                  rows="3" 
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2">Pelajari cara mengidentifikasi tanda-tanda kekerasan seksual.</textarea>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Konten</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Thumbnail
                        </label>
                        <div class="flex items-center space-x-4">
                            <img src="/assets/images/content/sample.jpg" 
                                 alt="Current Thumbnail"
                                 class="w-32 h-32 object-cover rounded-lg">
                            <div>
                                <input type="file" 
                                       name="thumbnail"
                                       class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-full file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100">
                                <p class="mt-1 text-xs text-gray-500">
                                    PNG, JPG up to 2MB
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Konten Utama
                        </label>
                        <div id="editor" class="min-h-[300px] border border-gray-300 rounded-lg">
                            <!-- Rich text editor will be initialized here -->
                        </div>
                    </div>

                    <!-- Video URL for video type -->
                    <div id="videoSection" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            URL Video
                        </label>
                        <input type="text" 
                               name="video_url"
                               placeholder="https://youtube.com/..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Pengaturan</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="radio" 
                                       name="status" 
                                       value="published" 
                                       checked
                                       class="text-blue-600">
                                <span class="ml-2 text-gray-700">Published</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" 
                                       name="status" 
                                       value="draft"
                                       class="text-blue-600">
                                <span class="ml-2 text-gray-700">Draft</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori
                        </label>
                        <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="education">Edukasi</option>
                            <option value="prevention">Pencegahan</option>
                            <option value="awareness">Kesadaran</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4">
                <button type="button" 
                        onclick="history.back()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Include Rich Text Editor -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script>
    // Initialize Quill editor
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'header': 1 }, { 'header': 2 }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Show/hide video URL field based on content type
    const typeSelect = document.querySelector('select[name="type"]');
    const videoSection = document.getElementById('videoSection');
    
    typeSelect.addEventListener('change', function() {
        if (this.value === 'video') {
            videoSection.classList.remove('hidden');
        } else {
            videoSection.classList.add('hidden');
        }
    });
</script>

<?php include '../../layouts/admin/footer.php'; ?>