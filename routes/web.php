<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::prefix('notes')->controller(NoteController::class)->group(function () {
    Route::get('/', 'index')->name('notes.index');
    Route::get('/create', 'create')->name('notes.create');
    Route::post('/', 'store')->name('notes.store');
    Route::get('/{note}', 'show')->name('notes.show');
    Route::put('/{note}', 'update')->name('notes.update');
    Route::delete('/{note}', 'destroy')->name('notes.destroy');
    Route::get('/{note}/edit', 'edit')->name('notes.edit');
});

Route::redirect('', '/notes');
