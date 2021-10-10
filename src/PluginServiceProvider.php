<?php

namespace Phuclh\DKLogForm;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Phuclh\DKLogForm\Commands\CompileFormCommand;
use Phuclh\DKLogForm\Http\Livewire\DeleteFormSubmissionButton;
use Phuclh\DKLogForm\Http\Livewire\FormSubmissions;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'form');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CompileFormCommand::class
            ]);
        }

        $this->app->booted(function () {
            $this->registerRoutes();
        });

        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/../config/form.php', 'form');
        }

        $this->registerBladeDirectives();
        $this->registerAllForms();
        $this->registerLivewireComponents();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function registerRoutes()
    {
        Route::middleware('dklog')
            ->name('plugins.')
            ->group(__DIR__ . '/../routes/web.php');

        Route::middleware(['dklog', 'auth'])
            ->prefix(config('dk.admin_path') . '/plugins')
            ->name('admin.plugins.')
            ->group(__DIR__ . '/../routes/admin.php');
    }

    protected function registerBladeDirectives(): void
    {
        Blade::directive('formStyles', function ($expression) {
            if (!($form = Form::findByKey(trim($expression, "'")))) {
                return null;
            }

            return <<<EOT
            <script>
                var head = document.head;
                var link = document.createElement("link");

                link.type = "text/css";
                link.rel = "stylesheet";
                link.href = "<?php echo '{$form->styleUrl()}'; ?>";

                head.appendChild(link);
            </script>
            EOT;
        });
    }

    protected function registerAllForms(): void
    {
        // Register all forms here instead of plugin boot method
        // to make Console can also access the forms.
        Form::registerIn(config('form.forms_path'));
    }

    protected function registerLivewireComponents(): void
    {
        Livewire::component('phuclh-dklog-form.form-submissions', FormSubmissions::class);
        Livewire::component('phuclh-dklog-form.delete-form-submission-button', DeleteFormSubmissionButton::class);
    }
}
