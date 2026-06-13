<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100 dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CyberForensics AI</title>
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
            <h1 class="text-2xl font-extrabold tracking-wider uppercase bg-clip-text text-transparent bg-gradient-to-r from-red-500 to-rose-400">SOC REGISTER</h1>
            <p class="text-xs text-slate-500 font-semibold tracking-widest mt-1">REQUEST SYSTEM CREDS</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Full Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="block w-full pl-10 pr-4 py-2.5 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 text-sm focus:outline-none focus:border-red-500/80 focus:ring-1 focus:ring-red-500/80 transition duration-200"
                        placeholder="John Doe">
                </div>
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="block w-full pl-10 pr-4 py-2.5 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 text-sm focus:outline-none focus:border-red-500/80 focus:ring-1 focus:ring-red-500/80 transition duration-200"
                        placeholder="john.doe@forensics.ai">
                </div>
            </div>

            <!-- Role Selection -->
            <div>
                <label for="role" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Security Clearance</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-user-lock"></i>
                    </div>
                    <select id="role" name="role" required
                        class="block w-full pl-10 pr-4 py-2.5 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 text-sm focus:outline-none focus:border-red-500/80 focus:ring-1 focus:ring-red-500/80 transition duration-200 appearance-none">
                        <option value="analyst" {{ old('role') === 'analyst' ? 'selected' : '' }}>Analyst (Standard access)</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Full policy control)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Access Key (Password)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full pl-10 pr-4 py-2.5 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 text-sm focus:outline-none focus:border-red-500/80 focus:ring-1 focus:ring-red-500/80 transition duration-200"
                        placeholder="••••••••">
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Confirm Access Key</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-shield"></i>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="block w-full pl-10 pr-4 py-2.5 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 text-sm focus:outline-none focus:border-red-500/80 focus:ring-1 focus:ring-red-500/80 transition duration-200"
                        placeholder="••••••••">
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full mt-2 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-extrabold text-sm uppercase tracking-widest rounded-xl transition duration-200 shadow-[0_4px_20px_rgba(239,68,68,0.25)] border border-red-500/20 cursor-pointer">
                Register Credentials
            </button>
        </form>

        <!-- Navigation link -->
        <div class="mt-6 text-center text-xs text-slate-500">
            Have clearance already? <a href="{{ route('login') }}" class="text-red-400 hover:text-red-300 font-semibold underline underline-offset-4">Log in here</a>
        </div>
    </div>
</body>
</html>
