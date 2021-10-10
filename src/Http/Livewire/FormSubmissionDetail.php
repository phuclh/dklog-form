<?php namespace Phuclh\DKLogForm\Http\Livewire;

use Livewire\Component;
use Phuclh\DKLogForm\Models\FormSubmission;

class FormSubmissionDetail extends Component
{
    public FormSubmission $formSubmission;

    public function render()
    {
        return view('form::admin.form-submission-detail')->layout('dklog::admin.layouts.app');
    }
}
