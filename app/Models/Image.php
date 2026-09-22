<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $path
 * @property string|null $original_name
 * @property bool $is_public
 * @property-read string $url
 * @property-read \App\Models\User $user
 */
class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'path', 'original_name', 'is_public',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): string
    {
        return url('storage/' . $this->path);
    }
}
