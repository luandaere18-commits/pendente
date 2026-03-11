<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'duracao_semanas',
        'dia_semana',
        'periodo',
        'hora_inicio', 
        'hora_fim',
        'data_arranque'
    ];

    protected $table = 'turmas';

    protected $casts = [
        'dia_semana' => 'array',
    ];

    // Uma turma pertence a um curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Uma turma pode ter muitas pré-inscrições
    public function preInscricoes()
    {
        return $this->hasMany(PreInscricao::class, 'turma_id');
    }
}
