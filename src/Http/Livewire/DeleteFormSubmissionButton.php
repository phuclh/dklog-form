<?php namespace Phuclh\DKLogForm\Http\Livewire;

use Livewire\Component;
use Phuclh\DKLogForm\Models\FormSubmission;

class DeleteFormSubmissionButton extends Component
{
    public FormSubmission $formSubmission;

    public function deleteFormSubmission()
    {
        $this->formSubmission->delete();

        $this->redirectRoute('admin.plugins.form-submissions');
    }

    public function render()
    {
        return view('form::admin.delete-form-submission-button')->layout('dklog::admin.layouts.app');
    }
}
