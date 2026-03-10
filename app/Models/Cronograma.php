<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'dia_semana',
        'periodo',
        'hora_inicio', 
        'hora_fim'
    ];

    protected $table = 'cronogramas';

    protected $casts = [
        'dia_semana' => 'array',
    ];

    // Um cronograma pertence a um curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Um cronograma pode ter muitas pré-inscrições
    public function preInscricoes()
    {
        return $this->hasMany(PreInscricao::class, 'cronograma_id');
    }
}
