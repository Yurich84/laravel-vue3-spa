<?php

namespace App\Console\Commands;

use Illuminate\Console\View\Components\Factory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Output\ConsoleOutput;

class MakeFrontEndModule extends MakeModuleCommand
{
    /**
     * MakeFrontEndModule constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput();
        $this->components = new Factory($this->output);
    }

    /**
     * @var string
     */
    private $module_path;

    /**
     * @param  $module
     *
     * @throws FileNotFoundException
     */
    protected function create($module)
    {
        $this->files = new Filesystem();
        $this->module = $module;
        $this->module_path = base_path('resources/js/modules/'.lcfirst($this->module));

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
     * @return void
     *
     * @throws FileNotFoundException
     */
    private function createVueList()
    {
        $path = $this->module_path."/components/{$this->module}List.vue";

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
     * @return void
     *
     * @throws FileNotFoundException
     */
    private function createVueView()
    {
        $path = $this->module_path."/components/{$this->module}View.vue";

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
     * @return void
     *
     * @throws FileNotFoundException
     */
    private function createVueForm()
    {
        $path = $this->module_path."/components/{$this->module}Form.vue";

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
     * @return void
     *
     * @throws FileNotFoundException
     */
    private function createStore()
    {
        $moduleLC = lcfirst($this->module);
        $path = $this->module_path."/{$moduleLC}Store.js";

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
     * @return void
     *
     * @throws FileNotFoundException
     */
    private function createRoutes()
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
     * @return void
     *
     * @throws FileNotFoundException
     */
    private function createApi()
    {
        $moduleLC = lcfirst($this->module);
        $path = $this->module_path."/{$moduleLC}Api.js";

        if ($this->alreadyExists($path)) {
            $this->components->error('Api file already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/api.stub'));

            $this->createFileWithStub($stub, $path);

            $this->components->info('Api file created successfully.');
        }
    }
}
