<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'github_id' => $this->github_id,
            'login' => $this->login,
            'node_id' => $this->node_id,
            'avatar_url' => $this->avatar_url,
            'url' => $this->url,
        ];
    }
}
