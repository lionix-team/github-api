<?php

namespace App\Console\Commands;

use App\Contracts\GithubApi;
use App\Models\Organization;
use Illuminate\Console\Command;

class SyncOrganizations extends Command
{
    protected $signature = 'sync:organizations';

    protected $description = 'Sync Github Organizations';

    public function __construct(public GithubApi $api)
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->withProgressBar($this->api->organizations(), function ($apiOrganization) {
            try {
                Organization::updateOrCreate(['github_id' => $apiOrganization['id']], $apiOrganization);
            } catch (\Exception $exception) {
                $this->warn("Organization syncing failed:" . $apiOrganization['login']);
            }
        });

        $this->newLine(1);
    }
}
