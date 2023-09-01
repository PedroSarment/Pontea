<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgeGroup extends Model
{
    use HasFactory;

    protected $table = 'age_groups';

    protected $fillable = [
        'title',
    ];

    // Defina a relação "um para muitos" com o modelo Activity
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'age_group_id');
    }
}
