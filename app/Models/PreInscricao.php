<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreInscricao extends Model
{
    use HasFactory;


    protected $table = 'pre_inscricoes'; // Especificando nome da tabela do banco de dados

    protected $fillable = [
        'turma_id',
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

    /**
     * Uma pré-inscrição pertence a uma turma
     */
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}
