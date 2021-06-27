<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommitResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sha' => $this->sha,
            'date' => $this->date,
            'author_data' => $this->author_data,
            'message' => $this->message,
            'tree' => $this->tree,
            'url' => $this->url,
            'created_at' => $this->created_at->toDateTimeString(),
            'repo' => new RepoResource($this->whenLoaded('repo')),
            'author' => new AuthorResource($this->whenLoaded('author')),
        ];
    }
}
