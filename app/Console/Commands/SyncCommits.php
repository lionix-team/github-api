<?php

namespace App\Console\Commands;

use App\Contracts\GithubApi;
use App\Models\Author;
use App\Models\Commit;
use App\Models\Repo;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SyncCommits extends Command
{
    protected $signature = 'sync:commits';

    protected $description = 'Sync Commits';

    public function __construct(public GithubApi $api)
    {
        parent::__construct();
    }

    public function handle()
    {
        $repo = Repo::with('organization')->get();

        $since = now()->subDay()->startOfDay()->toIso8601String();
        $until = now()->subDay()->endOfDay()->toIso8601String();

        $repo->each(function (Repo $repo) use ($since, $until) {
            try {
                $apiCommits = $this->api->commits($repo->organization->login, $repo->name, [
                    'since' => $since,
                    'until' => $until,
                ]);

                foreach ($apiCommits as $apiCommit) {
                    try {
                        $commit = Commit::firstOrNew(['sha' => $apiCommit['sha']], [
                            'author_data' => $apiCommit['commit']['author'],
                            'tree' => $apiCommit['commit']['tree'],
                            'message' => Str::limit($apiCommit['commit']['message'], 200),
                            'url' => $apiCommit['commit']['url'],
                            'date' => $apiCommit['commit']['author']['date'],
                        ]);
                        $commit->repo()->associate($repo);

                        $author = Author::firstOrCreate(['github_id' => $apiCommit['author']['id']], $apiCommit['author']);
                        $author->commits()->save($commit);

                        $this->info("Commit successfully synced: " . $apiCommit['sha']);
                    } catch (\Exception $exception) {

                        $this->warn("Commit sync failed: " . $apiCommit['sha']);

                        continue;
                    }
                }
            } catch (\Exception $exception) {
                $this->warn("Commit sync failed: " . $exception->getMessage());
            }
        });

        return 0;
    }
}
