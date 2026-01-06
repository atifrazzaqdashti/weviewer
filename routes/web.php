<?php

use Illuminate\Support\Facades\Route;
use Atifrazzaq\weviewer\Http\Controllers\weviewerController;

Route::middleware(['web'])->group(function () {
    Route::get('/weviewer/login', [weviewerController::class, 'showAuth'])->name('weviewer.login');
    Route::post('/weviewer/auth', [weviewerController::class, 'authenticate'])->name('weviewer.auth');
});

Route::prefix('weviewer')->middleware(['web', 'weviewer.enabled'])->group(function () {
    Route::get('/', [weviewerController::class, 'dashboard'])->name('weviewer.dashboard');
    Route::get('/tables', [weviewerController::class, 'tables'])->name('weviewer.tables');
    Route::get('/table/{table}', [weviewerController::class, 'viewTable'])->name('weviewer.table.view');
    Route::get('/table/{table}/export', [weviewerController::class, 'exportTable'])->name('weviewer.table.export');
    Route::get('/table/{table}/export-row/{id}', [weviewerController::class, 'exportRow'])->name('weviewer.table.export-row');
    Route::post('/export-multiple', [weviewerController::class, 'exportMultiple'])->name('weviewer.export.multiple');
    Route::get('/export-database', [weviewerController::class, 'exportDatabase'])->name('weviewer.export.database');
    Route::get('/logs', [weviewerController::class, 'logs'])->name('weviewer.logs');
    Route::get('/logs/download/{filename}', [weviewerController::class, 'downloadLog'])->name('weviewer.logs.download');
    Route::delete('/logs/delete/{filename}', [weviewerController::class, 'deleteLog'])->name('weviewer.logs.delete');
    Route::get('/logs/view/{filename}', [weviewerController::class, 'viewLog'])->name('weviewer.logs.view');
    Route::get('/logs/tail/{filename}', [weviewerController::class, 'tailLog'])->name('weviewer.logs.tail');
    Route::get('/routes', [weviewerController::class, 'routes'])->name('weviewer.routes');
});