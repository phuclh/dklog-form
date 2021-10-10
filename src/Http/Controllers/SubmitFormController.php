<?php namespace Phuclh\DKLogForm\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Phuclh\DKLogForm\Actions\SaveFormSubmit;
use Phuclh\DKLogForm\Exceptions\FormNotFoundException;
use Phuclh\DKLogForm\Form;
use Phuclh\DKLogForm\Http\Requests\FormSubmissionRequest;

class SubmitFormController extends Controller
{
    /**
     * @throws FormNotFoundException
     */
    public function __invoke(string $formId, FormSubmissionRequest $request): RedirectResponse
    {
        $form = Form::findByKey($formId);

        if (!$form) {
            throw new FormNotFoundException('Cannot find the form with ID: ' . $formId);
        }

        $request->validate($form->rules());

        $data = array_merge($request->all(), [
            'referrer'   => $request->server('HTTP_REFERER'),
            'ip_address' => $request->getClientIp(),
            'user_agent' => $request->userAgent()
        ]);

        (new SaveFormSubmit)->execute($form, $data);

        if ($form->shouldRedirect()) {
            return redirect()->route('content.show', $form->redirect());
        }

        $request->session()->flash('form:message', $form->message());

        return redirect()->back();
    }
}
