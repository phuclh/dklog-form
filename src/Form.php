<?php namespace Phuclh\DKLogForm;

use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class Form
{
    public static array $forms = [];

    public static function registerIn(string $directory): void
    {
        $namespace = app()->getNamespace();

        $forms = [];

        foreach ((new Finder)->in($directory)->files() as $form) {
            $form = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($form->getPathname(), app_path() . DIRECTORY_SEPARATOR)
                );

            if (is_subclass_of($form, BaseForm::class)) {
                $form = new $form;

                $forms[$form->key()] = $form;
            }
        }

        static::register($forms);
    }

    public static function register(string|array $forms): static
    {
        is_string($forms) && $forms = [$forms];

        static::$forms = array_merge(static::$forms, $forms);

        return new static;
    }

    public static function allForms(): array
    {
        return static::$forms;
    }

    public static function findByKey(?string $key): ?BaseForm
    {
        return static::allForms()[$key] ?? null;
    }

    public static function addFormToEditor(): void
    {
        $editorTools = config('markdown.dropdown_items');

        array_push($editorTools, 'form');

        config(['markdown.dropdown_items' => $editorTools]);
    }

    public static function include(?string $key): ?string
    {
        if (!($form = static::findByKey($key))) {
            return null;
        }

        return '<div id="' . $form->key() . '">' . $form->render() . '</div>';
    }
}
