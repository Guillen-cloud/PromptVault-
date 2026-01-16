<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsistenteController extends Controller
{
    /**
     * Procesar mensaje del asistente IA
     */
    public function chat(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:1000',
            'contexto' => 'nullable|string'
        ]);

        $mensaje = $request->input('mensaje');
        $contexto = $request->input('contexto', 'general');

        try {
            // Sistema de prompts según contexto
            $systemPrompt = $this->getSystemPrompt($contexto);

            // OPCIÓN 1: OpenAI API (comentado por defecto)
            /*
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $mensaje]
                ],
                'temperature' => 0.7,
                'max_tokens' => 500
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $respuesta = $data['choices'][0]['message']['content'] ?? 'No pude generar una respuesta.';
                
                return response()->json([
                    'success' => true,
                    'respuesta' => $respuesta
                ]);
            }
            */

            // OPCIÓN 2: Google Gemini API (gratuita - ACTIVO)
            $apiKey = env('GEMINI_API_KEY');

            // Si no hay API key, usar modo demo
            if (!$apiKey) {
                $respuesta = $this->getRespuestaDemo($mensaje, $contexto);
                return response()->json([
                    'success' => true,
                    'respuesta' => $respuesta,
                    'demo' => true
                ]);
            }

            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::timeout(30)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $systemPrompt . "\n\nUsuario: " . $mensaje]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'topK' => 40,
                        'topP' => 0.95,
                        'maxOutputTokens' => 1024,
                    ]
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                $respuesta = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No pude generar una respuesta.';

                return response()->json([
                    'success' => true,
                    'respuesta' => $respuesta,
                    'provider' => 'gemini'
                ]);
            }

            // Si falla la API, usar modo demo como fallback
            Log::warning('Gemini API falló, usando modo demo. Status: ' . $response->status());
            $respuesta = $this->getRespuestaDemo($mensaje, $contexto);

            return response()->json([
                'success' => true,
                'respuesta' => $respuesta,
                'demo' => true,
                'fallback' => true
            ]);
        } catch (\Exception $e) {
            Log::error('Error en AsistenteController: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Lo siento, tuve un problema al procesar tu solicitud. Por favor intenta de nuevo.'
            ], 500);
        }
    }

    /**
     * Obtener prompt del sistema según contexto
     */
    private function getSystemPrompt($contexto)
    {
        $prompts = [
            'general' => 'Eres un asistente experto en ingeniería de prompts. Tu trabajo es ayudar a los usuarios a crear, mejorar y optimizar prompts para IAs como ChatGPT, Claude, Gemini, etc. Proporciona respuestas claras, concisas y prácticas. Si te piden generar un prompt, hazlo en español y bien estructurado.',

            'generar' => 'Eres un generador experto de prompts. Cuando el usuario te describa lo que necesita, genera un prompt profesional, claro y efectivo. Incluye variables entre llaves {} cuando sea apropiado. El prompt debe ser específico y dar buenos resultados.',

            'optimizar' => 'Eres un optimizador de prompts. Analiza el prompt del usuario y sugiere mejoras específicas en estructura, claridad, especificidad y efectividad. Proporciona la versión mejorada del prompt.',

            'ayuda' => 'Eres un tutor de ingeniería de prompts. Explica conceptos, mejores prácticas y responde dudas sobre cómo escribir mejores prompts. Usa ejemplos cuando sea útil.'
        ];

        return $prompts[$contexto] ?? $prompts['general'];
    }

    /**
     * Respuestas demo sin API (para testing)
     */
    private function getRespuestaDemo($mensaje, $contexto)
    {
        $mensajeLower = strtolower($mensaje);

        // Generar prompts
        if (str_contains($mensajeLower, 'generar') || str_contains($mensajeLower, 'crea') || str_contains($mensajeLower, 'dame un prompt')) {
            if (str_contains($mensajeLower, 'email') || str_contains($mensajeLower, 'correo')) {
                return "📧 **Prompt para Email Marketing:**\n\n```\nActúa como un copywriter experto en email marketing. Crea un email persuasivo para {OBJETIVO} dirigido a {AUDIENCIA}.\n\n**Estructura:**\n1. Asunto atractivo (máx 50 caracteres)\n2. Saludo personalizado\n3. Hook inicial (despertar interés)\n4. Cuerpo del mensaje (beneficios clave)\n5. Call-to-action claro y urgente\n6. P.D. con incentivo adicional\n\n**Tono:** {TONO} (profesional/casual/amigable)\n**Objetivo:** {OBJETIVO}\n**Longitud:** {PALABRAS} palabras aprox.\n```\n\n💡 **Tip:** Usa variables para personalizar el prompt a diferentes campañas.";
            }

            if (str_contains($mensajeLower, 'código') || str_contains($mensajeLower, 'programación')) {
                return "💻 **Prompt para Generación de Código:**\n\n```\nActúa como un desarrollador senior experto en {LENGUAJE}. Necesito que escribas código limpio y bien documentado para:\n\n**Requisito:** {DESCRIPCIÓN}\n\n**Especificaciones:**\n- Lenguaje: {LENGUAJE}\n- Framework: {FRAMEWORK}\n- Funcionalidad: {FUNCIONALIDAD}\n- Manejo de errores: Sí\n- Comentarios: En español\n- Mejores prácticas: Aplicar\n\n**Output esperado:**\n1. Código completo y funcional\n2. Explicación breve de la lógica\n3. Ejemplos de uso\n4. Tests básicos (opcional)\n```\n\n✨ Esta estructura asegura código de calidad.";
            }

            return "✨ **Prompt Genérico:**\n\n```\nActúa como un {ROL_EXPERTO}. Tu tarea es {TAREA_PRINCIPAL}.\n\n**Contexto:** {CONTEXTO}\n**Objetivo:** {OBJETIVO}\n**Audiencia:** {AUDIENCIA}\n**Tono:** {TONO}\n**Formato:** {FORMATO}\n\n**Instrucciones específicas:**\n1. {INSTRUCCIÓN_1}\n2. {INSTRUCCIÓN_2}\n3. {INSTRUCCIÓN_3}\n\n**Restricciones:**\n- {RESTRICCIÓN_1}\n- {RESTRICCIÓN_2}\n```\n\n💡 Personaliza las variables según tu necesidad.";
        }

        // Optimizar prompts
        if (str_contains($mensajeLower, 'optimizar') || str_contains($mensajeLower, 'mejorar')) {
            return "🔧 **Claves para Optimizar Prompts:**\n\n1. **Sé específico:** Evita ambigüedades\n2. **Define el rol:** \"Actúa como...\"\n3. **Contexto claro:** Proporciona información relevante\n4. **Estructura:** Usa listas y secciones\n5. **Variables:** Usa {VARIABLE} para reutilización\n6. **Ejemplos:** Muestra el output deseado\n7. **Restricciones:** Define límites claros\n\n📝 **Ejemplo antes/después:**\n\n❌ **Antes:** \"Escribe sobre marketing\"\n\n✅ **Después:**\n```\nActúa como un estratega de marketing digital. Crea un plan de contenido para redes sociales enfocado en {PRODUCTO} para {AUDIENCIA}. Incluye: objetivos, tipos de contenido, frecuencia y KPIs.\n```\n\n¿Quieres que optimice un prompt específico?";
        }

        // Ayuda general
        if (str_contains($mensajeLower, 'ayuda') || str_contains($mensajeLower, 'cómo') || str_contains($mensajeLower, '?')) {
            return "🤖 **¡Hola! Soy tu Asistente IA de PromptVault**\n\nPuedo ayudarte con:\n\n✨ **Generar prompts** - Dime qué necesitas y creo un prompt profesional\n🔧 **Optimizar prompts** - Mejoro tus prompts existentes\n💡 **Mejores prácticas** - Te enseño a escribir mejores prompts\n📝 **Responder dudas** - Pregunta sobre ingeniería de prompts\n\n**Ejemplos de lo que puedes pedirme:**\n- \"Genera un prompt para análisis de datos\"\n- \"Cómo mejorar este prompt: [tu prompt]\"\n- \"Qué son las variables en prompts?\"\n- \"Dame un prompt para redes sociales\"\n\n💬 **¿En qué te ayudo hoy?**";
        }

        // Variables
        if (str_contains($mensajeLower, 'variable')) {
            return "🔤 **Variables en Prompts:**\n\nLas variables son **marcadores de posición** que se reemplazan con valores específicos.\n\n**Sintaxis:** `{NOMBRE_VARIABLE}`\n\n**Ejemplo:**\n```\nGenera un título SEO para {TEMA} en {IDIOMA}\nque incluya {PALABRA_CLAVE} y tenga máximo\n{CARACTERES} caracteres.\n```\n\n**Beneficios:**\n✅ Reutilización del mismo prompt\n✅ Personalización rápida\n✅ Organización clara\n✅ Escalabilidad\n\n**Variables comunes:**\n- {TEMA} / {TÓPICO}\n- {AUDIENCIA} / {PÚBLICO}\n- {TONO} / {ESTILO}\n- {FORMATO} / {TIPO}\n- {IDIOMA}\n- {LONGITUD}\n\n💡 Usa MAYÚSCULAS para distinguirlas del texto normal.";
        }

        // Respuesta por defecto
        return "👋 Hola! Soy tu asistente de prompts.\n\nPuedo ayudarte a:\n• **Generar** nuevos prompts desde cero\n• **Optimizar** tus prompts existentes\n• **Explicar** mejores prácticas\n• **Resolver** dudas sobre ingeniería de prompts\n\n💬 Escribe algo como:\n- \"Genera un prompt para [tu necesidad]\"\n- \"Cómo mejoro este prompt: [tu prompt]\"\n- \"Explícame sobre [tema de prompts]\"\n\n¿En qué te ayudo? 😊";
    }
}
