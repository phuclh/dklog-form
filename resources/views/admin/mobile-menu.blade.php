<x-dklog::admin.mobile-menu-item icon="heroicon-o-chat-alt-2" :link="route('admin.plugins.form-submissions')" :selected="request()->is(config('dk.admin_path') . '/plugins/form-submissions') || request()->is(config('dk.admin_path') . '/plugins/form-submissions/*')">
    Forms
</x-dklog::admin.mobile-menu-item>
