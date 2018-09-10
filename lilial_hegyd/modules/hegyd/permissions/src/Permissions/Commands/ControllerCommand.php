<?php namespace Hegyd\Permissions\Commands;

use Hegyd\Permissions\Support\HegydCommand;
use Illuminate\Support\Facades\File;

class ControllerCommand extends HegydCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hegyd:permissions-controller
    {--name=App\Http\Controllers\Backend\ACL\PermissionsController : Le chemin complet de la classe PermissionsController}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creation of permissions controller';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('');
        if ($this->confirm("Proceed with the controller creation? [Yes|no]", "Yes"))
        {
            $this->line('');
            $this->info("Creating controller...");
            if ($this->createController($this->option('name')))
            {
                $this->info("Controller successfully created!");
            } else
            {
                $this->error("Couldn't create controller.");
            }
            $this->line('');

        }
    }

    /**
     * Create the migration.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function createController($name)
    {

        $class = $this->getResourceName($name);
        $namespace = $this->getNamespace($name);

        $viewVars = compact(
            'class',
            'namespace'
        );

        $filename = $this->getFilenameFromClass($namespace, $class);

        return $this->generateFile($filename, 'generators.controller', $viewVars);
    }

    /**
     * Returns the name of the controller class that will handle a
     * resource with the given name.
     *
     * @param string $name Resource name.
     *
     * @return string Controller class name.
     */
    protected function getResourceName($name, $default = 'PermissionsController')
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