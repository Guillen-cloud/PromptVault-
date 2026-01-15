<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use Illuminate\Database\Seeder;

class EtiquetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $etiquetas = [
            ['nombre' => 'Python'],
            ['nombre' => 'JavaScript'],
            ['nombre' => 'PHP'],
            ['nombre' => 'Laravel'],
            ['nombre' => 'React'],
            ['nombre' => 'SQL'],
            ['nombre' => 'Debug'],
            ['nombre' => 'Optimización'],
            ['nombre' => 'Tutorial'],
            ['nombre' => 'Resumen'],
            ['nombre' => 'Explicación'],
            ['nombre' => 'Ideas'],
        ];

        foreach ($etiquetas as $etiqueta) {
            Etiqueta::create($etiqueta);
        }
    }
}
