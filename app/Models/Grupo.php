<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = [
        'nome',
        'display_name',
        'icone',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    /**
     * Get all categorias for this grupo
     */
    public function categorias()
    {
        return $this->hasMany(Categoria::class)->orderBy('ordem');
    }

    /**
     * Get all itens for this grupo (through categorias)
     */
    public function itens()
    {
        return $this->hasManyThrough(Item::class, Categoria::class);
    }

    /**
     * Scope: Get only active grupos
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Scope: Order by ordem ascending
     */
    public function scopeOrdenado($query)
    {
        return $query->orderBy('ordem');
    }
}
