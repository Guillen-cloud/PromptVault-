<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use Illuminate\Http\Request;

class EtiquetaController extends Controller
{
    public function index()
    {
        $etiquetas = Etiqueta::withCount('prompts')->get();
        return view('etiquetas.index', compact('etiquetas'));
    }
}
