<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up - Transport Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-950 font-sans flex items-center justify-center h-screen m-0 selection:bg-indigo-500 selection:text-white">

    <div class="bg-slate-900 rounded-3xl shadow-2xl flex w-full max-w-4xl overflow-hidden m-4 border border-white/10">
        
        <!-- Left Side: Lighter Background Picture with Transport Texts -->
        <div class="w-1/2 relative text-white p-10 flex flex-col justify-between hidden md:flex bg-cover bg-center overflow-hidden" style="background-image: url('https://static1.topspeedimages.com/wordpress/wp-content/uploads/2023/08/a5-5.jpeg');">
            <!-- Lighter Gradient Overlay so the background image is more visible -->
            <div class="absolute inset-0 bg-gradient-to-br from-slate-950/50 via-slate-950/30 to-slate-950/50 backdrop-blur-[0.5px]"></div>

            <div class="relative z-10">
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-300 bg-indigo-500/30 px-3 py-1 rounded-full border border-indigo-300/40 shadow-sm">Transport System</span>
                <h1 class="text-3xl font-black mt-4 leading-tight tracking-tight text-white drop-shadow-md">Drive & Manage Seamlessly</h1>
                <p class="text-slate-100 text-sm mt-3 leading-relaxed drop-shadow">
                    Access your secure vehicle registries, track transport profiles, and manage citizen data in one unified portal.
                </p>
            </div>

            <div class="space-y-3.5 relative z-10 my-6">
                <div class="flex items-center space-x-3 bg-slate-950/50 backdrop-blur-md px-4 py-3 rounded-xl border border-white/20 text-sm shadow-lg">
                    <span class="text-emerald-400 font-bold">✓</span>
                    <span class="text-white">Real-Time Vehicle Registry</span>
                </div>
                <div class="flex items-center space-x-3 bg-slate-950/50 backdrop-blur-md px-4 py-3 rounded-xl border border-white/20 text-sm shadow-lg">
                    <span class="text-emerald-400 font-bold">✓</span>
                    <span class="text-white">Encrypted Citizen & Passport Data</span>
                </div>
                <div class="flex items-center space-x-3 bg-slate-950/50 backdrop-blur-md px-4 py-3 rounded-xl border border-white/20 text-sm shadow-lg">
                    <span class="text-emerald-400 font-bold">✓</span>
                    <span class="text-white">Advanced Driver Skills Mapping</span>
                </div>
            </div>

            <div class="text-xs text-slate-200 font-medium relative z-10 flex items-center gap-2 drop-shadow">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Secure Fleet Portal • Encrypted Database
            </div>
        </div>

        <!-- Right Side: Login & Sign Up Forms -->
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center bg-slate-900/90 backdrop-blur-md" x-data="{ tab: 'login' }">
            
            <div class="flex border-b border-slate-800 mb-6">
                <button @click="tab = 'login'" :class="tab === 'login' ? 'border-indigo-500 text-indigo-400 font-bold' : 'border-transparent text-slate-400 font-medium hover:text-slate-200'" class="pb-2 px-4 border-b-2 text-sm transition">
                    Login
                </button>
                <button @click="tab = 'signup'" :class="tab === 'signup' ? 'border-indigo-500 text-indigo-400 font-bold' : 'border-transparent text-slate-400 font-medium hover:text-slate-200'" class="pb-2 px-4 border-b-2 text-sm transition">
                    Sign Up
                </button>
            </div>

            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 px-4 py-2.5 rounded-xl text-xs mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-500/10 border border-rose-500/30 text-rose-300 px-4 py-2.5 rounded-xl text-xs mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form x-show="tab === 'login'" action="/login" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Email Address</label>
                    <input type="email" name="email" required placeholder="Enter your email" class="w-full px-4 py-3 border border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-950 text-white placeholder-slate-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Enter your password" class="w-full px-4 py-3 border border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-950 text-white placeholder-slate-500">
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-indigo-600/30 text-sm">
                    Log In
                </button>
            </form>

            <form x-show="tab === 'signup'" style="display: none;" action="/register" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Enter full name" class="w-full px-4 py-2.5 border border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-950 text-white placeholder-slate-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Enter email" class="w-full px-4 py-2.5 border border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-950 text-white placeholder-slate-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Create password" class="w-full px-4 py-2.5 border border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-950 text-white placeholder-slate-500">
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-indigo-600/30 text-sm mt-2">
                    Register Account
                </button>
            </form>

        </div>

    </div>

</body>
</html>