<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Version extends Model
{
    protected $table = 'versiones';

    public $timestamps = false;

    protected $fillable = [
        'prompt_id',
        'numero_version',
        'contenido_anterior',
        'motivo_cambio'
    ];

    protected $casts = [
        'numero_version' => 'integer',
        'created_at' => 'datetime'
    ];

    /**
     * Relación: Una versión pertenece a un prompt
     */
    public function prompt(): BelongsTo
    {
        return $this->belongsTo(Prompt::class, 'prompt_id');
    }
}
