# DKLog Form
Add ability to create and submit forms for DKLog.

## Installation

```bash
composer require phuclh/dklog-form
```

## Compile Form Assets

```bash
php artisan form:compile 
                        {form-id}
                        {--p|production : Minify all CSS output AND set NODE_ENV to "production" for other optimizations within Tailwind}
                        {--m|minify : Minify all CSS output files using cssnano}
                        {--w|watch : Watch all purge reference files for changes and re-build the CSS output}
                        {--c|config= : Tailwind config file path}
```

## Blade Directives + Helpers

- Add Form stylesheet file to head tag of current page: `@formStyles('newsletter-form')`
- Create a link to Form Submission method: `route('plugins.forms.submit', 'newsletter-form')` 
- Include a Form into a view: `{!! \Phuclh\DKLogForm\Form::include('newsletter-form') !!}`

## Example of Form Class

```php
class NewsletterForm extends BaseForm
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email']
        ];
    }

    public function redirect(): ?string
    {
        return 'newsletter-subscribed';
    }

    public function view(): View|Factory
    {
        return view('forms.newsletter-form');
    }

    public function key(): string
    {
        return 'newsletter-form';
    }
}
```

## Todo
- [] Command to generate Form class.
- [] Publishing plugin config/assets.
- [] Add @includeForm directive. 

