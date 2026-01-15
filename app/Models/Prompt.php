<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Prompt extends Model
{
    protected $table = 'prompts';

    protected $fillable = [
        'user_id',
        'titulo',
        'contenido',
        'descripcion',
        'categoria_id',
        'ia_destino',
        'es_favorito',
        'es_publico',
        'veces_usado',
        'version_actual'
    ];

    protected $casts = [
        'es_favorito' => 'boolean',
        'es_publico' => 'boolean',
        'veces_usado' => 'integer',
        'version_actual' => 'integer'
    ];

    /**
     * Accessor para numero_version (alias de version_actual)
     */
    public function getNumeroVersionAttribute()
    {
        return $this->version_actual ?? 1;
    }

    /**
     * Relación: Un prompt pertenece a un usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias para mantener compatibilidad
     */
    public function usuario(): BelongsTo
    {
        return $this->user();
    }

    /**
     * Relación: Un prompt pertenece a una categoría
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Relación: Un prompt tiene muchas versiones
     */
    public function versiones(): HasMany
    {
        return $this->hasMany(Version::class, 'prompt_id');
    }

    /**
     * Relación: Un prompt tiene muchos compartidos
     */
    public function compartidos(): HasMany
    {
        return $this->hasMany(Compartido::class, 'prompt_id');
    }

    /**
     * Relación: Un prompt tiene muchas actividades
     */
    public function actividades(): HasMany
    {
        return $this->hasMany(Actividad::class, 'prompt_id');
    }

    /**
     * Relación: Un prompt tiene muchas etiquetas (N:M)
     */
    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(Etiqueta::class, 'prompt_tag', 'prompt_id', 'tag_id');
    }

    /**
     * Incrementar el contador de uso
     */
    public function incrementarUso(): void
    {
        $this->increment('veces_usado');
        $this->registrarActividad('usado', 'Prompt utilizado');
    }

    /**
     * Marcar como favorito
     */
    public function toggleFavorito(): void
    {
        $this->es_favorito = !$this->es_favorito;
        $this->save();
        $accion = $this->es_favorito ? 'marcado como favorito' : 'desmarcado como favorito';
        $this->registrarActividad('favorito', "Prompt {$accion}");
    }

    /**
     * Registrar actividad
     */
    public function registrarActividad(string $accion, string $descripcion = null): void
    {
        $this->actividades()->create([
            'user_id' => Auth::id() ?? 1,
            'accion' => $accion,
            'descripcion' => $descripcion ?? "Acción: {$accion}"
        ]);
    }
}
