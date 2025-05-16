<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Especialista;
use App\Models\EspecialistaHorario;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Ejemplo para listar especialistas
    public function indexEspecialistas()
    {
        $list = Especialista::with('area')->get();
        return view('admin.especialistas.index', compact('list'));
    }
    // create, store, edit, update, destroy: implementa CRUD similar
    // Para Áreas y Horarios haz lo propio
}
