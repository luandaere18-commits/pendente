<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'itens';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'imagem',
        'categoria_id',
        'tipo', // 'produto' ou 'servico'
        'destaque',
        'ordem',
        'ativo'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'ativo' => 'boolean',
        'destaque' => 'boolean',
        'ordem' => 'integer',
    ];

    protected $appends = [
        'preco_formatado',
        'imagem_url'
    ];

    /**
     * Get the categoria that owns this item
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Get the grupo through categoria
     */
    public function grupo()
    {
        return $this->hasOneThrough(Grupo::class, Categoria::class, 'id', 'id', 'categoria_id', 'grupo_id');
    }

    /**
     * Scope: Get only active itens
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Scope: Get only highlighted itens
     */
    public function scopeDestacados($query)
    {
        return $query->where('destaque', true);
    }

    /**
     * Scope: Filter by categoria
     */
    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    /**
     * Scope: Filter by tipo (produto ou servico)
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope: Filter by grupo
     */
    public function scopePorGrupo($query, $grupoId)
    {
        return $this->whereHas('categoria', function ($q) use ($grupoId) {
            $q->where('grupo_id', $grupoId);
        });
    }

    /**
     * Scope: Order by ordem ascending
     */
    public function scopeOrdenado($query)
    {
        return $query->orderBy('ordem');
    }

    /**
     * Format preço as "Sob Consulta" if NULL or 0
     */
    public function getPrecoFormatadoAttribute()
    {
        if ($this->preco == 0 || is_null($this->preco)) {
            return 'Sob Consulta';
        }
        return number_format($this->preco, 0, ',', '.') . ' Kz';
    }

    /**
     * Get the image URL or placeholder
     */
    public function getImagemUrlAttribute()
    {
        if ($this->imagem && file_exists(public_path('storage/' . $this->imagem))) {
            return asset('storage/' . $this->imagem);
        }
        return asset('images/placeholder.jpg');
    }
}
