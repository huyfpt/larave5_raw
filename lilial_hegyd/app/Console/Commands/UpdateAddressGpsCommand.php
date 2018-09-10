<?php namespace App\Console\Commands;

use App\Models\Common\Address;
use Illuminate\Console\Command;

class UpdateAddressGpsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:update-gps';

    /**
     *
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add altitude and longitude to the Addresses table';

    /**
     *
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
        $addresses = Address::all();
        foreach ($addresses as $address) {
            if ($address->latitude == '' and $address->longitude == '') {
                $this->getLatLng($address);
            }
        }
    }

    protected function getLatLng(Address $address)
    {
        try {
            $uri = str_replace(' ', '+', implode('+', [$address->zip, $address->address, $address->city]));
            if($address->country){
                $uri .= '+'.$address->country->iso_alpha_2;
            }
            $result = json_decode(file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $uri));
            d($result);
            if (!empty($result->results[0]->geometry)) {
                $address->update(['latitude' => $result->results[0]->geometry->location->lat,
                    'longitude' => $result->results[0]->geometry->location->lng,]);
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}