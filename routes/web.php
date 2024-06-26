<?php

use Illuminate\Support\Facades\Route;

// Start Imports For Setup 
use App\Http\Controllers\DatabaseTestController;
use App\Http\Controllers\AdminSetupController;
use Illuminate\Http\Request;
// End Imports For Setup

// Start Of Admin Imports
use App\Http\Controllers\AdminController;
// End Of Admin Imports





// Start Of Setup Routes
Route::get('/setup/install', function() {
    if (getenv('SETUP') !== 'FALSE') {
        return redirect("/");
    } else {
        return view('install');
    }
    
});
Route::get('/login', function() {
    if (getenv("SETUP") == "TRUE") {
        return view('login');
    } else {
        return redirect("/");
    }
});
Route::get('/setup/db', function() {
    try {
        $previousUrl = $_SERVER['HTTP_REFERER'];
    } catch (Exception $e) {
        return redirect("/");
    }

    // Check if the previous URL was the root URL and it was a redirect
    if ($previousUrl == url('setup/install')) {
        if (getenv("SETUP") == "TRUE") {
            return redirect('/');
        } else {
            return view('database');
        }
    } else {
        return redirect("/"); // or redirect somewhere else, or handle differently
    }
});
Route::get('/setup/admin', function () {

    try {
        $previousUrl = $_SERVER['HTTP_REFERER'];
    } catch (Exception $e) {
        return redirect("/");
    }

    if (getenv('SETUP') !== 'FALSE' && $previousUrl == url('test-database')) {
        return redirect('/');
    }
    return app(AdminSetupController::class)->showAdminForm();
})->name('setup-admin-form');
Route::post('/setup/admin', function (Request $request) {
    if (getenv('SETUP') !== 'FALSE') {
        return redirect('/');
    }
    return app(AdminSetupController::class)->setupAdmin($request);
})->name('setup-admin');
Route::get('/test-database', function () {
    if (getenv('SETUP') === 'TRUE') {
        return redirect('/');
    }

    try {
        if (getenv('SETUP') === 'FALSE' && $_COOKIE['last_page'] == '/setup/db') {
            return view('database');
        }
    } catch (Exception $e) {
        return redirect("/");
    }

    return redirect("/");
})->name('test-database-form');
Route::post('/test-database', function () {
    if (getenv('SETUP') === 'TRUE') {
        return redirect('/');
    }

    try {
        if (getenv('SETUP') === 'FALSE' && $_COOKIE['last_page'] == '/setup/db') {
            return app(DatabaseTestController::class)->testConnection(request());
        }
    } catch (Exception $e) {
        return redirect("/");
    }

    return redirect("/");
})->name('test-database');
// End Of Setup Routes


// Start Of Admin Routes
// Login form route
Route::get('/admin', [AdminController::class, 'showLoginForm'])->name('admin-login-form')->middleware('redirect.if.admin.auth');

// Login request route
Route::post('/admin', [AdminController::class, 'login'])->name('admin-login');

// Protect admin routes
Route::middleware(['check.admin.auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view("dashboard");
    })->name('admin-dashboard');
});
// End Of Admin Routes



// Start Of Main Route
Route::get('/', function () {
    if (getenv("SETUP") == "TRUE") {
        return view('welcome');
    } else {
        return redirect("/setup/install");
    }
});
// End Of Main Route