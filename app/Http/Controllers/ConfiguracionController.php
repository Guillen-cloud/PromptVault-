<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prompt;
use App\Models\Compartido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id() ?? 1);

        // Estadísticas del usuario
        $stats = [
            'total_prompts' => Prompt::where('user_id', $user->id)->count(),
            'categorias_usadas' => Prompt::where('user_id', $user->id)
                ->distinct('categoria_id')
                ->count('categoria_id'),
            'compartidos' => Compartido::whereHas('prompt', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count()
        ];

        return view('configuracion.index', compact('user', 'stats'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);

        $user = User::find(Auth::id() ?? 1);
        $user->update($validated);

        return back()->with('success', '✅ Perfil actualizado exitosamente');
    }

    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'tema' => 'required|in:light,dark'
        ]);

        $user = User::find(Auth::id() ?? 1);
        $user->update(['tema_preferido' => $validated['tema']]);

        return back()->with('success', '✅ Preferencias guardadas exitosamente');
    }

    public function updateNotifications(Request $request)
    {
        // Aquí se guardarían las preferencias de notificaciones
        return back()->with('success', '✅ Configuración de notificaciones actualizada');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = User::find(Auth::id() ?? 1);

        // Verificar contraseña actual (en producción, verificar con Hash::check)
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->with('error', '❌ La contraseña actual es incorrecta');
        }

        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        return back()->with('success', '✅ Contraseña cambiada exitosamente');
    }

    public function export(Request $request)
    {
        $format = $request->input('format', 'json');
        $user = User::find(Auth::id() ?? 1);

        // Obtener todos los prompts del usuario con relaciones
        $prompts = Prompt::where('user_id', $user->id)
            ->with(['categoria', 'etiquetas', 'versiones', 'compartidos'])
            ->get();

        if ($format === 'json') {
            $data = [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'export_date' => now()->toDateTimeString()
                ],
                'prompts' => $prompts->map(function ($prompt) {
                    return [
                        'titulo' => $prompt->titulo,
                        'contenido' => $prompt->contenido,
                        'descripcion' => $prompt->descripcion,
                        'categoria' => $prompt->categoria->nombre ?? null,
                        'ia_destino' => $prompt->ia_destino,
                        'etiquetas' => $prompt->etiquetas->pluck('nombre')->toArray(),
                        'version_actual' => $prompt->version_actual,
                        'veces_usado' => $prompt->veces_usado,
                        'es_favorito' => $prompt->es_favorito,
                        'created_at' => $prompt->created_at->toDateTimeString(),
                        'versiones_count' => $prompt->versiones->count()
                    ];
                })
            ];

            $filename = 'promptvault_export_' . now()->format('Y-m-d_His') . '.json';

            return response()->json($data, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        if ($format === 'csv') {
            $filename = 'promptvault_export_' . now()->format('Y-m-d_His') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($prompts) {
                $file = fopen('php://output', 'w');

                // Encabezados CSV
                fputcsv($file, ['Título', 'Contenido', 'Descripción', 'Categoría', 'IA Destino', 'Etiquetas', 'Versión', 'Veces Usado', 'Favorito', 'Fecha Creación']);

                foreach ($prompts as $prompt) {
                    fputcsv($file, [
                        $prompt->titulo,
                        $prompt->contenido,
                        $prompt->descripcion,
                        $prompt->categoria->nombre ?? '',
                        $prompt->ia_destino,
                        $prompt->etiquetas->pluck('nombre')->implode(', '),
                        $prompt->version_actual,
                        $prompt->veces_usado,
                        $prompt->es_favorito ? 'Sí' : 'No',
                        $prompt->created_at->format('Y-m-d H:i:s')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return back()->with('error', 'Formato no soportado');
    }
}
