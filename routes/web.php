<?php

use App\Http\Controllers\HouseOwnerController;
use App\Http\Controllers\HouseOwnerAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FlatController;
use App\Http\Controllers\BillCategoryController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\BillCollection;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// House Owner Authentication Routes
Route::prefix('house-owner')->name('house-owner.')->group(function () {
    
    // Guest routes (not authenticated)
    Route::middleware('guest:house_owner')->group(function () {
        Route::get('login', [HouseOwnerAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [HouseOwnerAuthController::class, 'login']);
    });
    
    // Authenticated house owner routes
    Route::middleware('auth:house_owner')->group(function () {
        Route::post('logout', [HouseOwnerAuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [HouseOwnerAuthController::class, 'dashboard'])->name('dashboard');
        Route::get('building', [HouseOwnerAuthController::class, 'building'])->name('building');
        Route::resource('/flats', FlatController::class);
        Route::resource('/bill-categories', BillCategoryController::class);
        Route::resource('/bills', BillController::class);
        Route::post('/bills/check-existing', [BillController::class, 'checkExisting'])->name('bills.check-existing');
        Route::resource('/bill-collections', BillCollection::class);
        Route::get('/bill-collection/{bill}/collect', [BillCollection::class, 'collect'])->name('bill-collection.collect');
        Route::put('/bill-collection/{bill}/update', [BillCollection::class, 'updatePayment'])->name('bill-collection.update');
        
    });
});

// Admin Routes (Default Web Guard)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/house-owners', HouseOwnerController::class);
    Route::resource('/tenants', TenantController::class);
    Route::get('/get-flats/{building}', [FlatController::class, 'getFlats']);

});

require __DIR__.'/auth.php';
