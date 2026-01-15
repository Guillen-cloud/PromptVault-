<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Programación', 'descripcion' => 'Prompts para ayuda con código', 'color' => '#3b82f6', 'icono' => '💻'],
            ['nombre' => 'Redacción', 'descripcion' => 'Escritura de textos y documentos', 'color' => '#22c55e', 'icono' => '✍️'],
            ['nombre' => 'Análisis', 'descripcion' => 'Análisis de datos e información', 'color' => '#8b5cf6', 'icono' => '📊'],
            ['nombre' => 'Traducción', 'descripcion' => 'Traducir entre idiomas', 'color' => '#f59e0b', 'icono' => '🌍'],
            ['nombre' => 'Creatividad', 'descripcion' => 'Generación de ideas creativas', 'color' => '#ec4899', 'icono' => '🎨'],
            ['nombre' => 'Educación', 'descripcion' => 'Explicaciones y tutoriales', 'color' => '#06b6d4', 'icono' => '📚'],
            ['nombre' => 'Productividad', 'descripcion' => 'Organización y planificación', 'color' => '#84cc16', 'icono' => '⚡'],
            ['nombre' => 'Investigación', 'descripcion' => 'Búsqueda de información', 'color' => '#6366f1', 'icono' => '🔬'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
