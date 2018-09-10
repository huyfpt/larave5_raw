<?php namespace Hegyd\Seos\Repositories\Eloquent;

use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryBuilder;
use Hegyd\Seos\Repositories\Contracts\SeoUrlRedirectsRepositoryInterface;
use Illuminate\Support\Facades\App;

/**
 * Class SeosRepository
 * @package Hegyd\Seos\Repositories\Eloquent
 */
class SeoUrlRedirectsRepository extends Repository implements SeoUrlRedirectsRepositoryInterface
{

    public function model()
    {
        return config('hegyd-seos.models.seo_url_redirects');
    }

    /**
     * Get active seos query
     * @return QueryBuilder
     */
    private function _getActive()
    {
        $class = $this->model();
        $urls = $class::where('active', true)->get();

        return $urls;
    }

    public function updateHtaccess()
    {
        $file = public_path('.htaccess');

        $fread = fopen($file, 'r');

        $write = true;
        $return = '';

        $redirecttion = $this->buildListRedirection();

        while (($line = fgets($fread)) !== false) {
            $check_line = str_replace("\n", '', trim($line));
            if ($check_line == "#start_redirection") {
                $return .= "    #start_redirection\n";

                $return .= "\n";
                $return .= $redirecttion;
                $return .= "\n";

                $write = false;
            }
            if ($check_line == "#end_redirection") {
                $write = true;
            }

            // add origin text
            if ($write) {
                $return .= $line;
            }
        }
        
        fclose($fread);
        
        // write file
        $fwrite = fopen($file, 'w');
        fwrite($fwrite, $return);
        fclose($fwrite);
    }

    protected function buildListRedirection()
    {
        $data = $this->_getActive();

        if (empty($data)) {
            return '';
        }

        $list = '';
        foreach ($data as $item) {
            $list .= '#' . 'Redirect 301 ' . $item->old_url . ' ' . $item->new_url . PHP_EOL;
        }

        return $list;
    }

}