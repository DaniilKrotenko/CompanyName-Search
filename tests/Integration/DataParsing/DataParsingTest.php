<?php

namespace Tests\Integration\DataParsing;

use App\Clients\ExternalApiClient;
use App\Console\Commands\ParseDataCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DataParsingTest extends TestCase
{
    use DatabaseTransactions;

    public function testParseUsers()
    {
        new ParseDataCommand(new ExternalApiClient());

        $this->artisan('data:parse');

        $this->assertDatabaseHas('users', [
            'id' => '5a963e9b-ac97-4bd3-94af-64513f4ee3a0',
            'last_name' => 'George',
            'first_name' => 'Fellas',
            'email' => 'g.fellas@example.com',
        ]);
    }

    public function testParseCompanies()
    {
        new ParseDataCommand(new ExternalApiClient());

        $this->artisan('data:parse');

        $this->assertDatabaseHas('companies', [
            'id' => '07945378-68fa-49f3-b5f4-56fcf93f26a0',
            'name' => 'TM manufacturer',
            'address' => '2436 Naples Avenue, Panama City FL 32405',
        ]);
    }

    public function testParseCompanyPositions()
    {
        $command = new ParseDataCommand(new ExternalApiClient());

        $command->parseCompanyPositions('6e285aea-6487-4771-8062-f782e43792bc');

        $this->assertDatabaseHas('positions', [
            'company_id' => '6e285aea-6487-4771-8062-f782e43792bc',
            'user_id' => '5a963e9b-ac97-4bd3-94af-64513f4ee3a0',
            'position' => 'Engineer',
        ]);
    }
}

