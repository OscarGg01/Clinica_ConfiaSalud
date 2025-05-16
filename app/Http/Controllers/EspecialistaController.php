<?php

namespace App\Http\Controllers;

use App\Models\Especialista;
use App\Models\Area;
use Illuminate\Http\Request;

class EspecialistaController extends Controller
{
    public function index()
    {
        $list = Especialista::with('area')->get();
        return view('admin.especialistas.index', compact('list'));
    }

    public function create()
    {
        $areas = Area::all();
        return view('admin.especialistas.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'    => 'required|string',
            'area_id'   => 'required|exists:areas,id',
            'email'     => 'nullable|email',
            'telefono'  => 'nullable|string',
        ]);
        Especialista::create($data);
        return redirect()->route('especialistas.index')
                         ->with('success','Especialista creado.');
    }

    public function edit(Especialista $especialista)
    {
        $areas = Area::all();
        return view('admin.especialistas.edit', compact('especialista','areas'));
    }

    public function update(Request $request, Especialista $especialista)
    {
        $data = $request->validate([
            'nombre'    => 'required|string',
            'area_id'   => 'required|exists:areas,id',
            'email'     => 'nullable|email',
            'telefono'  => 'nullable|string',
        ]);
        $especialista->update($data);
        return redirect()->route('especialistas.index')
                         ->with('success','Especialista actualizado.');
    }

    public function destroy(Especialista $especialista)
    {
        $especialista->delete();
        return back()->with('success','Especialista eliminado.');
    }
}
