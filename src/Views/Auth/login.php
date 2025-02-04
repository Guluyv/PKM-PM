<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CeritainAja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <!-- Logo dan Judul -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-600 mb-2">CeritainAja</h1>
            <p class="text-gray-600">Platform Edukasi</p>
        </div>

        <!-- Login Form -->
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Login</h2>

                <?php if (isset($error)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>/login" method="POST">
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                   placeholder="Masukkan email">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                   placeholder="Masukkan password">
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="remember" 
                                   name="remember" 
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                        </div>
                        <a href="<?= BASE_URL ?>/forgot-password" class="text-sm text-blue-600 hover:underline">
                            Lupa password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white rounded-lg px-4 py-2 font-medium hover:bg-blue-700 transition-colors">
                        Login
                    </button>
                </form>
            </div>

            <!-- Register Link -->
            <p class="text-center mt-4 text-gray-600">
                Belum punya akun? 
                <a href="<?= BASE_URL ?>/register" class="text-blue-600 hover:underline">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </div>
</body>
</html>