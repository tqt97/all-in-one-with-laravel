<?php

use Illuminate\Support\Facades\Route;
use Modules\StudentAdmission\Http\Controllers\StudentAdmissionController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('studentadmissions', StudentAdmissionController::class)->names('studentadmission');
});
