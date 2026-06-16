<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class MakeModuleCommand extends Command
{
    protected Filesystem $files;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Module for front-end and back-end';

    protected Stringable $module;

    /**
     * Execute the console command.
     *
     *
     * @throws FileNotFoundException
     */
    public function handle(Filesystem $files, MakeFrontEndModule $frontEndModule, MakeBackEndModule $backEndModule): void
    {
        $this->files = $files;

        $this->module = Str::of(class_basename($this->argument('name')))->studly()->singular();

        $this->createModel();

        $this->createMigration();

        $backEndModule->create($this->module);

        $frontEndModule->create($this->module);

        $this->createFactory();

        $this->createTest();
    }

    /**
     * Create a model file for the module.
     */
    protected function createModel(): void
    {
        $this->call('make:model', [
            'name' => $this->module,
        ]);
    }

    /**
     * Create a migration file for the module.
     */
    protected function createMigration(): void
    {
        $table = $this->module->plural()->snake();

        try {
            $this->call('make:migration', [
                'name' => sprintf('create_%s_table', $table),
                '--create' => $table,
            ]);
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * Create a factory file for the module.
     */
    protected function createFactory(): void
    {
        $this->call('make:factory', [
            'name' => $this->module.'Factory',
            '--model' => $this->module,
        ]);
    }

    /**
     * Create test files for the module.
     *
     * @return void
     *
     * @throws FileNotFoundException
     */
    protected function createTest()
    {
        $actions = ['Index', 'Store', 'Show', 'Update', 'Destroy'];

        foreach ($actions as $action) {
            $path = app_path(sprintf('Modules/%s/Tests/%s%sTest.php', $this->module, $this->module, $action));

            if ($this->alreadyExists($path)) {
                $this->error(sprintf('%s%sTest already exists!', $this->module, $action));
            } else {
                $stub = (new Filesystem)->get(base_path('stubs/backEnd/test.'.strtolower($action).'.stub'));

                $this->createFileWithStub($stub, $path);

                $this->components->info(sprintf('%s%sTest created successfully.', $this->module, $action));
            }
        }
    }

    /**
     * Determine if the class already exists.
     *
     * @param  string  $path
     * @return bool
     */
    protected function alreadyExists($path)
    {
        return $this->files->exists($path);
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * @param  $stub
     * @param  $path
     * @return void
     */
    protected function createFileWithStub($stub, $path)
    {
        $this->makeDirectory($path);

        $content = str_replace([
            'DummyRootNamespace',
            'DummySingular',
            'DummyPlural',
            'DUMMY_VARIABLE_SINGULAR',
            'DUMMY_VARIABLE_PLURAL',
            'dummyVariableSingular',
            'dummyVariablePlural',
            'dummy-plural',
        ], [
            App::getNamespace(),
            $this->module,
            $this->module->pluralStudly(),
            $this->module->snake()->upper(),
            $this->module->plural()->snake()->upper(),
            lcfirst($this->module),
            lcfirst($this->module->pluralStudly()),
            lcfirst($this->module->plural()->snake('-')),
        ],
            $stub
        );

        $this->files->put($path, $content);
    }
}
