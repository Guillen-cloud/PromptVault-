<?php

use App\Http\Controllers\PromptController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\CompartidoController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\ConfiguracionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Ruta principal - Redirigir al Dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Cambiar idioma
Route::post('change-language', function (Illuminate\Http\Request $request) {
    $locale = $request->input('locale', 'es');
    $allowedLocales = ['es', 'en', 'es-ar', 'es-mx', 'pt-br', 'fr'];

    if (in_array($locale, $allowedLocales)) {
        // Normalizar locale para Laravel
        $laravelLocale = str_starts_with($locale, 'es') ? 'es' : ($locale === 'pt-br' ? 'pt' : $locale);
        session(['locale' => $laravelLocale]);
        app()->setLocale($laravelLocale);
    }

    return response()->json(['success' => true, 'locale' => $locale]);
})->name('change.language');

// Rutas de Prompts
Route::resource('prompts', PromptController::class);

// Rutas adicionales para Prompts
Route::post('prompts/{prompt}/use', [PromptController::class, 'use'])->name('prompts.use');
Route::patch('prompts/{prompt}/toggle-favorite', [PromptController::class, 'toggleFavorite'])->name('prompts.toggleFavorite');
Route::post('prompts/{prompt}/favorito', [PromptController::class, 'toggleFavorito'])->name('prompts.favorito');
Route::get('prompts/{prompt}/copy', [PromptController::class, 'copy'])->name('prompts.copy');

// Rutas de Categorías
Route::resource('categorias', CategoriaController::class);

// Rutas de Etiquetas
Route::resource('etiquetas', EtiquetaController::class);

// Rutas de Versiones
Route::resource('versiones', VersionController::class);
Route::get('versiones/{version}/show', [VersionController::class, 'show'])->name('versiones.show');
Route::get('versiones/{version}/compare', [VersionController::class, 'compare'])->name('versiones.compare');
Route::post('versiones/{version}/restore', [VersionController::class, 'restore'])->name('versiones.restore');

// Rutas de Compartidos
Route::resource('compartidos', CompartidoController::class);

// Rutas de Actividad
Route::get('/actividad', [ActividadController::class, 'index'])->name('actividad.index');

// Rutas de Configuración
Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
Route::patch('/configuracion/perfil', [ConfiguracionController::class, 'updateProfile'])->name('configuracion.updateProfile');
Route::patch('/configuracion/preferencias', [ConfiguracionController::class, 'updatePreferences'])->name('configuracion.updatePreferences');
Route::patch('/configuracion/notificaciones', [ConfiguracionController::class, 'updateNotifications'])->name('configuracion.updateNotifications');
Route::patch('/configuracion/password', [ConfiguracionController::class, 'updatePassword'])->name('configuracion.updatePassword');
Route::post('/configuracion/export', [ConfiguracionController::class, 'export'])->name('configuracion.export');

// Ruta de Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
