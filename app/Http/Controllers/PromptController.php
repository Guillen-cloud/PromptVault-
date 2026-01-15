<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use App\Models\Categoria;
use App\Models\Etiqueta;
use App\Http\Requests\StorePromptRequest;
use App\Http\Requests\UpdatePromptRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromptController extends Controller
{
    /**
     * Constructor - registrar políticas
     */
    public function __construct()
    {
        $this->authorizeResource(Prompt::class, 'prompt');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prompt::with(['categoria', 'etiquetas'])
            ->where('user_id', auth()->id())
            ->orWhere('es_publico', true);

        // Búsqueda por palabra clave
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                    ->orWhere('contenido', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Filtro por etiqueta
        if ($request->filled('etiqueta')) {
            $query->whereHas('etiquetas', function ($q) use ($request) {
                $q->where('etiquetas.id', $request->etiqueta);
            });
        }

        // Filtro por IA destino
        if ($request->filled('ia_destino')) {
            $query->where('ia_destino', $request->ia_destino);
        }

        // Filtro de favoritos
        if ($request->boolean('favoritos')) {
            $query->where('es_favorito', true);
        }

        // Ordenamiento
        $query->orderBy('updated_at', 'desc');

        $prompts = $query->paginate(10);
        $categorias = Categoria::all();

        return view('prompts.index', compact('prompts', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        $etiquetas = Etiqueta::all();

        return view('prompts.create', compact('categorias', 'etiquetas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromptRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $validated['user_id'] = auth()->id();

            $prompt = Prompt::create($validated);

            if ($request->filled('etiquetas')) {
                $prompt->etiquetas()->attach($request->etiquetas);
            }

            // Registrar actividad
            $prompt->registrarActividad('creado', 'Prompt creado exitosamente');

            DB::commit();

            return redirect()->route('prompts.show', $prompt)
                ->with('success', 'Prompt creado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al crear el prompt: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Prompt $prompt)
    {
        $prompt->load(['categoria', 'etiquetas', 'versiones', 'compartidos', 'actividades']);
        return view('prompts.show', compact('prompt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prompt $prompt)
    {
        $categorias = Categoria::all();
        $etiquetas = Etiqueta::all();

        return view('prompts.edit', compact('prompt', 'categorias', 'etiquetas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromptRequest $request, Prompt $prompt)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            'contenido' => 'required|string',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'ia_destino' => 'required|string|max:60',
            'es_publico' => 'boolean',
            'motivo_cambio' => 'nullable|string|max:255',
            'etiquetas' => 'array'
        ]);

        DB::beginTransaction();
        try {
            // Guardar versión anterior si el contenido cambió
            if ($prompt->contenido !== $validated['contenido']) {
                $prompt->versiones()->create([
                    'numero_version' => $prompt->version_actual,
                    'contenido_anterior' => $prompt->contenido,
                    'motivo_cambio' => $request->motivo_cambio ?? 'Sin motivo especificado'
                ]);

                $validated['version_actual'] = $prompt->version_actual + 1;
            }

            $prompt->update($validated);

            // Sincronizar etiquetas
            if ($request->has('etiquetas')) {
                $prompt->etiquetas()->sync($request->etiquetas);
            }

            // Registrar actividad
            $prompt->registrarActividad('editado', 'Prompt actualizado');

            DB::commit();

            return redirect()->route('prompts.show', $prompt)
                ->with('success', 'Prompt actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al actualizar el prompt: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prompt $prompt)
    {
        try {
            $prompt->registrarActividad('eliminado', 'Prompt eliminado');
            $prompt->delete();

            return redirect()->route('prompts.index')
                ->with('success', 'Prompt eliminado exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el prompt: ' . $e->getMessage());
        }
    }

    /**
     * Incrementar uso del prompt
     */
    public function use(Prompt $prompt)
    {
        $prompt->incrementarUso();

        return response()->json([
            'success' => true,
            'veces_usado' => $prompt->veces_usado
        ]);
    }

    /**
     * Toggle favorito
     */
    public function toggleFavorito(Prompt $prompt)
    {
        $prompt->toggleFavorito();

        return back()->with(
            'success',
            $prompt->es_favorito ? 'Agregado a favoritos' : 'Eliminado de favoritos'
        );
    }

    /**
     * Copiar prompt al portapapeles (devuelve JSON)
     */
    public function copy(Prompt $prompt)
    {
        $prompt->incrementarUso();

        return response()->json([
            'success' => true,
            'contenido' => $prompt->contenido,
            'message' => 'Prompt copiado al portapapeles'
        ]);
    }

    /**
     * Exportar prompts del usuario a CSV
     */
    public function export(Request $request)
    {
        $query = Prompt::with(['categoria', 'etiquetas'])
            ->where('user_id', auth()->id());

        // Aplicar filtros si existen
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                    ->orWhere('contenido', 'like', "%{$search}%");
            });
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        $prompts = $query->get();

        $filename = 'prompts_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($prompts) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Encabezados
            fputcsv($file, [
                'ID',
                'Título',
                'Descripción',
                'Contenido',
                'Categoría',
                'Etiquetas',
                'IA Destino',
                'Público',
                'Favorito',
                'Veces Usado',
                'Fecha Creación'
            ]);

            // Datos
            foreach ($prompts as $prompt) {
                fputcsv($file, [
                    $prompt->id,
                    $prompt->titulo,
                    $prompt->descripcion,
                    $prompt->contenido,
                    $prompt->categoria->nombre ?? 'Sin categoría',
                    $prompt->etiquetas->pluck('nombre')->join(', '),
                    $prompt->ia_destino ?? 'N/A',
                    $prompt->es_publico ? 'Sí' : 'No',
                    $prompt->es_favorito ? 'Sí' : 'No',
                    $prompt->veces_usado ?? 0,
                    $prompt->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
