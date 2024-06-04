<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndicatorRequest;
use App\Models\Indicator;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class IndicatorController extends Controller
{
    public function index(): Response
    {
        $indicators = Indicator::orderBy('id', 'desc')->paginate(7);
        return Inertia::render('Indicator/Index', compact('indicators'));
    }

    public function store(IndicatorRequest $request): RedirectResponse
    {
        try {
            Indicator::create($request->all());
            return redirect()->route('indicators.index')->with('toast', ['Indicador creado exitosamente!', 'success']);
        } catch (QueryException $e) {
            return redirect()->back()->with('toast', ['Ocurrió un error!', 'danger']);
        }
    }

    public function update(IndicatorRequest $request, Indicator $indicator): RedirectResponse
    {
        try {
            $indicator->update($request->all());
            return redirect()->route('indicators.index')->with('toast', ['Indicador actualizado exitosamente!', 'success']);
        } catch (QueryException $e) {
            return redirect()->back()->with('toast', ['Ocurrió un error!', 'danger']);
        }
    }

    public function destroy(Indicator $indicator)
    {
        try {
            $indicator->delete();
            return redirect()->route('indicators.index')->with('toast', ['Indicador eliminado exitosamente!', 'success']);
        } catch (QueryException $e) {
            return redirect()->back()->with('toast', ['No se pudo eliminar el indicador!', 'danger']);
        }
    }

    public function change(Indicator $indicator): RedirectResponse
    {
        $indicator->status = !$indicator->status;
        $indicator->save();
        return redirect()->route('indicators.index')->with('toast', ['Cambio de estado exitosamente!', 'success']);
    }

    public function search(Request $request): Response
    {
        $texto = $request->get('texto');
        $estado = null;

        if (strtolower($texto) === 'activo') {
            $estado = 1;
        } elseif (strtolower($texto) === 'inactivo') {
            $estado = 0;
        }

        $indicators = Indicator::where('name', 'like', '%' . $texto . '%')
            ->orWhere('status', $estado)
            ->orderBy("id", "desc")
            ->paginate(7)
            ->appends(['texto' => $texto]);

        return Inertia::render('Indicator/Index', compact('indicators', 'texto'));
    }
}
