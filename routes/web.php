<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserAuthController;

// Restaurant Dashboard Controllers
use App\Http\Controllers\Restaurant\AuthController as RestaurantAuthController;
use App\Http\Controllers\Restaurant\DashboardController;
use App\Http\Controllers\Restaurant\OrderController as RestaurantOrderController;
use App\Http\Controllers\Restaurant\MealController as RestaurantMealController;
use App\Http\Controllers\Restaurant\CategoryController as RestaurantCategoryController;

/*
|--------------------------------------------------------------------------
| USER WEBSITE ROUTES (Customer Side)
|--------------------------------------------------------------------------
*/

// Home Page - List all restaurants
Route::get('/', [HomeController::class, 'index'])->name('home');

// Restaurant Details - Show categories
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');

// Meal Details
Route::get('/meals/{meal}', [MealController::class, 'show'])->name('meals.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{meal}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{meal}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{meal}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout & Order Routes
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation');

// Optional: User Authentication
Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.submit');
Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [UserAuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

// Optional: User Order History (requires login)
Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my-orders');
    Route::get('/profile', [UserAuthController::class, 'profile'])->name('profile');
});

/*
|--------------------------------------------------------------------------
| RESTAURANT DASHBOARD ROUTES
|--------------------------------------------------------------------------
*/

// Restaurant Login/Logout (Public)
Route::get('/restaurant/login', [RestaurantAuthController::class, 'showLogin'])->name('restaurant.login');
Route::post('/restaurant/login', [RestaurantAuthController::class, 'login'])->name('restaurant.login.submit');
Route::post('/restaurant/logout', [RestaurantAuthController::class, 'logout'])->name('restaurant.logout');

// Restaurant Dashboard (Protected Routes)
Route::middleware(['restaurant.auth'])->prefix('restaurant')->name('restaurant.')->group(function () {
    
    // Dashboard Home
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    
    // Orders Management
    Route::get('/orders', [RestaurantOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [RestaurantOrderController::class, 'show'])->name('orders.show')->middleware('restaurant.owner');
    Route::patch('/orders/{order}/status', [RestaurantOrderController::class, 'updateStatus'])->name('orders.updateStatus')->middleware('restaurant.owner');
    
    // Categories Management
    Route::get('/categories', [RestaurantCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [RestaurantCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [RestaurantCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [RestaurantCategoryController::class, 'edit'])->name('categories.edit')->middleware('restaurant.owner');
    Route::put('/categories/{category}', [RestaurantCategoryController::class, 'update'])->name('categories.update')->middleware('restaurant.owner');
    Route::delete('/categories/{category}', [RestaurantCategoryController::class, 'destroy'])->name('categories.destroy')->middleware('restaurant.owner');
    
    // Meals Management
    Route::get('/meals', [RestaurantMealController::class, 'index'])->name('meals.index');
    Route::get('/meals/create', [RestaurantMealController::class, 'create'])->name('meals.create');
    Route::post('/meals', [RestaurantMealController::class, 'store'])->name('meals.store');
    Route::get('/meals/{meal}/edit', [RestaurantMealController::class, 'edit'])->name('meals.edit')->middleware('restaurant.owner');
    Route::put('/meals/{meal}', [RestaurantMealController::class, 'update'])->name('meals.update')->middleware('restaurant.owner');
    Route::delete('/meals/{meal}', [RestaurantMealController::class, 'destroy'])->name('meals.destroy')->middleware('restaurant.owner');
});