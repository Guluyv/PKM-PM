<?php 
$pageTitle = "Edit User";
$showBackButton = true;
include '../../layouts/admin/header.php';
?>

<div class="px-4 py-4">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="" method="POST">
            <!-- Basic Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Dasar</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               name="full_name"
                               value="John Doe"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Username
                        </label>
                        <input type="text" 
                               name="username"
                               value="johndoe"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" 
                               name="email"
                               value="john@example.com"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Role
                        </label>
                        <select name="role" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="student">Student</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Ubah Password</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <input type="password" 
                               name="new_password"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <input type="password" 
                               name="confirm_password"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                </div>
            </div>

            <!-- Account Status -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Status Akun</h2>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="radio" 
                               name="status" 
                               value="active" 
                               checked
                               class="text-blue-600">
                        <span class="ml-2 text-gray-700">Active</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" 
                               name="status" 
                               value="inactive"
                               class="text-blue-600">
                        <span class="ml-2 text-gray-700">Inactive</span>
                    </label>
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

<?php include '../../layouts/admin/footer.php'; ?>