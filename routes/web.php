<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;


Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/register', function (Request $request) {
    $inputName = trim($request->input('name'));

  
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:users,name',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    $firstName = explode(' ', $inputName)[0]; 
    $existingUser = User::where('name', 'LIKE', $firstName . '%')->where('email', '!=', $validated['email'])->exists();

    if ($existingUser) {
        return back()->withErrors(['name' => 'Warning: This citizen or a similar name already exists in the system! Only one account per person is allowed.'])->withInput();
    }

    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'citizen', 
    ]);

    return redirect('/')->with('success', 'Registration successful! You can now login!.');
});


Route::post('/login', function (Request $request) {$throttleKey = Str::lower($request->input('email')) . '\vert{}' .$request->ip();

    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
        $seconds = RateLimiter::availableIn($throttleKey);
        $minutes = ceil($seconds / 60);

        return back()->withErrors([
            'email' => "Too many login attempts. Please wait for {$minutes} minutes before you can try again!.",
        ]);
    }

    $credentials =$request->only('email', 'password');

    if (auth()->attempt($credentials)) {
        RateLimiter::clear($throttleKey);$request->session()->regenerate();
        
        if (auth()->user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/dashboard');
    }

    RateLimiter::hit($throttleKey, 300);

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records. (Limit: 5 attempts)',
    ]);
});


Route::get('/admin/dashboard', function (Request $request) {

    $citizens = User::where('role', 'citizen')->get();
    
    $allVehicles = [];
    $allSkills = [];

    foreach ($citizens as $citizen) {
        $cId = $citizen->id;
        

        $citizenVehicles = session("user_{$cId}_vehicles", session('vehicles', []));
        foreach ($citizenVehicles as $veh) {
            $allVehicles[] = [
                'owner' => $citizen->name,
                'model' => $veh['model'] ?? 'N/A',
                'plate' => $veh['plate'] ?? 'N/A',
            ];
        }


        $citizenSkills = session("user_{$cId}_skills", session('skills', []));
        foreach ($citizenSkills as $skl) {
            $allSkills[] = [
                'owner' => $citizen->name,
                'name' => $skl['name'] ?? 'N/A',
            ];
        }
    }

    return view('admin.dashboard', [
        'allVehicles' => $allVehicles,
        'allSkills' => $allSkills,
        'citizens' => $citizens
    ]);

});


Route::match(['get', 'post'], '/dashboard', function (Request $request) {
    if (!auth()->check()) {
        return redirect('/');
    }

    $userId = auth()->id();
    $vKey = "user_{$userId}_vehicles";
    $sKey = "user_{$userId}_skills";
    $pKey = "user_{$userId}_passport";
    $eKey = "user_{$userId}_expiry";

    if ($request->isMethod('post')) {
        

        if ($request->has('delete_vehicle_index')) {
            $vehicles = session($vKey, []);
            unset($vehicles[$request->input('delete_vehicle_index')]);
            session([$vKey => array_values($vehicles)]);
            return redirect('/dashboard')->with('success', 'Vehicle deleted successfully!');
        }

        if ($request->has('delete_skill_index')) {
            $skills = session($sKey, []);
            unset($skills[$request->input('delete_skill_index')]);
            session([$sKey => array_values($skills)]);
            return redirect('/dashboard')->with('success', 'Skill deleted successfully!');
        }

   
        if ($request->has('passport_number')) {
            session([
                $pKey =>$request->input('passport_number'),
                $eKey =>$request->input('expiry_date')
            ]);
            return redirect('/dashboard')->with('success', 'Passport saved successfully!');
        }

   
        if ($request->has('model') || $request->has('plate')) {$vehicles = session($vKey, []);$vehicles[] = [
                'model' => $request->input('model'),
                'plate' => $request->input('plate'),
            ];
            session([$vKey =>$vehicles]);
            return redirect('/dashboard')->with('success', 'Vehicle added successfully!');
        }


        if ($request->has('skill')) {$skills = session($sKey, []);$skills[] = [
                'name' => $request->input('skill'),
            ];
            session([$sKey =>$skills]);
            return redirect('/dashboard')->with('success', 'Skill added successfully!');
        }

        return redirect('/dashboard')->with('success', 'Record saved successfully!');
    }

    return view('citizens.index', [
        'vehicles' => session($vKey, []),
        'skills' => session($sKey, []),
        'passport_number' => session($pKey),
        'expiry_date' => session($eKey)
    ]);
});


Route::match(['get', 'post'], '/logout', function (Request $request) {
    auth()->logout();
    $request->session()->regenerateToken();
    return redirect('/');
});