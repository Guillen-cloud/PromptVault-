<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use App\Models\Categoria;
use App\Models\Actividad;
use App\Models\Compartido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id() ?? 1; // Temporal: usar ID 1 si no hay autenticación

        // Estadísticas generales
        $totalPrompts = Prompt::where('user_id', $userId)->count();
        $promptsFavoritos = Prompt::where('user_id', $userId)
            ->where('es_favorito', true)
            ->count();
        $promptsCompartidos = Compartido::whereHas('prompt', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        // Prompts más usados este mes
        $promptsMasUsados = Actividad::where('user_id', $userId)
            ->where('accion', 'usar')
            ->whereMonth('created_at', now()->month)
            ->distinct('prompt_id')
            ->count('prompt_id');

        // Prompts por categoría
        $promptsPorCategoria = Categoria::withCount(['prompts' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->get();

        // Prompts recientes
        $promptsRecientes = Prompt::where('user_id', $userId)
            ->with(['categoria', 'usuario'])
            ->latest()
            ->take(4)
            ->get();

        return view('dashboard', compact(
            'totalPrompts',
            'promptsFavoritos',
            'promptsCompartidos',
            'promptsMasUsados',
            'promptsPorCategoria',
            'promptsRecientes'
        ));
    }
}
