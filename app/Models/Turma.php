<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'formador_id',
        'duracao_semanas',
        'dia_semana',
        'periodo',
        'hora_inicio', 
        'hora_fim',
        'data_arranque',
        'status',
        'vagas_totais',
        'vagas_preenchidas',
        'publicado'
    ];

    protected $table = 'turmas';

    protected $casts = [
        'dia_semana' => 'array',
        'publicado' => 'boolean',
    ];

    // Accessor para calcular vagas disponíveis
    public function getVagasDisponiveisAttribute()
    {
        if (!$this->vagas_totais) return null;
        return $this->vagas_totais - $this->vagas_preenchidas;
    }

    // Uma turma pertence a um curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Uma turma pertence a um formador
    public function formador()
    {
        return $this->belongsTo(Formador::class);
    }

    // Uma turma pode ter muitas pré-inscrições
    public function preInscricoes()
    {
        return $this->hasMany(PreInscricao::class, 'turma_id');
    }
}
