<?php

namespace App\Console\Commands;

use Illuminate\Console\View\Components\Factory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Stringable;
use Symfony\Component\Console\Output\ConsoleOutput;

class MakeBackEndModule extends MakeModuleCommand
{
    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput;
        $this->components = new Factory($this->output);
    }

    private ?string $module_path = null;

    /**
     * @throws FileNotFoundException
     */
    protected function create(Stringable $module): void
    {
        $this->files = new Filesystem;
        $this->module = $module;
        $this->module_path = app_path('Modules/'.$this->module);

        $this->createActions();
        $this->createRoutes();
        $this->createRequest();
        $this->createResource();
    }

    /**
     * Create action classes for the module.
     *
     * @throws FileNotFoundException
     */
    private function createActions(): void
    {
        $actions = ['Index', 'Store', 'Show', 'Update', 'Destroy'];

        foreach ($actions as $action) {
            $path = $this->module_path.sprintf('/Actions/%s%s.php', $this->module, $action);

            if ($this->alreadyExists($path)) {
                $this->components->error(sprintf('%s%s already exists!', $this->module, $action));
            } else {
                $stub = $this->files->get(base_path('stubs/backEnd/action.'.strtolower($action).'.stub'));

                $this->createFileWithStub($stub, $path);

                $this->components->info(sprintf('%s%s created successfully.', $this->module, $action));
            }
        }
    }

    /**
     * Create a Routes for the module.
     *
     * @throws FileNotFoundException
     */
    private function createRoutes(): void
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
    private function createRequest(): void
    {
        $path = $this->module_path.sprintf('/Requests/%sRequest.php', $this->module);

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
    private function createResource(): void
    {
        $path = $this->module_path.sprintf('/Resources/%sResource.php', $this->module);

        if ($this->alreadyExists($path)) {
            $this->components->error('Resource already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/resource.stub'));

            $this->createFileWithStub($stub, $path);

            $this->components->info('Resource created successfully.');
        }
    }
}
