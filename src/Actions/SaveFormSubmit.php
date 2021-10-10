<?php namespace Phuclh\DKLogForm\Actions;

use Phuclh\DKLogForm\BaseForm;
use Phuclh\DKLogForm\Models\FormSubmission;

class SaveFormSubmit
{
    public function execute(BaseForm $form, array $data): FormSubmission
    {
        /** @var FormSubmission $formSubmission */
        $formSubmission = FormSubmission::create([
            'form_name'  => $form->name(),
            'form_id'    => $form->key(),
            'referrer'   => $data['referrer'],
            'ip_address' => $data['ip_address'],
            'user_agent' => $data['user_agent']
        ]);

        $fieldValues = collect($data)
            ->only($form->fields())
            ->map(function ($value, $key) {
                return [
                    'key'   => $key,
                    'value' => $value
                ];
            })
            ->values();

        $formSubmission->formSubmissionValues()->createMany($fieldValues);

        return $formSubmission;
    }
}
