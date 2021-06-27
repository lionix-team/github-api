<?php

namespace App\Console\Commands;

use App\Contracts\GithubApi;
use App\Models\Repo;
use Illuminate\Console\Command;

class SyncAuthors extends Command
{
    protected $signature = 'sync:authors';

    protected $description = 'Sync Github Repo Authors';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(public GithubApi $api)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $repos = Repo::with('organization')->get();

        $repos->each(function (Repo $repo) {
            try {
                $apiAuthors = $this->api->authors($repo->organization->login, $repo->name);

                foreach ($apiAuthors as $apiAuthor) {
                    try {
                        $repo->authors()->updateOrCreate(['github_id' => $apiAuthor['id']], $apiAuthor);

                        $this->info("Author successfully synced:" . $apiAuthor['login']);
                    } catch (\Exception $exception) {
                        $this->warn("Author syncing failed:" . $apiAuthor['login']);

                        continue;
                    }
                }
            } catch (\Exception $exception) {
                $this->warn("Author syncing failed");
            }
        });

        return 0;
    }
}
