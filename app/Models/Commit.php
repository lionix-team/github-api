<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commit extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_data',
        'message',
        'tree',
        'url',
        'sha',
        'date',
    ];

    protected $casts = [
        'author_data' => 'json',
        'tree' => 'json',
        'date' => 'datetime'
    ];

    public function repo(): BelongsTo
    {
        return $this->belongsTo(Repo::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
