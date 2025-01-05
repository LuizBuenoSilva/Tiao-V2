<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'title',
        'youtube_link',
        'plays',
        'is_approved'
    ];

    // Conversão de tipos
    protected $casts = [
        'is_approved' => 'boolean',
        'plays' => 'integer',
    ];

    // Relacionamento com sugestões (se necessário)
    public function suggestions()
    {
        return $this->hasMany(Suggestion::class);
    }
}
