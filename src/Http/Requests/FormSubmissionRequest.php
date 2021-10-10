<?php

namespace Phuclh\DKLogForm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormSubmissionRequest extends FormRequest
{
    public function rules()
    {
        return [
            //
        ];
    }

    public function authorize()
    {
        return true;
    }
}
