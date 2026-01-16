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
            [
                'titulo' => 'Email profesional',
                'contenido' => 'Escribe un email profesional para: [PROPÓSITO]\n\nContexto: [CONTEXTO]\nDestinatario: [CARGO/RELACIÓN]\nTono: [Formal/Amigable/Persuasivo]\n\nEl email debe:\n- Ser claro y conciso\n- Tener estructura profesional\n- Incluir llamado a la acción',
                'descripcion' => 'Para redactar emails profesionales efectivos',
                'categoria' => 'Redacción',
                'ia_destino' => 'Claude',
                'etiquetas' => ['Comunicación']
            ],
            [
                'titulo' => 'Revisar gramática',
                'contenido' => 'Revisa el siguiente texto y corrige errores de gramática, ortografía y estilo:\n\n[TEXTO AQUÍ]\n\nProporciona:\n1. Versión corregida\n2. Lista de errores encontrados\n3. Sugerencias de mejora',
                'descripcion' => 'Para mejorar la calidad de textos',
                'categoria' => 'Redacción',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['Corrección']
            ],
            [
                'titulo' => 'Crear API REST',
                'contenido' => 'Diseña una API REST para [DESCRIPCIÓN DEL SISTEMA]\n\nIncluye:\n- Endpoints principales\n- Métodos HTTP\n- Estructura de request/response\n- Códigos de estado\n- Autenticación necesaria\n- Ejemplos de uso',
                'descripcion' => 'Para diseñar APIs RESTful bien estructuradas',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['API']
            ],
            [
                'titulo' => 'Explicar concepto técnico',
                'contenido' => 'Explica el concepto de [TÉRMINO TÉCNICO] de tres maneras:\n\n1. Para un niño de 10 años\n2. Para un estudiante universitario\n3. Para un profesional del área\n\nIncluye ejemplos prácticos y analogías',
                'descripcion' => 'Para entender conceptos complejos fácilmente',
                'categoria' => 'Educación',
                'ia_destino' => 'Claude',
                'etiquetas' => ['Tutorial', 'Explicación']
            ],
            [
                'titulo' => 'Escribir test unitario',
                'contenido' => 'Genera test unitarios completos para la siguiente función:\n\n[FUNCIÓN AQUÍ]\n\nLos tests deben cubrir:\n- Casos exitosos\n- Casos de error\n- Casos límite\n- Validaciones\n\nUsa [Jest/PHPUnit/PyTest] según el lenguaje',
                'descripcion' => 'Para crear tests unitarios exhaustivos',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['Testing']
            ],
            [
                'titulo' => 'Generar contenido redes sociales',
                'contenido' => 'Crea 5 posts para [RED SOCIAL] sobre [TEMA]\n\nCada post debe:\n- Ser engaging y auténtico\n- Incluir call-to-action\n- Tener 2-3 hashtags relevantes\n- Adaptarse al tono de la marca\n\nTono: [Profesional/Casual/Inspirador]',
                'descripcion' => 'Para crear contenido efectivo en redes sociales',
                'categoria' => 'Marketing',
                'ia_destino' => 'Gemini',
                'etiquetas' => ['Ideas', 'Comunicación']
            ],
            [
                'titulo' => 'Refactorizar código',
                'contenido' => 'Refactoriza el siguiente código aplicando principios SOLID y mejores prácticas:\n\n[CÓDIGO AQUÍ]\n\nMejoras a implementar:\n- Mejorar legibilidad\n- Eliminar código duplicado\n- Optimizar rendimiento\n- Añadir comentarios útiles\n\nExplica cada cambio realizado',
                'descripcion' => 'Para mejorar la calidad del código existente',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['Optimización']
            ],
            [
                'titulo' => 'Crear plan de marketing',
                'contenido' => 'Desarrolla un plan de marketing digital de 3 meses para:\n\nProducto/Servicio: [DESCRIPCIÓN]\nObjetivo: [META]\nPresupuesto: [MONTO]\nPúblico objetivo: [DESCRIPCIÓN]\n\nIncluye:\n- Estrategia por canal\n- KPIs a medir\n- Calendario de contenido\n- Presupuesto distribuido',
                'descripcion' => 'Para planificar estrategias de marketing digital',
                'categoria' => 'Marketing',
                'ia_destino' => 'Claude',
                'etiquetas' => []
            ],
            [
                'titulo' => 'Analizar competencia',
                'contenido' => 'Realiza un análisis competitivo de [EMPRESA/PRODUCTO]\n\nAnaliza:\n1. Principales competidores (mínimo 3)\n2. Fortalezas y debilidades\n3. Estrategias de precios\n4. Propuesta de valor única\n5. Oportunidades de diferenciación\n\nFormato: Tabla comparativa',
                'descripcion' => 'Para entender el panorama competitivo',
                'categoria' => 'Análisis',
                'ia_destino' => 'Gemini',
                'etiquetas' => []
            ],
            [
                'titulo' => 'Crear prompt optimizado',
                'contenido' => 'Mejora el siguiente prompt para obtener mejores resultados:\n\n[PROMPT ORIGINAL]\n\nOptimiza:\n- Claridad de instrucciones\n- Contexto proporcionado\n- Formato de salida esperado\n- Restricciones y reglas\n\nExplica las mejoras aplicadas',
                'descripcion' => 'Para mejorar la efectividad de tus prompts',
                'categoria' => 'Creatividad',
                'ia_destino' => 'Claude',
                'etiquetas' => ['Ideas']
            ],
            [
                'titulo' => 'Diagrama de base de datos',
                'contenido' => 'Diseña un esquema de base de datos para [SISTEMA]\n\nIncluye:\n- Tablas principales\n- Campos con tipos de datos\n- Relaciones (1:1, 1:N, N:M)\n- Índices recomendados\n- Restricciones de integridad\n\nFormato: Notación ERD o descripción textual',
                'descripcion' => 'Para diseñar estructuras de bases de datos',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['SQL']
            ],
            [
                'titulo' => 'Presentación ejecutiva',
                'contenido' => 'Crea el outline de una presentación de [TEMA] para [AUDIENCIA]\n\nDuración: [MINUTOS]\n\nEstructura:\n1. Título y gancho inicial\n2. 5-7 slides principales con puntos clave\n3. Datos/estadísticas a incluir\n4. Call to action final\n\nTono: [Persuasivo/Informativo/Inspirador]',
                'descripcion' => 'Para estructurar presentaciones impactantes',
                'categoria' => 'Redacción',
                'ia_destino' => 'Claude',
                'etiquetas' => ['Comunicación']
            ],
            [
                'titulo' => 'Algoritmo de búsqueda',
                'contenido' => 'Implementa un algoritmo de búsqueda/ordenamiento en [LENGUAJE] para:\n\n[DESCRIPCIÓN DEL PROBLEMA]\n\nRequisitos:\n- Complejidad temporal óptima\n- Comentarios explicativos\n- Casos de prueba\n- Análisis de complejidad Big O',
                'descripcion' => 'Para implementar algoritmos eficientes',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['Optimización']
            ],
            [
                'titulo' => 'Investigación de tema',
                'contenido' => 'Investiga sobre [TEMA] y proporciona:\n\n1. Resumen ejecutivo (200 palabras)\n2. Conceptos clave\n3. Estado actual del tema\n4. Tendencias futuras\n5. Recursos para profundizar\n6. Referencias confiables',
                'descripcion' => 'Para investigar temas rápidamente',
                'categoria' => 'Educación',
                'ia_destino' => 'Gemini',
                'etiquetas' => ['Resumen']
            ],
            [
                'titulo' => 'Solucionar bug complejo',
                'contenido' => 'Ayúdame a solucionar este bug:\n\nProblema: [DESCRIPCIÓN]\nCódigo relevante: [CÓDIGO]\nError: [MENSAJE/COMPORTAMIENTO]\nLo que he intentado: [INTENTOS]\n\nNecesito:\n1. Diagnóstico del problema\n2. Solución paso a paso\n3. Prevención de errores similares',
                'descripcion' => 'Para resolver bugs difíciles sistemáticamente',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['Debug']
            ],
            // Prompts específicos usados en este proyecto
            [
                'titulo' => 'Crear modelo Laravel con relaciones',
                'contenido' => 'Crea un modelo Laravel para [NOMBRE_MODELO] con las siguientes características:\n\nCampos:\n[LISTA DE CAMPOS]\n\nRelaciones:\n[DESCRIBE LAS RELACIONES]\n\nIncluye:\n- Fillable/Guarded\n- Casts apropiados\n- Relaciones Eloquent (hasMany, belongsTo, belongsToMany)\n- Scopes útiles\n- Accessor/Mutators si son necesarios',
                'descripcion' => 'Para crear modelos Eloquent con todas sus relaciones',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['PHP', 'Laravel']
            ],
            [
                'titulo' => 'Crear migración Laravel',
                'contenido' => 'Crea una migración de Laravel para la tabla [NOMBRE_TABLA]:\n\nCampos necesarios:\n[LISTA DE CAMPOS CON TIPOS]\n\nRelaciones/Claves foráneas:\n[DESCRIBE FOREIGN KEYS]\n\nIncluye:\n- Definición de campos con tipos correctos\n- Índices necesarios\n- Constraints (unique, nullable, default)\n- Foreign keys con onDelete/onUpdate\n- Método down() para rollback',
                'descripcion' => 'Para crear migraciones de base de datos en Laravel',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['PHP', 'Laravel', 'SQL']
            ],
            [
                'titulo' => 'Crear controlador CRUD Laravel',
                'contenido' => 'Crea un controlador Laravel para [RECURSO] con las siguientes operaciones:\n\n- index: Listar con paginación y filtros\n- create: Mostrar formulario\n- store: Guardar con validación\n- show: Mostrar detalle\n- edit: Formulario de edición\n- update: Actualizar con validación\n- destroy: Eliminar (soft delete)\n\nIncluye:\n- Validaciones en Request personalizado\n- Manejo de errores\n- Mensajes flash\n- Autorización con Policy',
                'descripcion' => 'Para crear controladores CRUD completos en Laravel',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['PHP', 'Laravel']
            ],
            [
                'titulo' => 'Crear vista Blade reutilizable',
                'contenido' => 'Crea una vista Blade para [COMPONENTE]:\n\nPropósito: [DESCRIPCIÓN]\nDatos que recibe: [VARIABLES]\n\nDebe incluir:\n- Estructura HTML semántica\n- Directivas Blade (@foreach, @if, etc.)\n- Estilos inline o clases Tailwind\n- Componentes reutilizables\n- Manejo de datos vacíos\n- Mensajes de validación si aplica',
                'descripcion' => 'Para crear vistas Blade modernas y reutilizables',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['PHP', 'Laravel']
            ],
            [
                'titulo' => 'Crear seeder con datos realistas',
                'contenido' => 'Crea un seeder de Laravel para [MODELO] con datos realistas:\n\nCantidad: [NÚMERO] registros\nCampos: [LISTA DE CAMPOS]\n\nRequiere:\n- Datos coherentes y realistas\n- Relaciones con otros modelos\n- Variedad en los datos\n- Considerar casos edge\n- Usar factories si es complejo',
                'descripcion' => 'Para poblar la base de datos con datos de prueba',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['PHP', 'Laravel']
            ],
            [
                'titulo' => 'Implementar Policy de autorización',
                'contenido' => 'Crea una Policy de Laravel para [MODELO]:\n\nPermisos a implementar:\n- viewAny: ¿Quién puede ver la lista?\n- view: ¿Quién puede ver uno específico?\n- create: ¿Quién puede crear?\n- update: ¿Quién puede editar?\n- delete: ¿Quién puede eliminar?\n\nReglas de negocio:\n[DESCRIBE LAS REGLAS]\n\nIncluye comentarios explicativos',
                'descripcion' => 'Para implementar autorización con Policies en Laravel',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['PHP', 'Laravel']
            ],
            [
                'titulo' => 'Diseñar sistema de versionamiento',
                'contenido' => 'Diseña un sistema de versionamiento para [ENTIDAD] que permita:\n\nRequisitos:\n- Guardar historial de cambios\n- Comparar versiones\n- Revertir a versión anterior\n- Mostrar quién y cuándo hizo cambios\n\nDefine:\n1. Estructura de base de datos (tablas)\n2. Modelos y relaciones\n3. Lógica de guardado de versión\n4. Método para comparar/revertir',
                'descripcion' => 'Para implementar control de versiones en aplicaciones',
                'categoria' => 'Programación',
                'ia_destino' => 'Claude',
                'etiquetas' => ['PHP', 'Laravel']
            ],
            [
                'titulo' => 'Crear sistema de compartir recursos',
                'contenido' => 'Diseña un sistema para compartir [RECURSO] entre usuarios:\n\nFuncionalidades:\n- Compartir por email o enlace\n- Niveles de acceso (lectura/escritura)\n- Notificaciones al compartir\n- Historial de compartidos\n- Revocar acceso\n\nIncluye:\n1. Estructura de base de datos\n2. Modelos necesarios\n3. Lógica de compartir\n4. Validaciones de seguridad',
                'descripcion' => 'Para implementar funcionalidad de compartir en apps',
                'categoria' => 'Programación',
                'ia_destino' => 'Claude',
                'etiquetas' => ['PHP', 'Laravel']
            ],
            [
                'titulo' => 'Implementar búsqueda avanzada',
                'contenido' => 'Crea una funcionalidad de búsqueda avanzada para [MODELO] en Laravel:\n\nCampos buscables:\n[LISTA DE CAMPOS]\n\nFiltros:\n[FILTROS DISPONIBLES]\n\nDebe incluir:\n- Búsqueda por texto (LIKE)\n- Filtros múltiples\n- Paginación\n- Ordenamiento\n- Query optimization\n- Resultados destacados',
                'descripcion' => 'Para implementar búsqueda con filtros en Laravel',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['PHP', 'Laravel', 'SQL']
            ],
            [
                'titulo' => 'Crear formulario con validación',
                'contenido' => 'Crea un formulario HTML/Blade para [PROPÓSITO]:\n\nCampos:\n[LISTA DE CAMPOS CON TIPOS]\n\nValidaciones necesarias:\n[REGLAS DE VALIDACIÓN]\n\nIncluye:\n- HTML semántico con labels\n- Validación Laravel (FormRequest)\n- Mostrar errores por campo\n- Preservar valores en error\n- CSRF token\n- Botones de acción',
                'descripcion' => 'Para crear formularios completos con validación',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['PHP', 'Laravel']
            ],
            [
                'titulo' => 'Optimizar consultas N+1',
                'contenido' => 'Optimiza las siguientes consultas Eloquent que tienen problema N+1:\n\n[CÓDIGO CON QUERIES]\n\nProblemas detectados:\n[DESCRIBE EL PROBLEMA]\n\nOptimiza usando:\n- Eager Loading (with, load)\n- Lazy Eager Loading\n- Counts/Exists optimization\n- Select específicos\n\nMuestra before/after y explica la mejora',
                'descripcion' => 'Para resolver problemas de performance N+1 en Laravel',
                'categoria' => 'Programación',
                'ia_destino' => 'ChatGPT',
                'etiquetas' => ['PHP', 'Laravel', 'Optimización']
            ],
            [
                'titulo' => 'Diseñar estructura de categorización',
                'contenido' => 'Diseña un sistema de categorización y etiquetado para [RECURSO]:\n\nRequisitos:\n- Categorías jerárquicas (opcional)\n- Múltiples etiquetas por item\n- Filtrado por categoría/etiqueta\n- Búsqueda combinada\n\nDefine:\n1. Estructura de tablas (categorías, etiquetas, pivotes)\n2. Modelos y relaciones\n3. Queries para filtrado\n4. UI para selección',
                'descripcion' => 'Para implementar sistemas de categorías y etiquetas',
                'categoria' => 'Programación',
                'ia_destino' => 'Claude',
                'etiquetas' => ['PHP', 'Laravel', 'SQL']
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
