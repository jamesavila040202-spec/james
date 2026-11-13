<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Citizen Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-950 text-slate-100 font-sans selection:bg-indigo-500 selection:text-white min-h-screen flex flex-col" x-data="{ currentTab: 'overview' }">

    <!-- Stay Put / Fixed Car Background Image with Balanced Transparency -->
    <div class="fixed inset-0 z-0 pointer-events-none bg-cover bg-center" style="background-image: url('https://media.gq-magazine.co.uk/photos/648ae7eb2b491c2fcdb734a7/16:9/w_1280,c_limit/Mercedes-concept-Vision-One-Eleven-hp.jpeg');">
        <div class="absolute inset-0 bg-slate-950/50 backdrop-blur-[1px]"></div>
    </div>

    <!-- Top Navigation Header (Dating Sidebar gi-convert as Header) -->
    <header class="bg-slate-900/80 backdrop-blur-xl border-b border-white/10 sticky top-0 z-30 px-8 py-4 flex flex-col md:flex-row justify-between items-center gap-4 shadow-2xl relative z-20">
        
        <!-- Left: Brand & Status -->
        <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-start">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-indigo-600/40 border border-indigo-400/30 flex items-center justify-center text-lg shadow-inner">
                    🏎️
                </div>
                <div>
                    <h2 class="text-sm font-black tracking-widest text-white uppercase">TRANSPORT PORTAL</h2>
                    <p class="text-[11px] text-indigo-300 font-medium" x-text="currentTab.toUpperCase() + ' MANAGEMENT'"></p>
                </div>
            </div>
            <div class="hidden xl:flex items-center gap-1.5 text-[11px] font-bold text-indigo-200 bg-indigo-600/30 border border-indigo-400/30 px-3 py-1 rounded-full shadow-inner">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                🛡️ Admin Control
            </div>
        </div>

        <!-- Center: Navigation Buttons -->
        <nav class="flex items-center gap-2 overflow-x-auto max-w-full pb-1 md:pb-0">
            <button @click="currentTab = 'overview'" :class="currentTab === 'overview' ? 'bg-indigo-600/30 text-white border border-indigo-400/40 shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white border border-transparent'" class="flex items-center px-4 py-2 text-xs font-semibold rounded-xl transition-all whitespace-nowrap">
                <span class="mr-1.5">📊</span> System Overview
            </button>
            <button @click="currentTab = 'citizens'" :class="currentTab === 'citizens' ? 'bg-indigo-600/30 text-white border border-indigo-400/40 shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white border border-transparent'" class="flex items-center px-4 py-2 text-xs font-semibold rounded-xl transition-all whitespace-nowrap">
                <span class="mr-1.5">👥</span> All Citizens List
            </button>
            <button @click="currentTab = 'vehicles'" :class="currentTab === 'vehicles' ? 'bg-indigo-600/30 text-white border border-indigo-400/40 shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white border border-transparent'" class="flex items-center px-4 py-2 text-xs font-semibold rounded-xl transition-all whitespace-nowrap">
                <span class="mr-1.5">🚗</span> All Vehicles
            </button>
            <button @click="currentTab = 'skills'" :class="currentTab === 'skills' ? 'bg-indigo-600/30 text-white border border-indigo-400/40 shadow-md' : 'text-slate-300 hover:bg-white/5 hover:text-white border border-transparent'" class="flex items-center px-4 py-2 text-xs font-semibold rounded-xl transition-all whitespace-nowrap">
                <span class="mr-1.5">⚡</span> Skills Directory
            </button>
        </nav>

        <!-- Right: Logout Button -->
        <div class="w-full md:w-auto flex justify-end">
            <form action="/logout" method="POST" class="w-full md:w-auto">
                @csrf
                <button type="submit" class="w-full md:w-auto bg-rose-500/20 hover:bg-rose-500/30 text-rose-200 border border-rose-500/30 text-xs font-bold py-2 px-4 rounded-xl transition shadow-lg flex items-center justify-center gap-1.5 whitespace-nowrap">
                    <span>🔒</span> Admin Logout
                </button>
            </form>
        </div>

    </header>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col relative z-10 overflow-y-auto">
        
        <main class="p-8 max-w-7xl mx-auto w-full">

            <!-- Overview Tab -->
            <div x-show="currentTab === 'overview'">
                <div class="bg-slate-900/70 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl p-8 mb-8 relative overflow-hidden">
                    <div class="absolute right-0 top-0 bottom-0 w-1/3 opacity-15 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-400 via-slate-500 to-transparent pointer-events-none flex items-center justify-end pr-8">
                        <span class="text-9xl">🏎️</span>
                    </div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-200 text-xs font-bold mb-4 shadow-sm">
                            <span>🛣️ Fleet & Traffic Monitoring System</span>
                        </div>
                        <h2 class="text-3xl font-black text-white tracking-tight">Administrator Control Center</h2>
                        <p class="text-slate-300 text-sm mt-1.5 font-medium">Welcome, Admin. Real-time vehicle registries and system statistics pulled directly from active records.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-slate-900/70 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white/10 border-l-4 border-l-slate-400 hover:border-white/20 transition group">
                        <h3 class="font-bold text-slate-300 text-xs uppercase tracking-wider flex items-center justify-between">
                            TOTAL CITIZENS <span class="p-2 rounded-xl bg-slate-800/80 text-base group-hover:scale-110 transition-transform">👤</span>
                        </h3>
                        <p class="text-4xl font-black text-white mt-3">{{ \App\Models\User::where('role', 'citizen')->count() }}</p>
                    </div>

                    <div class="bg-slate-900/70 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white/10 border-l-4 border-l-indigo-500 hover:border-white/20 transition group">
                        <h3 class="font-bold text-slate-300 text-xs uppercase tracking-wider flex items-center justify-between">
                            TOTAL VEHICLES <span class="p-2 rounded-xl bg-indigo-950/80 text-base group-hover:scale-110 transition-transform">🚗</span>
                        </h3>
                        <p class="text-4xl font-black text-indigo-300 mt-3">{{ count($allVehicles ?? []) }}</p>
                    </div>

                    <div class="bg-slate-900/70 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white/10 border-l-4 border-l-pink-500 hover:border-white/20 transition group">
                        <h3 class="font-bold text-slate-300 text-xs uppercase tracking-wider flex items-center justify-between">
                            TOTAL SKILLS <span class="p-2 rounded-xl bg-pink-950/80 text-base group-hover:scale-110 transition-transform">⚡</span>
                        </h3>
                        <p class="text-4xl font-black text-pink-300 mt-3">{{ count($allSkills ?? []) }}</p>
                    </div>
                </div>
            </div>

            <!-- Citizens Tab -->
            <div x-show="currentTab === 'citizens'" style="display: none;">
                <div class="bg-slate-900/70 backdrop-blur-xl rounded-3xl shadow-2xl p-7 border border-white/10">
                    <h2 class="text-xl font-bold text-white mb-1">Registered Citizens Directory</h2>
                    <p class="text-slate-300 text-sm mb-6">List of users registered in the portal. Passports are confidential.</p>
                    
                    <div class="overflow-x-auto rounded-2xl border border-white/10 bg-slate-950/30">
                        <table class="w-full text-left text-sm text-slate-200">
                            <thead class="bg-slate-900/90 text-xs uppercase text-slate-300 border-b border-white/10">
                                <tr>
                                    <th class="px-6 py-4 font-bold">Name</th>
                                    <th class="px-6 py-4 font-bold">Email</th>
                                    <th class="px-6 py-4 font-bold">Passport (Confidential)</th>
                                    <th class="px-6 py-4 font-bold">Role</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach(\App\Models\User::all() as $citizen)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="px-6 py-4 font-semibold text-white">{{ $citizen->name }}</td>
                                    <td class="px-6 py-4 text-slate-300">{{ $citizen->email }}</td>
                                    <td class="px-6 py-4 text-purple-300 font-mono">
                                        P****🔒 <span class="text-[10px] bg-purple-950/80 border border-purple-700/60 px-2.5 py-1 rounded-lg text-purple-200 font-sans ml-2">Protected</span>
                                    </td>
                                    <td class="px-6 py-4 uppercase text-xs font-extrabold text-indigo-300 tracking-wider">{{ $citizen->role ?? 'citizen' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Vehicles Tab -->
            <div x-show="currentTab === 'vehicles'" style="display: none;">
                <div class="bg-slate-900/70 backdrop-blur-xl rounded-3xl shadow-2xl p-7 border border-white/10">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-white mb-1">All Registered Vehicles</h2>
                            <p class="text-slate-300 text-sm">Overview of all vehicles linked to citizens.</p>
                        </div>
                        <span class="text-2xl bg-indigo-500/20 border border-indigo-400/30 p-3 rounded-2xl shadow-inner">🚙</span>
                    </div>
                    
                    @if(!empty($allVehicles) && count($allVehicles) > 0)
                        <div class="space-y-3.5 mt-4">
                            @foreach($allVehicles as $vehicle)
                                <div class="bg-slate-900/60 hover:bg-slate-900/90 border border-white/10 p-5 rounded-2xl flex justify-between items-center transition shadow-lg">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-indigo-600/30 border border-indigo-400/30 flex items-center justify-center text-xl flex-shrink-0 shadow-inner">
                                            🚘
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-white text-base">{{ $vehicle['model'] }}</h4>
                                            <p class="text-xs text-slate-300 mt-1 flex items-center gap-2.5">
                                                <span>Owner: <strong class="text-white">{{ $vehicle['owner'] }}</strong></span> 
                                                <span>•</span> 
                                                <span>Plate Number: <strong class="font-mono text-indigo-300 bg-indigo-950/80 px-2.5 py-1 rounded-lg border border-indigo-500/30">{{ $vehicle['plate'] }}</strong></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-14 text-slate-400 text-sm border-2 border-dashed border-white/10 rounded-2xl bg-slate-950/30">
                            <span class="text-4xl block mb-2">🚗💨</span>
                            No vehicles recorded in the system yet.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Skills Tab -->
            <div x-show="currentTab === 'skills'" style="display: none;">
                <div class="bg-slate-900/70 backdrop-blur-xl rounded-3xl shadow-2xl p-7 border border-white/10">
                    <h2 class="text-xl font-bold text-white mb-1">Skills Directory</h2>
                    <p class="text-slate-300 text-sm mb-6">Directory mapping skills across citizen profiles.</p>
                    
                    @if(!empty($allSkills) && count($allSkills) > 0)
                        <div class="space-y-3.5 mt-4">
                            @foreach($allSkills as $skill)
                                <div class="bg-slate-900/60 hover:bg-slate-900/90 border border-white/10 p-5 rounded-2xl flex justify-between items-center transition shadow-lg">
                                    <div>
                                        <h4 class="font-bold text-white text-base">{{ $skill['name'] }}</h4>
                                        <p class="text-xs text-slate-300 mt-1">Owner: <strong class="text-white">{{ $skill['owner'] }}</strong></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-14 text-slate-400 text-sm border-2 border-dashed border-white/10 rounded-2xl bg-slate-950/30">
                            No skills mapped in the directory yet.
                        </div>
                    @endif
                </div>
            </div>

        </main>

    </div>

</body>
</html>