<?php

namespace Database\Seeders;

use App\Models\Prompt;
use App\Models\Categoria;
use App\Models\Etiqueta;
use Illuminate\Database\Seeder;

class PromptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prompts = [
            [
                'titulo' => 'Explicar código',
                'contenido' => 'Explica línea por línea qué hace el siguiente código, de manera clara y concisa:\n\n[CÓDIGO AQUÍ]',
                'descripcion' => 'Para entender código complejo paso a paso',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['Tutorial', 'Explicación']
            ],
            [
                'titulo' => 'Resumen ejecutivo',
                'contenido' => 'Resume el siguiente texto en un párrafo de 100 palabras, manteniendo los puntos clave:\n\n[TEXTO AQUÍ]',
                'descripcion' => 'Para crear resúmenes ejecutivos de textos largos',
                'categoria' => 'Redacción',
                'ia_destino' => 'Claude',
                'etiquetas' => ['Resumen']
            ],
            [
                'titulo' => 'Analizar datos CSV',
                'contenido' => 'Analiza los siguientes datos y genera insights clave, identifica patrones y sugiere conclusiones:\n\n[DATOS CSV AQUÍ]',
                'descripcion' => 'Para análisis rápido de conjuntos de datos',
                'categoria' => 'Análisis',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['SQL']
            ],
            [
                'titulo' => 'Generar ideas creativas',
                'contenido' => 'Dame 10 ideas creativas e innovadoras para: [TEMA]\n\nCada idea debe ser:\n- Original y única\n- Práctica de implementar\n- Con potencial de impacto',
                'descripcion' => 'Para brainstorming y generación de ideas',
                'categoria' => 'Creatividad',
                'ia_destino' => 'Gemini',
                'etiquetas' => ['Ideas']
            ],
            [
                'titulo' => 'Plan de estudio',
                'contenido' => 'Crea un plan de estudio detallado de 4 semanas para aprender: [TEMA]\n\nIncluye:\n- Objetivos semanales\n- Recursos recomendados\n- Ejercicios prácticos\n- Evaluación de progreso',
                'descripcion' => 'Para organizar aprendizaje de nuevas habilidades',
                'categoria' => 'Educación',
                'ia_destino' => 'Claude',
                'etiquetas' => ['Tutorial']
            ],
            [
                'titulo' => 'Debug de código Python',
                'contenido' => 'Ayúdame a debuggear este código Python. Encuentra el error y explica por qué ocurre:\n\n[CÓDIGO CON ERROR]\n\nEl error que obtengo es:\n[MENSAJE DE ERROR]',
                'descripcion' => 'Para resolver errores en código Python',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['Python', 'Debug']
            ],
            [
                'titulo' => 'Optimizar consulta SQL',
                'contenido' => 'Optimiza la siguiente consulta SQL para mejor rendimiento y explica los cambios:\n\n[CONSULTA SQL]\n\nLa base de datos tiene [X] millones de registros.',
                'descripcion' => 'Para mejorar el rendimiento de queries SQL',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['SQL', 'Optimización']
            ],
            [
                'titulo' => 'Traducción técnica',
                'contenido' => 'Traduce el siguiente texto técnico de [IDIOMA ORIGEN] a [IDIOMA DESTINO], manteniendo la precisión terminológica:\n\n[TEXTO AQUÍ]',
                'descripcion' => 'Para traducir documentación técnica',
                'categoria' => 'Traducción',
                'ia_destino' => 'Claude',
                'etiquetas' => []
            ],
            [
                'titulo' => 'Crear componente React',
                'contenido' => 'Crea un componente React funcional para: [DESCRIPCIÓN]\n\nRequisitos:\n- Usar hooks modernos\n- TypeScript\n- Comentarios explicativos\n- Manejo de errores',
                'descripcion' => 'Para generar componentes React con mejores prácticas',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['JavaScript', 'React']
            ],
            [
                'titulo' => 'Documentar función',
                'contenido' => 'Genera documentación completa para esta función siguiendo el estándar JSDoc/PHPDoc:\n\n[FUNCIÓN AQUÍ]\n\nIncluye:\n- Descripción\n- Parámetros\n- Retorno\n- Ejemplos de uso\n- Excepciones posibles',
                'descripcion' => 'Para documentar código profesionalmente',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['PHP', 'JavaScript']
            ],
        ];

        foreach ($prompts as $promptData) {
            $categoria = Categoria::where('nombre', $promptData['categoria'])->first();

            $prompt = Prompt::create([
                'user_id' => 1, // Usuario demo
                'titulo' => $promptData['titulo'],
                'contenido' => $promptData['contenido'],
                'descripcion' => $promptData['descripcion'],
                'categoria_id' => $categoria?->id,
                'ia_destino' => $promptData['ia_destino'],
                'es_publico' => true,
            ]);

            // Asignar etiquetas si existen
            if (!empty($promptData['etiquetas'])) {
                $etiquetasIds = Etiqueta::whereIn('nombre', $promptData['etiquetas'])->pluck('id');
                $prompt->etiquetas()->attach($etiquetasIds);
            }
        }
    }
}
