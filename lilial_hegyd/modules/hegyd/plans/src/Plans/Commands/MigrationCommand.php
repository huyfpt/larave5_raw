<?php namespace Hegyd\Plans\Commands;

use Hegyd\Plans\Support\HegydCommand;

/**
 * Class MigrationCommand
 * @package Hegyd\Plans\Commands
 */
class MigrationCommand extends HegydCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hegyd:plans-migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creation of plans tables migration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->laravel->view->addNamespace('hegyd-plans', substr(__DIR__, 0, - 13) . 'views');

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
                    "Couldn't create migration.\n Check the write plans" .
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
        $filename = base_path("/database/migrations") . "/" . date('Y_m_d_His') . "_hegyd_plans_setup_tables.php";

        $plansTable = config('hegyd-plans.tables.plans', 'plans');
        $plansCategoryTable = config('hegyd-plans.tables.plans_category', 'plans_categories');

        return $this->generateFile($filename, 'generators.migration', compact('plansTable',
            'plansCategoryTable'));
    }
}
