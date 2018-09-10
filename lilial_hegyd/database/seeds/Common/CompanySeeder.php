<?php namespace Database\Seeds\Common;

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $http_host = parse_url(env("APP_URL"));
        $sub_domain = str_replace(env("APP_DOMAIN"), "", $http_host["host"]);

        $companyData = [
            "id"            => 1,
            "name"          => "Default Company",
            "subdomain"     => $sub_domain
        ];

        $company = \App\Models\Common\Company::find($companyData['id']);
        if ( ! $company)
        {
            \App\Models\Common\Company::create($companyData);
        } else
        {
            $company->update($companyData);
        }
    }
}
