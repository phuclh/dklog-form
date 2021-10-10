<?php

use Illuminate\Support\Facades\Route;
use Phuclh\DKLogForm\Http\Controllers\SubmitFormController;

Route::post('forms/{formId}/submit', SubmitFormController::class)->name('forms.submit');
