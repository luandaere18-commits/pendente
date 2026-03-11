<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;



    protected $fillable = [
        'nome',
        'descricao',
        'programa',
        'area',
        'modalidade',
        'imagem_url',
        'ativo'
    ];

    // N:N com centros (caso o curso seja ministrado em vários centros)
    public function centros()
    {
        return $this->belongsToMany(Centro::class, 'centro_curso')
        ->withPivot(['preco']);
    }

    // Um curso tem muitas turmas
    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }

    // N:N com formadores
    public function formadores()
    {
        return $this->belongsToMany(Formador::class, 'curso_formador')->withTimestamps();
    }


    // Um curso pode ter muitas pré-inscrições
    public function preInscricoes()
    {
        return $this->hasMany(PreInscricao::class);
    }
}
