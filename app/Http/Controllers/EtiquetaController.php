<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use Illuminate\Http\Request;

class EtiquetaController extends Controller
{
    public function index()
    {
        $etiquetas = Etiqueta::withCount(['prompts' => function ($query) {
            $query->where('user_id', auth()->id());
        }])->get();
        return view('etiquetas.index', compact('etiquetas'));
    }
}
