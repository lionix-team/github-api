<?php

namespace App\Console\Commands;

use App\Contracts\GithubApi;
use App\Models\Organization;
use Illuminate\Console\Command;

class SyncRepos extends Command
{
    protected $signature = 'sync:repos';

    protected $description = 'Sync Git Repos';

    public function __construct(public GithubApi $api)
    {
        parent::__construct();
    }

    public function handle()
    {
        $organizations = Organization::all();

        foreach($organizations as $organization) {
            $this->withProgressBar($this->api->repos($organization->login), function ($apiRepo) use ($organization) {
                try {
                    $organization->repos()->updateOrCreate(['github_id' => $apiRepo['id']], $apiRepo);
                } catch (\Exception $exception) {
                    $this->warn("Repo syncing failed:" . $apiRepo['name']);
                }
            });
        }

        $this->newLine(1);
    }
}
