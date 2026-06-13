<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full bg-slate-950 text-slate-100 dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'CyberForensics AI')); ?> - SOC Dashboard</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- FontAwesome for Cyber Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- ApexCharts for SOC Visualizations -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 50%, #0b1329 0%, #030712 100%);
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        /* Glassmorphism custom styling */
        .glass-panel {
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .glass-panel-glow {
            border: 1px solid rgba(239, 68, 68, 0.15);
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.05);
        }
        .cyber-border-red {
            border-left: 4px solid #ef4444;
        }
        .cyber-border-blue {
            border-left: 4px solid #3b82f6;
        }
        .cyber-border-green {
            border-left: 4px solid #10b981;
        }
        .cyber-border-orange {
            border-left: 4px solid #f97316;
        }
        /* Pulse Animation */
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.95); }
        }
        .animate-pulse-slow {
            animation: pulse-slow 3s infinite ease-in-out;
        }
    </style>
</head>
<body class="h-full antialiased overflow-x-hidden">
    <div class="min-h-screen flex">
        
        <!-- Sidebar Navigation -->
        <aside class="w-64 glass-panel border-r border-slate-800 flex flex-col justify-between shrink-0">
            <div>
                <!-- Brand Logo & Pulser -->
                <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-red-600/25 flex items-center justify-center border border-red-500/50 shadow-[0_0_10px_rgba(239,68,68,0.2)]">
                            <i class="fa-solid fa-shield-halved text-red-500 text-lg"></i>
                        </div>
                        <div>
                            <h1 class="font-extrabold text-sm tracking-wider uppercase bg-clip-text text-transparent bg-gradient-to-r from-red-500 to-rose-400">FORENSICS AI</h1>
                            <span class="text-[10px] text-slate-500 font-semibold tracking-widest block -mt-0.5">CYBER THREAT SOC</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[9px] text-emerald-400 font-bold uppercase tracking-wider">LIVE</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="p-4 space-y-1">
                    <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('dashboard') ? 'bg-red-500/10 text-red-400 border-l-2 border-red-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/40 hover:text-slate-200'); ?>">
                        <i class="fa-solid fa-chart-line w-5 text-center text-base"></i>
                        SOC Dashboard
                    </a>
                    
                    <?php if(Auth::user() && Auth::user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.users')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 <?php echo e(request()->routeIs('admin.users') ? 'bg-red-500/10 text-red-400 border-l-2 border-red-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/40 hover:text-slate-200'); ?>">
                            <i class="fa-solid fa-users-gear w-5 text-center text-base"></i>
                            User Access Control
                        </a>
                    <?php endif; ?>
                </nav>
            </div>

            <!-- Profile Info and Logout -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-slate-800 to-slate-700 flex items-center justify-center border border-slate-700">
                        <i class="fa-solid fa-user-shield text-slate-300"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="text-sm font-semibold text-slate-200 truncate"><?php echo e(Auth::user()->name); ?></h4>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <?php if(Auth::user()->isAdmin()): ?>
                                <span class="text-[9px] bg-amber-500/10 text-amber-400 border border-amber-500/20 px-1.5 py-0.5 rounded font-bold uppercase tracking-wider">ADMIN</span>
                            <?php else: ?>
                                <span class="text-[9px] bg-blue-500/10 text-blue-400 border border-blue-500/20 px-1.5 py-0.5 rounded font-bold uppercase tracking-wider">ANALYST</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-xs font-semibold text-red-400 hover:bg-red-500/10 border border-red-500/20 transition-all duration-200">
                        <i class="fa-solid fa-sign-out-alt"></i>
                        Terminate Session
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="flex-1 flex flex-col min-w-0">
            <!-- Header bar -->
            <header class="h-16 glass-panel border-b border-slate-800 flex items-center justify-between px-8 z-10">
                <div class="flex items-center gap-4">
                    <h2 class="text-lg font-semibold tracking-wide text-slate-200">
                        <?php echo $__env->yieldContent('header_title', 'Incident Analysis Center'); ?>
                    </h2>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Status widget -->
                    <div class="text-xs text-slate-400 font-medium">
                        System Time: <span class="font-mono text-slate-300" id="live-time"></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <?php if(session('success')): ?>
                    <div class="mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-base"></i>
                        <span><?php echo e(session('success')); ?></span>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm flex items-center gap-3">
                        <i class="fa-solid fa-circle-xmark text-base"></i>
                        <span><?php echo e(session('error')); ?></span>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>

    </div>

    <!-- Live Time Updater Script -->
    <script>
        function updateTime() {
            const now = new Date();
            const timeStr = now.toISOString().replace('T', ' ').substring(0, 19);
            document.getElementById('live-time').innerText = timeStr + ' UTC';
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\moza1\Desktop\project1.final\resources\views/layouts/app.blade.php ENDPATH**/ ?>