<?php

use Illuminate\Support\Facades\Route;
use Modules\StudentAdmission\Http\Controllers\StudentAdmissionController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('studentadmissions', StudentAdmissionController::class)->names('studentadmission');
});
