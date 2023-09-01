<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use HasFactory;

    protected $table = 'levels';

    protected $fillable = [
        'title',
    ];

    // Defina a relação "um para muitos" com o modelo Activity
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'level_id');
    }
}
