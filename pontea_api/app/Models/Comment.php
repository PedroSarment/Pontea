<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'created_by',
        'activity_id',
        'text',
        'note',
    ];

     /**
     * Define o relacionamento com o usuário que criou o comentário.
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Define o relacionamento com a atividade associada ao comentário.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
