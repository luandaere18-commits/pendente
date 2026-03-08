<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreInscricao extends Model
{
    use HasFactory;


    protected $table = 'pre_inscricoes'; // Especificando nome da tabela do banco de dados

    protected $fillable = [
        'curso_id',
        'centro_id',
        'cronograma_id',
        'nome_completo',
        'contactos',
        'email',
        'status',
        'observacoes'
    ];

     // Converte automaticamente JSON para array e vice-versa
    protected $casts = [
        'contactos' => 'array',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }

    public function cronograma()
    {
        return $this->belongsTo(Cronograma::class);
    }
}
