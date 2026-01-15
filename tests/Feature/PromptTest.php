<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Prompt;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromptTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Cargar seeders
    }

    /**
     * Test que un usuario puede crear un prompt
     */
    public function test_user_can_create_prompt()
    {
        $user = User::factory()->create();
        $categoria = Categoria::first();

        $response = $this->actingAs($user)->post('/prompts', [
            'titulo' => 'Test Prompt',
            'contenido' => 'Este es un contenido de prueba',
            'descripcion' => 'Descripción de prueba',
            'categoria_id' => $categoria->id,
            'ia_destino' => 'ChatGPT',
            'es_publico' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('prompts', [
            'titulo' => 'Test Prompt',
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test que un usuario puede ver sus propios prompts
     */
    public function test_user_can_view_own_prompts()
    {
        $user = User::factory()->create();
        $categoria = Categoria::first();

        $prompt = Prompt::create([
            'user_id' => $user->id,
            'titulo' => 'Mi Prompt Privado',
            'contenido' => 'Contenido privado',
            'categoria_id' => $categoria->id,
            'ia_destino' => 'ChatGPT',
            'es_publico' => false,
        ]);

        $response = $this->actingAs($user)->get('/prompts');
        $response->assertSee('Mi Prompt Privado');
    }

    /**
     * Test que un usuario NO puede editar prompts de otros
     */
    public function test_user_cannot_edit_others_prompts()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $categoria = Categoria::first();

        $prompt = Prompt::create([
            'user_id' => $user1->id,
            'titulo' => 'Prompt del Usuario 1',
            'contenido' => 'Contenido',
            'categoria_id' => $categoria->id,
            'ia_destino' => 'ChatGPT',
        ]);

        $response = $this->actingAs($user2)->put("/prompts/{$prompt->id}", [
            'titulo' => 'Intento de modificar',
            'contenido' => 'Nuevo contenido',
            'categoria_id' => $categoria->id,
            'ia_destino' => 'ChatGPT',
        ]);

        $response->assertStatus(403); // Forbidden
    }

    /**
     * Test que la búsqueda funciona correctamente
     */
    public function test_user_can_search_prompts()
    {
        $user = User::factory()->create();
        $categoria = Categoria::first();

        Prompt::create([
            'user_id' => $user->id,
            'titulo' => 'Prompt de SQL',
            'contenido' => 'SELECT * FROM users',
            'categoria_id' => $categoria->id,
            'ia_destino' => 'ChatGPT',
        ]);

        Prompt::create([
            'user_id' => $user->id,
            'titulo' => 'Prompt de Python',
            'contenido' => 'print("Hello")',
            'categoria_id' => $categoria->id,
            'ia_destino' => 'Claude',
        ]);

        $response = $this->actingAs($user)->get('/prompts?search=SQL');
        $response->assertSee('Prompt de SQL');
        $response->assertDontSee('Prompt de Python');
    }

    /**
     * Test que un usuario puede marcar/desmarcar favoritos
     */
    public function test_user_can_favorite_prompt()
    {
        $user = User::factory()->create();
        $categoria = Categoria::first();

        $prompt = Prompt::create([
            'user_id' => $user->id,
            'titulo' => 'Prompt Favorito',
            'contenido' => 'Contenido',
            'categoria_id' => $categoria->id,
            'ia_destino' => 'ChatGPT',
            'es_favorito' => false,
        ]);

        $response = $this->actingAs($user)->post("/prompts/{$prompt->id}/favorito");

        $this->assertDatabaseHas('prompts', [
            'id' => $prompt->id,
            'es_favorito' => true,
        ]);
    }

    /**
     * Test que las rutas requieren autenticación
     */
    public function test_authentication_required()
    {
        $response = $this->get('/prompts');
        $response->assertRedirect('/login');
    }
}
