<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Alternative extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['question_id', 'uuid', 'text', 'is_correct', 'order'];

    protected $casts = [
        'is_correct' => 'boolean',
        'order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Alternative $a) {
            if (empty($a->uuid)) {
                $a->uuid = (string) Str::uuid();
            }
        });
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function isCorrect(): bool
    {
        return (bool) $this->is_correct;
    }
}
