<?php
namespace Hegyd\Faqs\Commands;

use Hegyd\Faqs\Support\HegydCommand;

/**
 * Class MigrationCommand
 * @package Hegyd\Faqs\Commands
 */
class MigrationCommand extends HegydCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hegyd:faqs-migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creation of faqs tables migration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->laravel->view->addNamespace('hegyd-faqs', substr(__DIR__, 0, - 13) . 'views');

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
                    "Couldn't create migration.\n Check the write faqs" .
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
        $filename = base_path("/database/migrations") . "/" . date('Y_m_d_His') . "_hegyd_faqs_tables.php";

        $faqsTable = config('hegyd-faqs.tables.faqs', 'faqs');
        $faqsCategoryTable = config('hegyd-faqs.tables.faqs_category', 'faqs_categories');

        return $this->generateFile($filename, 'generators.migration', compact('faqsTable',
            'faqsCategoryTable'));
    }
}
