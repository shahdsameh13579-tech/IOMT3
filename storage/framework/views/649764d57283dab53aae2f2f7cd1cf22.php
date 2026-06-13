<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100 dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CyberForensics AI</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 50%, #0b1329 0%, #030712 100%);
        }
        .glass-panel {
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-6">
    <div class="w-full max-w-md glass-panel p-8 rounded-2xl shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-slate-800">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-red-500/10 border border-red-500/30 flex items-center justify-center shadow-[0_0_20px_rgba(239,68,68,0.15)]">
                <i class="fa-solid fa-shield-halved text-red-500 text-2xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold tracking-wider uppercase bg-clip-text text-transparent bg-gradient-to-r from-red-500 to-rose-400">SOC ACCESS PORTAL</h1>
            <p class="text-xs text-slate-500 font-semibold tracking-widest mt-1">CYBERFORENSICS AI PLATFORM</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="mb-5 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs">
                <ul class="list-disc list-inside space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Security Identifier (Email)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username"
                        class="block w-full pl-10 pr-4 py-3 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 text-sm focus:outline-none focus:border-red-500/80 focus:ring-1 focus:ring-red-500/80 transition duration-200"
                        placeholder="analyst@forensics.ai">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Access Key (Password)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="block w-full pl-10 pr-4 py-3 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 text-sm focus:outline-none focus:border-red-500/80 focus:ring-1 focus:ring-red-500/80 transition duration-200"
                        placeholder="••••••••">
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="sr-only peer">
                    <div class="relative w-9 h-5 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-slate-400 after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-red-600 peer-checked:after:bg-slate-100"></div>
                    <span class="ms-3 text-xs text-slate-400 font-semibold tracking-wide">Remember terminal session</span>
                </label>
            </div>

            <!-- Action Button -->
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-extrabold text-sm uppercase tracking-widest rounded-xl transition duration-200 shadow-[0_4px_20px_rgba(239,68,68,0.25)] border border-red-500/20 cursor-pointer">
                Authenticate
            </button>
        </form>

        <!-- Navigation link -->
        <div class="mt-6 text-center text-xs text-slate-500">
            Need local clearance? <a href="<?php echo e(route('register')); ?>" class="text-red-400 hover:text-red-300 font-semibold underline underline-offset-4">Register new account</a>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\moza1\Desktop\project1.final\resources\views/auth/login.blade.php ENDPATH**/ ?>