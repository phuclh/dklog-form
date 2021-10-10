<x-slot name="title">Form Submissions</x-slot>

<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Referrer
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Submitted At
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($formSubmissions as $formSubmission)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.plugins.form-submissions.show', $formSubmission) }}" class="text-sm font-medium text-gray-900 hover:text-gray-500 block">
                                    {{ $formSubmission->form_name }}
                                </a>
                                <x-dklog::tag type="success">{{ $formSubmission->form_id }}</x-dklog::tag>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ $formSubmission->referrer }}" target="_blank" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
                                    <span class="mr-1.5">{{ $formSubmission->referrer }}</span>
                                    <x-heroicon-o-external-link class="w-4 h-4"/>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $formSubmission->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.plugins.form-submissions.show', $formSubmission) }}" class="text-gray-800 hover:text-gray-600">View</a>
                                <a wire:click.prevent="showDeletingModal('{{ $formSubmission->id }}')" href="#" class="text-red-600 hover:text-red-400">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-gray-500 font-medium text-lg text-center p-6">
                                There are no form submissions.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                @if ($formSubmissions->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $formSubmissions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-dklog::confirm id="delete-form-submission" submit="deleteFormSubmission">
        <x-slot name="title">Delete {{ $deletingFormSubmission?->form_name }}</x-slot>
    </x-dklog::confirm>
</div>
