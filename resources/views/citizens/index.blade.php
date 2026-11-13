<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-stone-900 font-sans" x-data="{ currentTab: 'dashboard', showAddVehicle: false, showAddSkill: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar (Brown Theme) -->
        <aside class="w-64 bg-amber-950 text-stone-100 hidden md:flex flex-col justify-between shadow-2xl flex-shrink-0 border-r border-amber-900/40">
            <div>
                <div class="px-6 py-5 border-b border-amber-900/60">
                    <h2 class="text-lg font-bold tracking-wider text-amber-100">CITIZEN PORTAL</h2>
                    <p class="text-xs text-amber-400 mt-0.5">Database</p>
                </div>

                <nav class="mt-6 px-4 space-y-1.5">
                    <button @click="currentTab = 'dashboard'" :class="currentTab === 'dashboard' ? 'bg-amber-900 text-white shadow-md' : 'text-amber-200 hover:bg-amber-900/60'" class="w-full flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition text-left">
                        <span>Dashboard</span>
                    </button>
                    <button @click="currentTab = 'passport'" :class="currentTab === 'passport' ? 'bg-amber-900 text-white shadow-md' : 'text-amber-200 hover:bg-amber-900/60'" class="w-full flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition text-left">
                        <span>Passport</span>
                    </button>
                    <button @click="currentTab = 'vehicles'" :class="currentTab === 'vehicles' ? 'bg-amber-900 text-white shadow-md' : 'text-amber-200 hover:bg-amber-900/60'" class="w-full flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition text-left">
                        <span>Vehicles</span>
                    </button>
                    <button @click="currentTab = 'skills'" :class="currentTab === 'skills' ? 'bg-amber-900 text-white shadow-md' : 'text-amber-200 hover:bg-amber-900/60'" class="w-full flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition text-left">
                        <span>Skills</span>
                    </button>
                </nav>
            </div>

            <div class="p-4 border-t border-amber-900/60">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-rose-800/80 hover:bg-rose-800 text-white text-xs font-semibold py-2.5 px-4 rounded-xl transition text-center shadow">
                        Logout System
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-y-auto bg-stone-950">
            
            <header class="bg-stone-900 border-b border-stone-800 shadow-sm px-8 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-amber-100" x-text="currentTab === 'dashboard' ? 'DASHBOARD' : currentTab.toUpperCase()"></h1>
                <div class="text-sm font-semibold text-amber-200 bg-amber-950/80 border border-amber-900/60 px-3.5 py-1.5 rounded-full shadow-inner">
                    👤 {{ auth()->user()->name ?? 'Citizen' }}
                </div>
            </header>

            <main class="p-8">

                @if(session('success'))
                    <div class="bg-amber-950/80 border border-amber-700 text-amber-300 px-4 py-3 rounded-2xl text-xs mb-6 shadow-md">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Dashboard Tab -->
                <div x-show="currentTab === 'dashboard'">
                    <div class="bg-stone-900 rounded-3xl shadow-xl p-8 mb-8 border border-stone-800">
                        <h2 class="text-2xl font-extrabold text-white">Welcome back, {{ auth()->user()->name ?? 'Citizen' }}!</h2>
                        <p class="text-stone-400 text-sm mt-1">This is your citizen portal. You can add and manage your records below.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div @click="currentTab = 'passport'" class="bg-stone-900 p-6 rounded-3xl shadow-xl border border-stone-800 border-l-4 border-l-amber-600 cursor-pointer hover:border-stone-700 transition">
                            <h3 class="font-bold text-stone-300 text-xs uppercase tracking-wider">Passport Status</h3>
                            <p class="text-2xl font-black text-amber-400 mt-2">{{ !empty($passport_number) ? 'Registered' : 'No Record Yet' }}</p>
                            <p class="text-xs text-stone-500 mt-1">Click to register passport &rarr;</p>
                        </div>

                        <div @click="currentTab = 'vehicles'" class="bg-stone-900 p-6 rounded-3xl shadow-xl border border-stone-800 border-l-4 border-l-orange-600 cursor-pointer hover:border-stone-700 transition">
                            <h3 class="font-bold text-stone-300 text-xs uppercase tracking-wider">Registered Vehicles</h3>
                            <p class="text-2xl font-black text-orange-400 mt-2">{{ count($vehicles ?? []) }} Units</p>
                            <p class="text-xs text-stone-500 mt-1">Click to add vehicles &rarr;</p>
                        </div>

                        <div @click="currentTab = 'skills'" class="bg-stone-900 p-6 rounded-3xl shadow-xl border border-stone-800 border-l-4 border-l-yellow-600 cursor-pointer hover:border-stone-700 transition">
                            <h3 class="font-bold text-stone-300 text-xs uppercase tracking-wider">Associated Skills</h3>
                            <p class="text-2xl font-black text-yellow-400 mt-2">{{ count($skills ?? []) }} Skills</p>
                            <p class="text-xs text-stone-500 mt-1">Click to map or add skills &rarr;</p>
                        </div>
                    </div>
                </div>

                <!-- Passport Tab -->
                <div x-show="currentTab === 'passport'" style="display: none;">
                    <div class="bg-stone-900 rounded-3xl shadow-xl p-6 border border-stone-800">
                        <h2 class="text-xl font-bold text-white mb-2">Passport Information</h2>
                        <p class="text-stone-400 text-sm mb-6">Each citizen has only one official passport. It cannot be deleted, only updated.</p>
                        
                        <div class="bg-stone-950 p-6 rounded-2xl border border-stone-800">
                            <form action="/dashboard" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-semibold text-stone-300 uppercase mb-1">Passport Number</label>
                                    <input type="text" name="passport_number" value="{{ $passport_number ?? '' }}" required placeholder="e.g. P1234567A" class="w-full px-4 py-2.5 border border-stone-700 rounded-xl text-sm bg-stone-900 text-white focus:outline-none focus:ring-2 focus:ring-amber-600">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-stone-300 uppercase mb-1">Expiry Date</label>
                                    <input type="date" name="expiry_date" value="{{ $expiry_date ?? '' }}" required class="w-full px-4 py-2.5 border border-stone-700 rounded-xl text-sm bg-stone-900 text-white focus:outline-none focus:ring-2 focus:ring-amber-600">
                                </div>
                                <button type="submit" class="bg-amber-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-amber-600 transition shadow">
                                    {{ !empty($passport_number) ? 'Update Passport' : 'Save Passport' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Vehicles Tab -->
                <div x-show="currentTab === 'vehicles'" style="display: none;">
                    <div class="bg-stone-900 rounded-3xl shadow-xl p-6 border border-stone-800">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-xl font-bold text-white">My Vehicles</h2>
                                <p class="text-stone-400 text-sm">You can add multiple vehicles and delete them when necessary.</p>
                            </div>
                            <button @click="showAddVehicle = !showAddVehicle" class="bg-amber-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-amber-600 transition shadow">
                                + Add Vehicle
                            </button>
                        </div>

                        <div x-show="showAddVehicle" style="display: none;" class="bg-stone-950 p-5 rounded-2xl border border-stone-800 mb-6">
                            <h3 class="text-xs font-bold text-amber-400 uppercase mb-3">New Vehicle Form</h3>
                            <form action="/dashboard" method="POST" class="space-y-3">
                                @csrf
                                <input type="text" name="model" required placeholder="Vehicle Name / Model (e.g. Toyota Vios)" class="w-full px-3.5 py-2.5 border border-stone-700 rounded-xl text-sm bg-stone-900 text-white focus:outline-none focus:ring-2 focus:ring-amber-600">
                                <input type="text" name="plate" required placeholder="Plate Number (e.g. ABC-1234)" class="w-full px-3.5 py-2.5 border border-stone-700 rounded-xl text-sm bg-stone-900 text-white focus:outline-none focus:ring-2 focus:ring-amber-600">
                                <button type="submit" class="bg-amber-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl hover:bg-amber-600 transition">Save Vehicle</button>
                            </form>
                        </div>

                        @if(!empty($vehicles) && count($vehicles) > 0)
                            <div class="space-y-3 mt-4">
                                @foreach($vehicles as $index => $vehicle)
                                    <div class="bg-stone-950 p-4 rounded-2xl border border-stone-800 flex justify-between items-center shadow-sm">
                                        <div>
                                            <h4 class="font-bold text-white">{{ $vehicle['model'] }}</h4>
                                            <p class="text-xs text-stone-400">Plate Number: {{ $vehicle['plate'] }}</p>
                                        </div>
                                        <form action="/dashboard" method="POST">
                                            @csrf
                                            <input type="hidden" name="delete_vehicle_index" value="{{ $index }}">
                                            <button type="submit" class="bg-rose-900/60 hover:bg-rose-800 text-white text-xs font-semibold px-3.5 py-2 rounded-xl transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10 text-stone-500 text-sm border-2 border-dashed border-stone-800 rounded-2xl">
                                No vehicles added yet. Click "+ Add Vehicle" above.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Skills Tab -->
                <div x-show="currentTab === 'skills'" style="display: none;">
                    <div class="bg-stone-900 rounded-3xl shadow-xl p-6 border border-stone-800">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-xl font-bold text-white">Skills</h2>
                                <p class="text-stone-400 text-sm">Type a new skill to add to your profile.</p>
                            </div>
                            <button @click="showAddSkill = !showAddSkill" class="bg-amber-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-amber-600 transition shadow">
                                + Add / Map Skill
                            </button>
                        </div>

                        <div x-show="showAddSkill" style="display: none;" class="bg-stone-950 p-5 rounded-2xl border border-stone-800 mb-6 space-y-4">
                            <div class="pt-2">
                                <h3 class="text-xs font-bold text-amber-400 uppercase mb-2">Add a New Custom Skill</h3>
                                <form action="/dashboard" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="text" name="skill" required placeholder="Type a new skill..." class="w-full px-3.5 py-2.5 border border-stone-700 rounded-xl text-sm bg-stone-900 text-white focus:outline-none focus:ring-2 focus:ring-amber-600">
                                    <button type="submit" class="bg-amber-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl flex-shrink-0 hover:bg-amber-600 transition">Create & Attach</button>
                                </form>
                            </div>
                        </div>

                        @if(!empty($skills) && count($skills) > 0)
                            <div class="space-y-3 mt-4">
                                @foreach($skills as $index => $skill)
                                    <div class="bg-stone-950 p-4 rounded-2xl border border-stone-800 flex justify-between items-center shadow-sm">
                                        <div>
                                            <h4 class="font-bold text-white">{{ $skill['name'] }}</h4>
                                        </div>
                                        <form action="/dashboard" method="POST">
                                            @csrf
                                            <input type="hidden" name="delete_skill_index" value="{{ $index }}">
                                            <button type="submit" class="bg-rose-900/60 hover:bg-rose-800 text-white text-xs font-semibold px-3.5 py-2 rounded-xl transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10 text-stone-500 text-sm border-2 border-dashed border-stone-800 rounded-2xl">
                                No skills chosen yet. Click "+ Add / Map Skill".
                            </div>
                        @endif
                    </div>
                </div>

            </main>

        </div>

    </div>

</body>
</html>