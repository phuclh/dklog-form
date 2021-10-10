<?php namespace Phuclh\DKLogForm;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Phuclh\DKLog\DK;

abstract class BaseForm
{
    public function name(): string
    {
        return DK::humanize(Str::afterLast(get_class($this), '\\'));
    }

    public function fields(): array
    {
        return array_keys($this->rules());
    }

    public function stylePath(): string
    {
        return public_path('forms/' . $this->key() . '.css');
    }

    public function styleUrl(): string
    {
        return asset('forms/' . $this->key() . '.css');
    }

    public function redirect(): ?string
    {
        return null;
    }

    public function message(): string
    {
        return 'Thank you for your submission!';
    }

    public function shouldRedirect(): bool
    {
        return !empty($this->redirect());
    }

    public function render(): string
    {
        return $this->view()->render();
    }

    public function rules(): array
    {
        return [];
    }

    public abstract function view(): View|Factory;

    public abstract function key(): string;
}
