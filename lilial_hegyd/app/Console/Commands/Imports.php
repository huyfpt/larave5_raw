<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImportService;

class Imports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:product {file_path}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ImportService $import)
    {
        set_time_limit(0);
        ini_set('max_execution_time', 0);
        $filename = $this->argument('file_path');
        if (!file_exists($filename) || is_dir($filename)) {
            $this->error(__(':file: Invalid import file path', ['file' => $filename]));
        }

        $result = $import->import($filename, $this);
        
        if ($result['alert-type'] == 'error') {
            $this->error($result['message']);
        } else {
            $this->line($result['message']);
        }
    }
}