<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formador extends Model
{
    use HasFactory;

    protected $table = 'formadores'; // Definir o nome da tabela

    protected $fillable = [
        'nome',
        'email',
        'contactos',
        'especialidade',
        'bio',
        'foto_url'
    ];

    // Converte automaticamente JSON para array e vice-versa
    protected $casts = [
        'contactos' => 'array',
    ];

    // N:N com centros
    public function centros()
    {
        return $this->belongsToMany(Centro::class, 'centro_formador')->withTimestamps();
    }

    // 1:N com turmas (um formador leciona múltiplas turmas)
    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }

    // N:N com cursos via turmas
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'turmas', 'formador_id', 'curso_id')
            ->withTimestamps()
            ->distinct();
    }
}
