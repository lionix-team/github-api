<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorCommitsRequest;
use App\Http\Resources\CommitResource;
use App\Models\Author;
use App\Models\Repo;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class CommitsController extends Controller
{
    public function index(Repo $repo)
    {
        $period = CarbonPeriod::between(now()->subWeek(), now());
        $repo = $repo->load('authors.commits');

        return $repo->authors->map(function (Author $author) use ($period) {
            $commits = $author->commits->groupBy(function ($commit) {
                return $commit->date->format('Y-m-d');
            })->toArray();

            $authorData = [
                'author' => [
                    'id' => $author->id,
                    'login' => $author->login
                ]
            ];

            foreach ($period as $date) {
                $dateFormatted = $date->format('Y-m-d');

                $authorData['dates'][] = [
                    'date' => $dateFormatted,
                    'commits' => isset($commits[$dateFormatted]) ? count($commits[$dateFormatted]) : 0
                ];
            }

            return $authorData;
        });
    }

    public function commits(Repo $repo, Author $author, AuthorCommitsRequest $request)
    {
        $commits = $author->commits()
            ->with('repo', 'author')
            ->whereDate('date', $request->date)
            ->get();

        return CommitResource::collection($commits);
    }
}
