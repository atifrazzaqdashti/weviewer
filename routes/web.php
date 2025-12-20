<?php

use Illuminate\Support\Facades\Route;
use Atifrazzaq\WeViewer\Http\Controllers\WeViewerController;

Route::middleware(['web', 'Illuminate\Session\Middleware\StartSession'])->get('/weviewer/login', [WeViewerController::class, 'showAuth'])->name('weviewer.login');
Route::get('/weviewer/auth', [WeViewerController::class, 'authenticate'])->name('weviewer.auth');

Route::prefix('weviewer')->middleware(['weviewer.enabled'])->group(function () {
    Route::get('/', [WeViewerController::class, 'dashboard'])->name('weviewer.dashboard');
    Route::get('/tables', [WeViewerController::class, 'tables'])->name('weviewer.tables');
    Route::get('/table/{table}', [WeViewerController::class, 'viewTable'])->name('weviewer.table.view');
    Route::get('/table/{table}/export', [WeViewerController::class, 'exportTable'])->name('weviewer.table.export');
    Route::get('/table/{table}/export-row/{id}', [WeViewerController::class, 'exportRow'])->name('weviewer.table.export-row');
    Route::post('/export-multiple', [WeViewerController::class, 'exportMultiple'])->name('weviewer.export.multiple');
    Route::get('/export-database', [WeViewerController::class, 'exportDatabase'])->name('weviewer.export.database');
    Route::get('/logs', [WeViewerController::class, 'logs'])->name('weviewer.logs');
    Route::get('/logs/download/{filename}', [WeViewerController::class, 'downloadLog'])->name('weviewer.logs.download');
    Route::delete('/logs/delete/{filename}', [WeViewerController::class, 'deleteLog'])->name('weviewer.logs.delete');
    Route::get('/logs/view/{filename}', [WeViewerController::class, 'viewLog'])->name('weviewer.logs.view');
    Route::get('/logs/tail/{filename}', [WeViewerController::class, 'tailLog'])->name('weviewer.logs.tail');
    Route::get('/routes', [WeViewerController::class, 'routes'])->name('weviewer.routes');
});