<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'github_id' => $this->github_id,
            'node_id' => $this->node_id,
            'name' => $this->name,
            'full_name' => $this->full_name,
            'url' => $this->url,
            'description' => $this->description,
        ];
    }
}
