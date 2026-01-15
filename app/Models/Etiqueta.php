<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Etiqueta extends Model
{
    protected $table = 'etiquetas';

    protected $fillable = [
        'nombre'
    ];

    /**
     * Relación: Una etiqueta pertenece a muchos prompts (N:M)
     */
    public function prompts(): BelongsToMany
    {
        return $this->belongsToMany(Prompt::class, 'prompt_tag', 'tag_id', 'prompt_id');
    }
}
