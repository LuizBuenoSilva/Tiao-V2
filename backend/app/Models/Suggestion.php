<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'youtube_link',
        'status',
        'rejection_reason'
    ];

    // Relacionamento com usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com música (se necessário)
    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    // Método para verificar se a sugestão está pendente
    public function isPending()
    {
        return $this->status === 'pending';
    }

    // Método para verificar se a sugestão foi aprovada
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    // Método para verificar se a sugestão foi rejeitada
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
