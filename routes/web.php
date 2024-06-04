<?php

use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ToolIndicatorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('tools/search', [ToolController::class, 'search' ])->name('tools.search');
    Route::resource('tools', ToolController::class);
    Route::put('tools/change/{tool}', [ToolController::class, 'change'])->name('tools.change');

    Route::get('indicators/search', [IndicatorController::class, 'search' ])->name('indicators.search');
    Route::resource('indicators', IndicatorController::class);
    Route::put('indicators/change/{indicator}', [IndicatorController::class, 'change'])->name('indicators.change');

    Route::get('/tool-indicators/{tool_id}', [ToolIndicatorController::class, 'index'])->name('toolIndicators.index');
    Route::delete('/tool-indicators/{toolIndicatorId}', [ToolIndicatorController::class, 'destroy'])->name('toolIndicators.destroy');
    Route::post('/tool-indicators/{toolId}', [ToolIndicatorController::class, 'store'])->name('toolIndicators.store');

    Route::get('/tool-indicators/questions/{toolIndicatorId}', [QuestionController::class, 'index'])->name('questions.index');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    Route::get('/tool-indicators/{toolIndicator}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/tool-indicators/{toolIndicator}/questions', [QuestionController::class, 'store'])->name('questions.store');

});
