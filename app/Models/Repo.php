<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Repo extends Model
{
    use HasFactory;

    protected $fillable = [
        'github_id',
        'node_id',
        'name',
        'full_name',
        'url',
        'description',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function authors(): HasMany
    {
        return $this->hasMany(Author::class);
    }

    public function commits(): HasMany
    {
        return $this->hasMany(Commit::class);
    }
}
