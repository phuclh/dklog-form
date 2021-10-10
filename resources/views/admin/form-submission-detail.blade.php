<x-slot name="title">{{ $formSubmission->form_name }}</x-slot>

<x-slot name="toolbar">
    <div class="flex justify-start lg:justify-end space-x-2">
        <x-dklog::form.button.link :href="route('admin.plugins.form-submissions')">Back</x-dklog::form.button.link>
        @livewire('phuclh-dklog-form.delete-form-submission-button', ['formSubmission' => $formSubmission])
    </div>
</x-slot>

<div id="phuclh-dklog-form" class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            <a href="{{ $formSubmission->referrer }}" target="_blank" class="hover:text-gray-600 flex items-center">
                <span class="mr-1.5">{{ $formSubmission->referrer }}</span>
                <x-heroicon-o-external-link class="w-4 h-4"/>
            </a>
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            {{ $formSubmission->ip_address }} - {{ $formSubmission->user_agent }}
        </p>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            @foreach($formSubmission->formSubmissionValues as $formSubmissionValue)
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        {{ Str::title($formSubmissionValue->key) }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $formSubmissionValue->value }}
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</div>
