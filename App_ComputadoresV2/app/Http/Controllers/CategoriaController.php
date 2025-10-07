<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {

        $categorias = \App\Models\Categoria::with('computadores')->get();
        return view('categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:categorias,nombre|max:100',
            'descripcion' => 'nullable|max:255',
            'proveedor' => 'nullable|max:100',
            'prioridad' => 'integer|min:1|max:5',
            'estado' => 'boolean'
        ]);

        Categoria::create($request->all());
        return redirect()->back()->with('success', 'Categoría creada correctamente');
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());
        return redirect()->back()->with('success', 'Categoría actualizada');
    }

    public function destroy($id)
    {
        Categoria::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Categoría eliminada');
    }

    public function activasConComputadores()
    {
        return Categoria::where('estado', true)
            ->with('computadores')
            ->get();
    }
}
