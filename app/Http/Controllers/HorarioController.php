<?php

namespace App\Http\Controllers;

use App\Models\EspecialistaHorario as Horario;
use App\Models\Especialista;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        $list = Horario::with('especialista')->get();
        return view('admin.horarios.index', compact('list'));
    }

    public function create()
    {
        $especialistas = Especialista::all();
        return view('admin.horarios.create', compact('especialistas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'especialista_id' => 'required|exists:especialistas,id',
            'hora'            => 'required|date_format:H:i',
        ]);
        Horario::create($data);
        return redirect()->route('horarios.index')
                         ->with('success','Horario agregado.');
    }

    public function edit(Horario $horario)
    {
        $especialistas = Especialista::all();
        return view('admin.horarios.edit', compact('horario','especialistas'));
    }

    public function update(Request $request, Horario $horario)
    {
        $data = $request->validate([
            'especialista_id' => 'required|exists:especialistas,id',
            'hora'            => 'required|date_format:H:i',
        ]);
        $horario->update($data);
        return redirect()->route('horarios.index')
                         ->with('success','Horario actualizado.');
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();
        return back()->with('success','Horario eliminado.');
    }
}
