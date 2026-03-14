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
        // Como a tabela pivot possui timestamps (created_at/updated_at), habilitamos
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
