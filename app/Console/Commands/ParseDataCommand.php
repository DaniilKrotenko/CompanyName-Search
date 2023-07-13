<?php

namespace App\Console\Commands;

use App\Clients\ExternalApiClient;
use App\Models\Company;
use App\Models\Position;
use App\Models\User;
use Illuminate\Console\Command;

class ParseDataCommand extends Command
{
    protected $signature = 'data:parse {pages=1 : Number of pages to parse}';
    protected $description = 'Parse data from the external API and store it in the database';

    public $externalApiClient;

    public function __construct(ExternalApiClient $externalApiClient)
    {
        parent::__construct();
        $this->externalApiClient = $externalApiClient;
    }

    public function handle()
    {
        $this->parseUsers();
        $this->parseCompanies();

        $this->info('Data parsing completed successfully.');
        return 0;
    }

    protected function parseUsers()
    {
        $page = 1;
        $users = [];

        while (true) {
            $newUsers = $this->externalApiClient->getUsers($page);
            if (empty($newUsers)) {
                break;
            }
            $users = array_merge($users, $newUsers);
            $page++;
        }

        foreach ($users as $userData) {
            User::updateOrCreate(
                [
                    'id' => $userData['Id']
                ],
                [
                    'last_name' => $userData['LastName'],
                    'first_name' => $userData['FirstName'],
                    'email' => $userData['Email'],
                ]
            );
        }
    }

    protected function parseCompanies()
    {
        $page = 1;
        $companies = [];

        while (true) {
            $newCompanies = $this->externalApiClient->getCompanies($page);
            if (empty($newCompanies)) {
                break;
            }
            $companies = array_merge($companies, $newCompanies);
            $page++;
        }

        foreach ($companies as $companyData) {
            $this->updateOrCreateCompany($companyData);
            $this->parseCompanyPositions($companyData['Id']);
        }
    }

    protected function updateOrCreateCompany($companyData)
    {
        Company::updateOrCreate(
            [
                'id' => $companyData['Id']
            ],
            [
                'name' => $companyData['Name'],
                'address' => $companyData['Address'],
            ]
        );
    }

    public  function parseCompanyPositions($companyId)
    {
        $positions = $this->externalApiClient->getCompanyPositions($companyId);

        foreach ($positions as $positionData) {
            if (User::where('id', $positionData['user_id'])->exists()) {
                Position::updateOrCreate(
                    [
                        'company_id' => $positionData['company_id'],
                        'user_id' => $positionData['user_id'],
                    ],
                    [
                        'position' => $positionData['position'],
                    ]
                );
            }
        }
    }
}
