<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'bought_by',
        'activity_id',
        'bought_at'
    ];

}
