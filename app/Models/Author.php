<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'github_id',
        'login',
        'node_id',
        'avatar_url',
        'url',
    ];

    public function repo(): BelongsTo
    {
        return $this->belongsTo(Repo::class);
    }

    public function commits(): HasMany
    {
        return $this->hasMany(Commit::class);
    }
}
