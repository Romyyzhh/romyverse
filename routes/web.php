<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaintingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Admin Auth Routes
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login']);
    Route::get('/admin/register', [AdminAuthController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('/admin/register', [AdminAuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // Admin logout
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    
    // Protected painting routes
    Route::get('/paintings/create', [PaintingController::class, 'create'])->name('paintings.create');
    Route::post('/paintings', [PaintingController::class, 'store'])->name('paintings.store');
    Route::get('/paintings/{painting}/edit', [PaintingController::class, 'edit'])->name('paintings.edit');
    Route::put('/paintings/{painting}', [PaintingController::class, 'update'])->name('paintings.update');
    Route::delete('/paintings/{painting}', [PaintingController::class, 'destroy'])->name('paintings.destroy');
    
    // Admin Routes
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
        Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    });
    
    // Comment routes
    Route::post('/paintings/{painting}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // Like routes
    Route::post('/paintings/{painting}/like', [LikeController::class, 'toggle'])->name('paintings.like');
    Route::get('/likes', [LikeController::class, 'index'])->name('likes.index');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'myProfile'])->name('profile');
    Route::get('/profile/{id}', [ProfileController::class, 'publicProfile'])->name('profile.public');
    
    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read.all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

// Public painting routes
Route::get('/', function () { return redirect()->route('paintings.index'); });
Route::get('/paintings', [PaintingController::class, 'index'])->name('paintings.index');
Route::get('/paintings/{painting}', [PaintingController::class, 'show'])->name('paintings.show');
Route::get('/paintings/{painting}/pdf', [PaintingController::class, 'exportPdf'])->name('paintings.pdf');

Route::get('/debug-paintings', function () {
    $paintings = DB::table('paintings')->get();
    return response()->json($paintings);
});
