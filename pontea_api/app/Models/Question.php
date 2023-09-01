<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'created_by',
        'activity_id',
        'question',
        'response',
        'likes',
    ];

    /**
     * Define o relacionamento com o usuário que criou a pergunta.
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Define o relacionamento com a atividade associada à pergunta.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
