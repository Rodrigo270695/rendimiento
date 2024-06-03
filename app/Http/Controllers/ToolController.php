<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToolRequest;
use App\Models\Tool;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ToolController extends Controller
{
    public function index(): Response
    {
        $tools = Tool::orderBy('id', 'desc')->paginate(7);
        return Inertia::render('Tool/Index', compact('tools'));
    }

    public function store(ToolRequest $request): RedirectResponse
    {
        try {
            Tool::create($request->all());
            return redirect()->route('tools.index')->with('toast', ['Herramienta creada exitosamente!', 'success']);
        } catch (QueryException $e) {
            return redirect()->back()->with('toast', ['Ocurrió un error!', 'danger']);
        }
    }

    public function update(ToolRequest $request, Tool $tool): RedirectResponse
    {
        try {
            $tool->update($request->all());
            return redirect()->route('tools.index')->with('toast', ['Herramienta actualizada exitosamente!', 'success']);
        } catch (QueryException $e) {
            return redirect()->back()->with('toast', ['Ocurrió un error!', 'danger']);
        }
    }

    public function destroy(Tool $tool)
    {
        try {
            $tool->delete();
            return redirect()->route('tools.index')->with('toast', ['Herramienta eliminada exitosamente!', 'success']);
        } catch (QueryException $e) {
            return redirect()->back()->with('toast', ['No se pudo eliminar la herramienta!', 'danger']);
        }
    }

    public function change(Tool $tool): RedirectResponse
    {
        $tool->status = !$tool->status;
        $tool->save();
        return redirect()->route('tools.index')->with('toast', ['Cambio de estado exitosamente!', 'success']);
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

        $tools = Tool::where('name', 'like', '%' . $texto . '%')
            ->orWhere('status', $estado)
            ->orderBy("id", "desc")
            ->paginate(7)
            ->appends(['texto' => $texto]);

        return Inertia::render('Tool/Index', compact('tools', 'texto'));
    }
}
