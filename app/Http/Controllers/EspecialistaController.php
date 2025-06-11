<?php

namespace App\Http\Controllers;

use App\Models\Especialista;
use App\Models\Area;
use Illuminate\Http\Request;

class EspecialistaController extends Controller
{
    /**
     * Muestra el listado de especialistas.
     */
    public function index()
    {
        $list = Especialista::with('area')->get();
        return view('admin.especialistas.index', compact('list'));
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        $areas = Area::all();
        return view('admin.especialistas.create', compact('areas'));
    }

    /**
     * Valida y almacena un nuevo especialista.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|max:255',
            'area_id'   => 'required|exists:areas,id',
            'email'     => 'nullable|email|max:255',
            'telefono'  => 'nullable|digits:9',
        ]);

        Especialista::create($data);

        return redirect()
            ->route('especialistas.index')
            ->with('success', 'Especialista creado correctamente.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(Especialista $especialista)
    {
        $areas = Area::all();
        return view('admin.especialistas.edit', compact('especialista', 'areas'));
    }

    /**
     * Valida y actualiza un especialista existente.
     */
    public function update(Request $request, Especialista $especialista)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|max:255',
            'area_id'   => 'required|exists:areas,id',
            'email'     => 'nullable|email|max:255',
            'telefono'  => 'nullable|digits:9',
        ]);

        $especialista->update($data);

        return redirect()
            ->route('especialistas.index')
            ->with('success', 'Especialista actualizado correctamente.');
    }

    /**
     * Elimina un especialista.
     */
    public function destroy(Especialista $especialista)
    {
        $especialista->delete();

        return redirect()
            ->route('especialistas.index')
            ->with('success', 'Especialista eliminado correctamente.');
    }
}
