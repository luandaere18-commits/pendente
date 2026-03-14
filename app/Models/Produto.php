<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'imagem',
        'categoria_id',
        'tipo_item', // 'produto' ou 'servico'
        'ativo',
        'em_destaque'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'ativo' => 'boolean',
        'em_destaque' => 'boolean'
    ];

    protected $appends = [
        'preco_formatado'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeEmDestaque($query)
    {
        return $query->where('em_destaque', true);
    }

    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_item', $tipo);
    }

    public function getPrecoFormatadoAttribute()
    {
        if ($this->preco == 0 || is_null($this->preco)) {
            return 'Sob Consulta';
        }
        return number_format($this->preco, 0, ',', '.') . ' Kz';
    }

    public function getImagemUrlAttribute()
    {
        if ($this->imagem && file_exists(public_path('storage/' . $this->imagem))) {
            return asset('storage/' . $this->imagem);
        }
        return asset('images/placeholder.jpg');
    }
}
