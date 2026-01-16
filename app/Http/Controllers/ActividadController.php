<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActividadController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $query = Actividad::with('prompt')->where('user_id', $userId);

        // Filtro por tipo de acción
        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        // Filtro por fecha desde
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        // Filtro por fecha hasta
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        // Búsqueda por título de prompt
        if ($request->filled('search')) {
            $query->whereHas('prompt', function ($q) use ($request) {
                $q->where('titulo', 'like', '%' . $request->search . '%');
            });
        }

        $actividades = $query->latest()->paginate(20);

        // Estadísticas
        $totalActividades = Actividad::where('user_id', $userId)->count();

        $actividadesHoy = Actividad::where('user_id', $userId)
            ->whereDate('created_at', today())
            ->count();

        $actividadesSemana = Actividad::where('user_id', $userId)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $accionMasComun = Actividad::where('user_id', $userId)
            ->select('accion', DB::raw('count(*) as total'))
            ->groupBy('accion')
            ->orderBy('total', 'desc')
            ->first()->accion ?? null;

        return view('actividad.index', compact(
            'actividades',
            'totalActividades',
            'actividadesHoy',
            'actividadesSemana',
            'accionMasComun'
        ));
    }
}
