<?php namespace Hegyd\Permissions\Commands;

use Hegyd\Permissions\Support\HegydCommand;

class MigrationCommand extends HegydCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hegyd:permissions-migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creation of permissions tables migration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->laravel->view->addNamespace('hegyd-permissions', substr(__DIR__, 0, - 13) . 'views');

        $this->line('');
        $message = "A migration will be created in database/migrations directory";
        $this->comment($message);
        $this->line('');
        if ($this->confirm("Proceed with the migration creation? [Yes|no]", "Yes"))
        {
            $this->line('');
            $this->info("Creating migration...");
            if ($this->createMigration())
            {
                $this->info("Migration successfully created!");
            } else
            {
                $this->error(
                    "Couldn't create migration.\n Check the write permissions" .
                    " within the database/migrations directory."
                );
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
    protected function createMigration()
    {
        $filename = base_path("/database/migrations") . "/" . date('Y_m_d_His') . "_hegyd_permissions_setup_tables.php";

        return $this->generateFile($filename, 'generators.migration', []);
    }
}
