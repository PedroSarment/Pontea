<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    protected $fillable = [
        'created_by',
        'area_id',
        'level_id',
        'age_group_id',
        'title',
        'description',
        'media_path_1',
        'media_path_2',
        'media_path_3',
        'media_path_4',
        'has_multimedia_resources',
        'has_visual_instructions'
    ];

    public function ageGroup(): BelongsTo
    {
        return $this->belongsTo(AgeGroup::class, 'age_group_id');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'activity_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'activity_id');
    }
}
