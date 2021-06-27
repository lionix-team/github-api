<?php


namespace App\Contracts;


interface GithubApi
{
    public function organizations();

    public function repos(string $organization);

    public function authors(string $organization, string $repo);

    public function commits(string $organization, string $repo, array $params);
}
