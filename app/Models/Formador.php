<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formador extends Model
{
    use HasFactory;

    protected $table = 'formadores';

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

    /**
     * ACCESSOR: Normalizar contactos para exibição
     * Garante que sempre retorne um array de strings
     * Lida com ambos os formatos: strings simples e objetos com 'valor'
     */
    public function getContactosAttribute($value)
    {
        $contactos = json_decode($value, true) ?? [];
        
        if (empty($contactos)) {
            return [];
        }
        
        // Verificar o formato do primeiro item
        $primeiroItem = reset($contactos);
        
        // Se for array de objetos com 'valor', extrair apenas os valores
        if (is_array($primeiroItem) && isset($primeiroItem['valor'])) {
            $valores = array_column($contactos, 'valor');
            // Filtrar valores vazios
            return array_filter($valores, function($v) {
                return !empty(trim($v));
            });
        }
        
        // Se for array de strings, filtrar e retornar
        if (is_string($primeiroItem)) {
            return array_filter($contactos, function($v) {
                return !empty(trim($v));
            });
        }
        
        // Caso inesperado, retornar array vazio
        return [];
    }

    /**
     * MUTATOR: Garantir formato consistente ao salvar
     * Converte qualquer format para array de strings
     */
    public function setContactosAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        
        if (!is_array($value)) {
            $value = [];
        }
        
        // Normalizar para array de strings
        $resultado = [];
        
        foreach ($value as $contacto) {
            $telefone = null;
            
            // Se for string, usar direto
            if (is_string($contacto)) {
                $telefone = trim($contacto);
            }
            // Se for array com 'valor', extrair
            elseif (is_array($contacto) && isset($contacto['valor'])) {
                $telefone = trim($contacto['valor']);
            }
            
            // Adicionar se não vazio
            if (!empty($telefone)) {
                $resultado[] = $telefone;
            }
        }
        
        $this->attributes['contactos'] = json_encode($resultado);
    }

    /**
     * Relacionamento com Centros (N:N)
     */
    public function centros()
    {
        return $this->belongsToMany(Centro::class, 'centro_formador')->withTimestamps();
    }

    /**
     * Relacionamento com Turmas (1:N)
     */
    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }

    /**
     * Relacionamento com Cursos (N:N via Turmas)
     */
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'turmas', 'formador_id', 'curso_id')
            ->withTimestamps()
            ->distinct();
    }

    /**
     * ACESSOR: Contagem de cursos
     * Uso: $formador->cursos_count
     */
    public function getCursosCountAttribute()
    {
        if ($this->relationLoaded('turmas')) {
            return $this->turmas->pluck('curso_id')->unique()->count();
        }
        
        return Curso::whereHas('turmas', function($q) {
            $q->where('formador_id', $this->id);
        })->count();
    }

    /**
     * ACESSOR: Contactos como string para exibição
     * Uso: $formador->contactos_string
     */
    public function getContactosStringAttribute()
    {
        $contactos = $this->contactos ?? [];
        return !empty($contactos) ? implode(', ', $contactos) : '—';
    }

    /**
     * ACESSOR: Contagem de contactos
     * Uso: $formador->contactos_count
     */
    public function getContactosCountAttribute()
    {
        return count($this->contactos ?? []);
    }
}


