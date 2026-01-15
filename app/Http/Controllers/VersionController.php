<?php

namespace App\Http\Controllers;

use App\Models\Version;
use App\Models\Prompt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VersionController extends Controller
{
    public function index(Request $request)
    {
        $query = Version::with('prompt');

        if ($request->filled('prompt')) {
            $query->where('prompt_id', $request->prompt);
        }

        $versiones = $query->latest()->paginate(15);
        $prompts = Prompt::all();

        return view('versiones.index', compact('versiones', 'prompts'));
    }

    /**
     * Mostrar el contenido completo de una versión
     */
    public function show(Version $version)
    {
        $version->load('prompt');

        // Verificar que la versión tenga un prompt asociado
        if (!$version->prompt) {
            return redirect()->route('versiones.index')
                ->with('error', 'La versión no tiene un prompt asociado válido.');
        }

        return view('versiones.show', compact('version'));
    }

    /**
     * Comparar una versión con la versión actual del prompt
     */
    public function compare(Version $version)
    {
        $version->load('prompt');

        // Verificar que la versión tenga un prompt asociado
        if (!$version->prompt) {
            return redirect()->route('versiones.index')
                ->with('error', 'La versión no tiene un prompt asociado válido.');
        }

        $prompt = $version->prompt;

        return view('versiones.compare', compact('version', 'prompt'));
    }

    /**
     * Restaurar una versión anterior
     */
    public function restore(Version $version)
    {
        DB::beginTransaction();
        try {
            $prompt = $version->prompt;

            // Verificar que la versión tenga un prompt asociado
            if (!$prompt) {
                return back()->with('error', 'La versión no tiene un prompt asociado válido.');
            }

            // Guardar la versión actual antes de restaurar
            $prompt->versiones()->create([
                'numero_version' => $prompt->version_actual,
                'contenido_anterior' => $prompt->contenido,
                'motivo_cambio' => 'Versión respaldada antes de restaurar v' . $version->numero_version
            ]);

            // Restaurar el contenido de la versión anterior
            $prompt->update([
                'contenido' => $version->contenido_anterior,
                'version_actual' => $prompt->version_actual + 1
            ]);

            // Registrar actividad
            $prompt->registrarActividad('restaurado', "Restaurada versión {$version->numero_version}");

            DB::commit();

            return redirect()->route('prompts.show', $prompt)
                ->with('success', "Versión {$version->numero_version} restaurada exitosamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al restaurar la versión: ' . $e->getMessage());
        }
    }
}
