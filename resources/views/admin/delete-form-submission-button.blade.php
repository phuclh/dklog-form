<div>
    <div id="phuclh-dklog-form">
        <a x-data x-on:click.prevent="$dispatch('delete-form-submission', {type: 'show'})" href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-25">
            <x-heroicon-o-trash class="w-5 h-5"/>
            <span class="ml-1">Delete</span>
        </a>
    </div>


    <x-dklog::confirm id="delete-form-submission">
        <x-slot name="title">Delete Form Submission</x-slot>
        <x-slot name="actions">
            <x-dklog::form.button x-on:click="show = false" secondary>Cancel</x-dklog::form.button>
            <x-dklog::form.button wire:click="deleteFormSubmission">Confirm</x-dklog::form.button>
        </x-slot>
    </x-dklog::confirm>
</div>
