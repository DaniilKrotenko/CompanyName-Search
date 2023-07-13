<?php

namespace App\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ExternalApiClient
{
    public $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:3000',
            'headers' => [
                'X-Client' => '237cd6a8-5a0e-4ff0-b7e2-0bf34675d058',
            ],
        ]);
    }

    public function getUsers($page)
    {
        try {
            $response = $this->client->get('/users', [
                'query' => [
                    'page' => $page,
                ],
            ]);

            $responseData = json_decode($response->getBody(), true) ?? [];
            return $responseData['users'] ?? [];
        } catch (GuzzleException $e) {
            return [];
        }
    }

    public function getCompanies($page)
    {
        try {
            $response = $this->client->get('/companies', [
                'query' => [
                    'page' => $page,
                ],
            ]);

            $responseData = json_decode($response->getBody(), true) ?? [];
            $companiesData = $responseData['compaines'] ?? [];

            $companies = array_map(function ($companyData) {
                return [
                    'Id' => $companyData['Id'],
                    'Name' => $companyData['Name'],
                    'Address' => $companyData['Address'],
                ];
            }, $companiesData);

            return $companies;
        } catch (GuzzleException $e) {
            return [];
        }
    }

    public function getCompanyPositions($companyId)
    {
        try {
            $response = $this->client->get('/company/' . $companyId);

            $responseData = json_decode($response->getBody(), true) ?? [];
            $positionsData = $responseData['positions'] ?? [];
            $positions = array_map(function ($positionData) {
                return [
                    'company_id' => $positionData['CompanyId'],
                    'user_id' => $positionData['UserId'],
                    'position' => $positionData['Position'],
                ];
            }, $positionsData);

            return $positions;
        } catch (GuzzleException $e) {
            return [];
        }
    }
}
