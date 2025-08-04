<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['form_id', 'uuid', 'text', 'type', 'is_required', 'order'];

    protected $casts = [
        'is_required' => 'boolean',
        'order' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function (Question $q) {
            if (empty($q->uuid)) {
                $q->uuid = (string) Str::uuid();
            }
        });

        static::deleting(function (Question $question) {
            if ($question->isForceDeleting()) {
                $question->alternatives()->withTrashed()->forceDelete();
            } else {
                $question->alternatives()->delete(); // soft delete
            }
        });

        static::restoring(function (Question $question) {
            $question->alternatives()->withTrashed()->restore();
        });
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function alternatives()
    {
        return $this->hasMany(Alternative::class)->orderBy('order');
    }
}
