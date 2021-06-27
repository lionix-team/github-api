<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncGithub extends Command
{
    protected $signature = 'sync:github';

    protected $description = 'Sync Github Organizations, Repos, Authors for Given Access Token User';

    public function __construct()
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
        $this->call('sync:organizations');
        $this->call('sync:repos');
        $this->call('sync:authors');

        return 0;
    }
}
