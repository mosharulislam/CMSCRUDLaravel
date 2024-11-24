<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;

Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
Route::post('manual-insert', [ContactController::class, 'manualInsert'])->name('contacts.manualInsert');
Route::post('random-insert', [ContactController::class, 'randomInsert'])->name('contacts.randomInsert');
Route::post('edit-multiple', [ContactController::class, 'editMultiple'])->name('contacts.editMultiple');
Route::post('delete-multiple', [ContactController::class, 'deleteMultiple'])->name('contacts.deleteMultiple');
Route::get('edit/{id}', [ContactController::class, 'editForm'])->name('contacts.editForm');
Route::post('edit/{id}', [ContactController::class, 'update'])->name('contacts.update');
Route::post('delete/{id}', [ContactController::class, 'delete'])->name('contacts.delete');

