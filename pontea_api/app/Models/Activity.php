<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];
}
