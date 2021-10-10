<?php

namespace Phuclh\DKLogForm\Commands;

use Illuminate\Console\Command;
use Phuclh\DKLog\Commands\Concerns\HasStubs;
use Phuclh\DKLogForm\BaseForm;
use Phuclh\DKLogForm\Form;
use Symfony\Component\Process\Process;

class CompileFormCommand extends Command
{
    use HasStubs;

    protected $signature = 'form:compile
                                {name}
                                {--p|production : Minify all CSS output AND set NODE_ENV to "production" for other optimizations within Tailwind}
                                {--m|minify : Minify all CSS output files using cssnano}
                                {--w|watch : Watch all purge reference files for changes and re-build the CSS output}
                                {--c|config= : Tailwind config file path}';

    protected $description = 'Compile assets of a form.';

    public function handle()
    {
        $form = Form::findByKey($this->argument('name'));

        if (!$form) {
            $this->line('');
            $this->error('Cannot find "' . $this->argument('name') . '" form class. Please make sure you already registered it.');

            return;
        }

        $this->compile($form);
    }

    /**
     * Compile the form's assets.
     *
     * @return void
     */
    protected function compile(BaseForm $form, $path = '/')
    {
        $tailwindConfigStubPath = $this->getTailwindConfigStubPath();

        if (!file_exists($tailwindConfigStubPath)) {
            $this->line('');
            $this->error('Cannot find the Tailwind config stub file at: ' . $tailwindConfigStubPath);

            return;
        }

        // Get content from the Tailwind config stub.
        $rawTailwindConfigContent = file_get_contents($tailwindConfigStubPath);

        // Copy the stub content and generate tailwind-form.config.js.
        $tailwindConfigPath = __DIR__ . '/../../tailwind-form.config.js';
        file_put_contents($tailwindConfigPath, $rawTailwindConfigContent);

        // Replace all placeholders.
        $this->replace('{{ important }}', "'#{$form->key()}'", $tailwindConfigPath);
        $this->replace('{{ purge }}', "['{$form->view()->getPath()}']", $tailwindConfigPath);

        $this->executeCommand(
            $this->generateCommand($form, $tailwindConfigPath, $this->concatOptions()),
            $path
        );

        unlink($tailwindConfigPath);

        $this->line('');
        $this->info('Compile assets of "' . $this->argument('name') . '" form successfully!');
        $this->info('File path: ' . $form->stylePath());
    }

    /**
     * Run the given command as a process.
     *
     * @param string $command
     * @param string $path
     * @return void
     */
    protected function executeCommand(string $command, string $path)
    {
        $process = (Process::fromShellCommandline($command, $path))->setTimeout(null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            $process->setTty(true);
        }

        $process->run(function ($type, $line) {
            $this->output->write($line);
        });
    }

    /**
     * Replace the given string in the given file.
     *
     * @param string $search
     * @param string $replace
     * @param string $path
     * @return void
     */
    protected function replace(string $search, string $replace, string $path): void
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    /**
     * Determine which Tailwind config stub is used.
     *
     * @return string
     */
    protected function getTailwindConfigStubPath(): string
    {
        if ($this->option('config')) {
            return $this->option('config');
        }

        if (file_exists(base_path('stubs/forms/tailwind-form.stub'))) {
            return base_path('stubs/forms/tailwind-form.stub');
        }

        return __DIR__ . '/../../stubs/tailwind-form.stub';
    }

    /**
     * Generate the compile command.
     *
     * @param BaseForm $form
     * @param string $tailwindConfigPath
     * @param string $options
     * @return string
     */
    protected function generateCommand(BaseForm $form, string $tailwindConfigPath, string $options): string
    {
        $command = 'npx tailwindcss -o ' . $form->stylePath() . ' -c ' . $tailwindConfigPath . ' ' . $options;

        if ($this->option('production')) {
            $command = 'NODE_ENV=production ' . $command;
        }

        return $command;
    }

    /**
     * Get all options and convert them to string.
     *
     * @return string
     */
    protected function concatOptions(): string
    {
        return collect($this->options())
            ->only('minify', 'watch')
            ->filter(fn($isUsing) => (bool)$isUsing)
            ->keys()
            ->map(fn(string $option) => '--' . $option)
            ->implode(' ');
    }
}
