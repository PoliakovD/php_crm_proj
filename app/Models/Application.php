<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $title
 * @property string $description
 * @property integer $user_id
 * @property integer $status
 */
#[Fillable('title', 'description', 'user_id', 'status')]
class Application extends Model
{
    use HasFactory;

//    protected $fillable = [
//        'title', 'description', 'user_id', 'status'
//    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
