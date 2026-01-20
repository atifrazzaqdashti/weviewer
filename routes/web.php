<?php

use Illuminate\Support\Facades\Route;
use Atifrazzaq\weviewer\Http\Controllers\WeviewerController;

Route::middleware(['web', 'Illuminate\Session\Middleware\StartSession'])->group(function () {
    Route::get('/weviewer/login', [WeviewerController::class, 'showAuth'])->name('weviewer.login');
    Route::post('/weviewer/auth', [WeviewerController::class, 'authenticate'])->name('weviewer.auth');
});

Route::prefix('weviewer')->middleware(['web', 'Illuminate\Session\Middleware\StartSession', 'weviewer.enabled'])->group(function () {
    Route::get('/', [WeviewerController::class, 'dashboard'])->name('weviewer.dashboard');
    Route::get('/tables', [WeviewerController::class, 'tables'])->name('weviewer.tables');
    Route::get('/table/{table}', [WeviewerController::class, 'viewTable'])->name('weviewer.table.view');
    Route::get('/table/{table}/export', [WeviewerController::class, 'exportTable'])->name('weviewer.table.export');
    Route::get('/table/{table}/export-row/{id}', [WeviewerController::class, 'exportRow'])->name('weviewer.table.export-row');
    Route::post('/export-multiple', [WeviewerController::class, 'exportMultiple'])->name('weviewer.export.multiple');
    Route::get('/export-database', [WeviewerController::class, 'exportDatabase'])->name('weviewer.export.database');
    Route::get('/logs', [WeviewerController::class, 'logs'])->name('weviewer.logs');
    Route::get('/logs/download/{filename}', [WeviewerController::class, 'downloadLog'])->name('weviewer.logs.download');
    Route::delete('/logs/delete/{filename}', [WeviewerController::class, 'deleteLog'])->name('weviewer.logs.delete');
    Route::get('/logs/view/{filename}', [WeviewerController::class, 'viewLog'])->name('weviewer.logs.view');
    Route::get('/logs/tail/{filename}', [WeviewerController::class, 'tailLog'])->name('weviewer.logs.tail');
    Route::get('/routes', [WeviewerController::class, 'routes'])->name('weviewer.routes');
});