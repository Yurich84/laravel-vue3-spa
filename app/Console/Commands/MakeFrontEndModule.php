<?php

namespace App\Console\Commands;

use Illuminate\Console\View\Components\Factory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Stringable;
use Symfony\Component\Console\Output\ConsoleOutput;

class MakeFrontEndModule extends MakeModuleCommand
{
    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput;
        $this->components = new Factory($this->output);
    }

    private ?string $module_path = null;

    /**
     * @param  $module
     *
     * @throws FileNotFoundException
     */
    protected function create(Stringable $module)
    {
        $this->files = new Filesystem;
        $this->module = $module;
        $this->module_path = base_path('resources/js/modules/'.lcfirst((string) $this->module));

        $this->createVueList();
        $this->createVueView();
        $this->createVueForm();

        $this->createStore();

        $this->createRoutes();
        $this->createApi();
    }

    /**
     * Create a Vue component file for the module.
     *
     *
     * @throws FileNotFoundException
     */
    private function createVueList(): void
    {
        $path = $this->module_path.sprintf('/components/%sList.vue', $this->module);

        if ($this->alreadyExists($path)) {
            $this->components->error('VueList Component already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/vue.list.stub'));

            $this->createFileWithStub($stub, $path);

            $this->components->info('VueList Component created successfully.');
        }
    }

    /**
     * Create a Vue component file for the module.
     *
     *
     * @throws FileNotFoundException
     */
    private function createVueView(): void
    {
        $path = $this->module_path.sprintf('/components/%sView.vue', $this->module);

        if ($this->alreadyExists($path)) {
            $this->components->error('VueView Component already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/vue.view.stub'));

            $this->createFileWithStub($stub, $path);

            $this->components->info('VueView Component created successfully.');
        }
    }

    /**
     * Create a Vue component file for the module.
     *
     *
     * @throws FileNotFoundException
     */
    private function createVueForm(): void
    {
        $path = $this->module_path.sprintf('/components/%sForm.vue', $this->module);

        if ($this->alreadyExists($path)) {
            $this->components->error('VueForm Component already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/vue.form.stub'));

            $this->createFileWithStub($stub, $path);

            $this->components->info('VueForm Component created successfully.');
        }
    }

    /**
     * Create a Vue component file for the module.
     *
     *
     * @throws FileNotFoundException
     */
    private function createStore(): void
    {
        $moduleLC = lcfirst($this->module);
        $path = $this->module_path.sprintf('/%sStore.js', $moduleLC);

        if ($this->alreadyExists($path)) {
            $this->components->error('Store already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/store.stub'));

            $this->createFileWithStub($stub, $path);

            $this->components->info('Store created successfully.');
        }
    }

    /**
     * Create a Vue component file for the module.
     *
     *
     * @throws FileNotFoundException
     */
    private function createRoutes(): void
    {
        $path = $this->module_path.'/routes.js';

        if ($this->alreadyExists($path)) {
            $this->components->error('Vue Routes already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/routes.stub'));

            $this->createFileWithStub($stub, $path);

            $this->components->info('Vue Routes created successfully.');
        }
    }

    /**
     * Create a Vue component file for the module.
     *
     *
     * @throws FileNotFoundException
     */
    private function createApi(): void
    {
        $moduleLC = lcfirst($this->module);
        $path = $this->module_path.sprintf('/%sApi.js', $moduleLC);

        if ($this->alreadyExists($path)) {
            $this->components->error('Api file already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/api.stub'));

            $this->createFileWithStub($stub, $path);

            $this->components->info('Api file created successfully.');
        }
    }
}
