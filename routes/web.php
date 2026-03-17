<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprovalController;

Route::get('/', [ApprovalController::class, 'index'])->name('approvals.index');
Route::get('/create', [ApprovalController::class, 'create'])->name('approvals.create');
Route::post('/store', [ApprovalController::class, 'store'])->name('approvals.store');
Route::get('/approve/{id}', [ApprovalController::class, 'approve'])->name('approvals.approve');
Route::get('/reject/{id}', [ApprovalController::class, 'reject'])->name('approvals.reject');

