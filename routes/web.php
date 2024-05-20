<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeaponController;
use App\Http\Controllers\InventoryController;

Route::get('/',[WeaponController::class, 'index']);

Route::resource('weapons', WeaponController::class);
Route::resource('inventory', InventoryController::class);
// Route::delete('inventory/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.destroy');


Route::get('/weapon/inventory', [InventoryController::class, 'index'])->name('weapon.inventory.index');

