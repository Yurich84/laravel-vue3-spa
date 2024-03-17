<?php

namespace App\Console\Commands;

use Illuminate\Console\View\Components\Factory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Output\ConsoleOutput;

class MakeBackEndModule extends MakeModuleCommand
{
    /**
     * MakeBackEndModule constructor.
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
        $this->module_path = app_path('Modules/'.$this->module);

        $this->createController();
        $this->createRoutes();
        $this->createRequest();
        $this->createResource();
    }

    /**
     * Create a controller for the module.
     *
     * @return void
     *
     * @throws FileNotFoundException
     */
    private function createController()
    {
        $path = $this->module_path."/Controllers/{$this->module}Controller.php";

        if ($this->alreadyExists($path)) {
            $this->components->error('Controller already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/controller.api.stub'));

            $this->createFileWithStub($stub, $path);

            $this->components->info('Controller created successfully.');
        }
    }

    /**
     * Create a Routes for the module.
     *
     * @throws FileNotFoundException
     */
    private function createRoutes()
    {
        $path = $this->module_path.'/routes_api.php';

        if ($this->alreadyExists($path)) {
            $this->components->error('Routes already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/routes.api.stub'));

            $this->createFileWithStub($stub, $path);

            $this->components->info('Routes created successfully.');
        }
    }

    /**
     * Create a Request for the module.
     *
     * @throws FileNotFoundException
     */
    private function createRequest()
    {
        $path = $this->module_path."/Requests/{$this->module}Request.php";

        if ($this->alreadyExists($path)) {
            $this->components->error('Request already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/request.stub'));

            $this->createFileWithStub($stub, $path);

            $this->components->info('Request created successfully.');
        }
    }

    /**
     * Create a Resource for the module.
     *
     * @throws FileNotFoundException
     */
    private function createResource()
    {
        $path = $this->module_path."/Resources/{$this->module}Resource.php";

        if ($this->alreadyExists($path)) {
            $this->components->error('Resource already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/resource.stub'));

            $this->createFileWithStub($stub, $path);

            $this->components->info('Resource created successfully.');
        }
    }
}
