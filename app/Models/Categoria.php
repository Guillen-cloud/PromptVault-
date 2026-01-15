<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'color',
        'icono'
    ];

    /**
     * Relación: Una categoría tiene muchos prompts
     */
    public function prompts(): HasMany
    {
        return $this->hasMany(Prompt::class, 'categoria_id');
    }
}
