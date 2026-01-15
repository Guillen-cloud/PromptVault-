<?php

namespace App\Policies;

use App\Models\Prompt;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromptPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any prompts.
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver la lista
    }

    /**
     * Determine whether the user can view the prompt.
     */
    public function view(User $user, Prompt $prompt): bool
    {
        // Puede ver si es público o si es el propietario
        return $prompt->es_publico || $prompt->user_id === $user->id;
    }

    /**
     * Determine whether the user can create prompts.
     */
    public function create(User $user): bool
    {
        return true; // Todos los usuarios autenticados pueden crear
    }

    /**
     * Determine whether the user can update the prompt.
     */
    public function update(User $user, Prompt $prompt): bool
    {
        // Solo el propietario puede actualizar
        return $prompt->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the prompt.
     */
    public function delete(User $user, Prompt $prompt): bool
    {
        // Solo el propietario puede eliminar
        return $prompt->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the prompt.
     */
    public function restore(User $user, Prompt $prompt): bool
    {
        return $prompt->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the prompt.
     */
    public function forceDelete(User $user, Prompt $prompt): bool
    {
        return $prompt->user_id === $user->id;
    }
}
