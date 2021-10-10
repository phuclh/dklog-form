<?php namespace Phuclh\DKLogForm\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Phuclh\DKLog\Support\Livewire\WithModal;
use Phuclh\DKLog\Support\Livewire\WithNotification;
use Phuclh\DKLogForm\Models\FormSubmission;

class FormSubmissions extends Component
{
    use WithPagination;
    use WithModal;
    use WithNotification;

    public ?FormSubmission $deletingFormSubmission = null;

    public function showDeletingModal($formSubmissionId)
    {
        $this->deletingFormSubmission = FormSubmission::find($formSubmissionId);

        $this->showModal('delete-form-submission');
    }

    public function deleteFormSubmission()
    {
        if (! $this->deletingFormSubmission) {
            $this->error('Cannot find form submission');
        }

        $this->deletingFormSubmission->delete();

        $this->closeModal('delete-form-submission');
        $this->success('Delete form submission successfully!');
    }

    public function getRowsQueryProperty()
    {
        return FormSubmission::latest();
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(25);
    }

    public function render()
    {
        return view('form::admin.form-submissions', [
            'formSubmissions' => $this->rows
        ])->layout('dklog::admin.layouts.app');
    }
}
