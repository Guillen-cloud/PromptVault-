<?php

namespace App\Http\Controllers;

use App\Models\Compartido;
use App\Models\Prompt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompartidoController extends Controller
{
    public function index()
    {
        $compartidos = Compartido::with('prompt')
            ->whereHas('prompt', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->paginate(10);

        // Obtener todos los prompts del usuario para el modal
        $prompts = Prompt::where('user_id', auth()->id())->get();

        return view('compartidos.index', compact('compartidos', 'prompts'));
    }

    /**
     * Guardar un nuevo compartido
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prompt_id' => 'required|exists:prompts,id',
            'nombre_destinatario' => 'required|string|max:140',
            'email_destinatario' => 'required|email|max:160',
            'notas' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Verificar que el prompt pertenece al usuario
            $prompt = Prompt::where('id', $validated['prompt_id'])
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // Crear el registro de compartido
            $compartido = Compartido::create([
                'prompt_id' => $validated['prompt_id'],
                'nombre_destinatario' => $validated['nombre_destinatario'],
                'email_destinatario' => $validated['email_destinatario'],
                'fecha_compartido' => now(),
                'notas' => $validated['notas']
            ]);

            // Registrar actividad
            $prompt->registrarActividad('compartido', "Prompt compartido con {$validated['nombre_destinatario']} ({$validated['email_destinatario']})");

            DB::commit();

            return redirect()->route('compartidos.index')
                ->with('success', '¡Prompt compartido exitosamente con ' . $validated['nombre_destinatario'] . '!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al compartir el prompt: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un compartido
     */
    public function destroy(Compartido $compartido)
    {
        try {
            // Verificar que el prompt del compartido pertenece al usuario
            if ($compartido->prompt->user_id !== auth()->id()) {
                return back()->with('error', 'No tienes permiso para eliminar este registro');
            }

            $nombreDestinatario = $compartido->nombre_destinatario;
            $compartido->delete();

            return redirect()->route('compartidos.index')
                ->with('success', "Registro de compartido con {$nombreDestinatario} eliminado exitosamente");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
        }
    }
}
