<?php namespace Hegyd\Plans\Commands;

use Hegyd\Plans\Support\HegydCommand;
use Illuminate\Support\Facades\File;

/**
 * Class ControllerCommand
 * @package Hegyd\Plans\Commands
 */
class ControllerCommand extends HegydCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hegyd:plans-controllers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creation of plans controller';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('');
        if ($this->confirm("Proceed with the controllers creation? [Yes|no]", "Yes"))
        {
            $this->line('');
            $this->info("Creating controller...");
            if ($this->createControllers())
            {
                $this->info("Controller successfully created!");
            } else
            {
                $this->error("Couldn't create controller.");
            }
            $this->line('');

        }
    }

    public function createControllers()
    {
        $base_namespace = 'App\\Http\\Controllers\\';

        $backend_namespace = config('hegyd-plans.controllers.backend_namespace');
        $frontend_namespace = config('hegyd-plans.controllers.frontend_namespace');

        $this->createController($base_namespace . $backend_namespace . '\\' . 'PlansController', 'generators.controllers.backend.plans');
        $this->createController($base_namespace . $backend_namespace . '\\' . 'plansCategoriesController', 'generators.controllers.backend.plans_categories');

        $this->createController($base_namespace . $frontend_namespace . '\\' . 'PlansController', 'generators.controllers.frontend.plans');
        $this->createController($base_namespace . $frontend_namespace . '\\' . 'plansCategoriesController', 'generators.controllers.frontend.plans_categories');

        return true;
    }

    /**
     * Create the migration.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function createController($name, $template_path)
    {

        $class = $this->getResourceName($name);
        $namespace = $this->getNamespace($name);

        $viewVars = compact(
            'class',
            'namespace'
        );

        $filename = $this->getFilenameFromClass($namespace, $class);

        return $this->generateFile($filename, $template_path, $viewVars);
    }

    /**
     * Returns the name of the controller class that will handle a
     * resource with the given name.
     *
     * @param string $name Resource name.
     *
     * @return string Controller class name.
     */
    protected function getResourceName($name, $default = 'PlansController')
    {
        $name = parent::getResourceName($name, $default);

        if (substr(strtolower($name), - 10) == 'controller')
        {
            $name = substr($name, 0, - 10) . 'Controller';
        } else
        {
            $name .= 'Controller';
        }

        return $name;
    }

}