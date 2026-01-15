<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Compartido extends Model
{
    protected $table = 'compartidos';

    protected $fillable = [
        'prompt_id',
        'nombre_destinatario',
        'email_destinatario',
        'fecha_compartido',
        'notas'
    ];

    protected $casts = [
        'fecha_compartido' => 'datetime'
    ];

    /**
     * Relación: Un compartido pertenece a un prompt
     */
    public function prompt(): BelongsTo
    {
        return $this->belongsTo(Prompt::class, 'prompt_id');
    }
}
