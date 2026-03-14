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

    /**
     * Relações do Modelo Curso:
     * 
     * ✅ centros() - Um curso pode ser lecionado em vários centros (N:N)
     * ✅ turmas() - Um curso tem várias turmas (1:N)
     * ❌ formadores() - NÃO EXISTE - os formadores são associados às TURMAS, não aos cursos
     * 
     * @see Turma::formador() - formadores são associados ao nível de turma
     */

    // N:N com centros (caso o curso seja ministrado em vários centros)
    public function centros()
    {
        // o withTimestamps() para que o Laravel atualize esses campos automaticamente
        return $this->belongsToMany(Centro::class, 'centro_curso')
            ->withPivot(['preco'])
            ->withTimestamps();
    }

    // Um curso tem muitas turmas
    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }
}
