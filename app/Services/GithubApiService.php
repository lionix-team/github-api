<?php

namespace App\Services;

use App\Contracts\GithubApi;
use GrahamCampbell\GitHub\Facades\GitHub;

class GithubApiService implements GithubApi
{
    public function organizations()
    {
        return GitHub::me()->organizations();
    }

    public function repos(string $organization)
    {
        return GitHub::repo()->org($organization);
    }

    public function authors(string $organization, string $repo)
    {
        return GitHub::repo()->collaborators()->all($organization, $repo);
    }

    public function commits(string $organization, string $repo, array $params = [])
    {
        return GitHub::repo()->commits()->all($organization, $repo, array_merge([
            'per_page' => 100,
            'page' => 1
        ], $params));
    }
}
