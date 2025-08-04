<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Form $form) {
            if ($form->isForceDeleting()) {
                $form->questions()->withTrashed()->forceDelete();
            } else {
                $form->questions()->delete(); // soft delete das perguntas
            }
        });

        static::restoring(function (Form $form) {
            $form->questions()->withTrashed()->restore();
        });
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function responses()
    {
        return $this->hasMany(FormResponse::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }
}
