<?php

use Illuminate\Support\Facades\Route;
use Phuclh\DKLogForm\Http\Livewire\FormSubmissionDetail;
use Phuclh\DKLogForm\Http\Livewire\FormSubmissions;

Route::get('form-submissions', FormSubmissions::class)->name('form-submissions');
Route::get('form-submissions/{formSubmission}', FormSubmissionDetail::class)->name('form-submissions.show');
