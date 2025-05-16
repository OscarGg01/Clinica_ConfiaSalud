<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $list = Area::all();
        return view('admin.areas.index', compact('list'));
    }

    public function create()
    {
        return view('admin.areas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
        ]);
        Area::create($data);
        return redirect()->route('areas.index')
                         ->with('success','Área creada.');
    }

    public function edit(Area $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
        ]);
        $area->update($data);
        return redirect()->route('areas.index')
                         ->with('success','Área actualizada.');
    }

    public function destroy(Area $area)
    {
        $area->delete();
        return back()->with('success','Área eliminada.');
    }
}
