<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Download extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:download {url_file_path}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download import.zip from url';
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
    public function handle()
    {
        set_time_limit(0);
        ini_set('max_execution_time', 0);

        $filename = $this->argument('url_file_path');
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $filename);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result) {

            $realPath = Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
            $output = $realPath . 'public/import.zip';
            if (file_exists($output)) {
                unlink($output);
            }

            $fp = fopen($output, 'w');
            fwrite($fp, $result);
            fclose($fp);
        }
    }
}