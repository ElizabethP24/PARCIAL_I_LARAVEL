<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Computador;
use App\Http\Requests\StoreComputadorRequest;
use App\Http\Requests\UpdateComputadorRequest;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\Categoria;


class ComputadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        $computadores = Computador::all();
        foreach ($computadores as $c) {
            if ($c->imagen) {
                if (preg_match('/^https?:\/\//', $c->imagen)) {
                    $c->imagen_url = $c->imagen;
                } else {
                    $c->imagen_url = asset('storage/' . $c->imagen);
                }
            } else {
                $c->imagen_url = asset('images/default-computer.png');
            }
        }

        return view('computadores.index', compact('computadores', 'categorias'));
    }

    public function store(StoreComputadorRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('computadores', 'public');
        }

        // Convertir portatil a boolean
        $data['portatil'] = (bool) $data['portatil'];

        Computador::create($data);

        return redirect()->route('computadores.index')->with('success', 'Computador creado correctamente.');
    }

    public function show(Computador $computador)
{
    return $computador->load('categoria');
}

    public function update(UpdateComputadorRequest $request, $id)
{
    $computador = Computador::findOrFail($id);

    $data = $request->validated();

    if ($request->hasFile('imagen')) {
        if ($computador->imagen && !preg_match('/^https?:\/\//', $computador->imagen)) {
            Storage::disk('public')->delete($computador->imagen);
        }
        $data['imagen'] = $request->file('imagen')->store('computadores', 'public');
    }

    // Convertir portatil a boolean
    $data['portatil'] = (bool) $data['portatil'];

    $computador->update($data);

    return redirect()->route('computadores.index')->with('success', 'Computador actualizado correctamente.');
}

public function destroy($id)
{
    $computador = Computador::findOrFail($id);

    if ($computador->imagen && !preg_match('/^https?:\/\//', $computador->imagen)) {
        Storage::disk('public')->delete($computador->imagen);
    }
    $computador->delete();

    return redirect()->route('computadores.index')->with('success', 'Computador eliminado.');
}
    public function exportarPdf()
    {
        $computadores = Computador::all();
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);

        $html = view('computadores.pdf', compact('computadores'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream('computadores.pdf');
    }
}
