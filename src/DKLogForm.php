<?php

namespace Phuclh\DKLogForm;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Phuclh\DKLog\Plugin;

class DKLogForm extends Plugin
{
    public function boot(): void
    {
        Form::addFormToEditor();
    }

    public function renderAdminMenu(): View|Factory|null
    {
        return view('form::admin.menu');
    }

    public function renderAdminMobileMenu(): View|Factory|null
    {
        return view('form::admin.mobile-menu');
    }

    public function adminStylePath(): ?string
    {
        return $this->basePath('/../dist/css/admin/plugin.css');
    }

    public function adminScriptPath(): ?string
    {
        return $this->basePath('/../dist/js/admin/plugin.js');
    }

    public function stylePath(): ?string
    {
        return $this->basePath('/../dist/css/plugin.css');
    }

    public function scriptPath(): ?string
    {
        return $this->basePath('/../dist/js/plugin.js');
    }

    public function key(): string
    {
        return 'phuclh-dklog-form';
    }
}
