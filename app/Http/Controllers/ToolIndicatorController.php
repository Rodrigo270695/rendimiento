<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\Tool;
use App\Models\ToolIndicator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ToolIndicatorController extends Controller
{
    public function index($toolId = null): Response
    {
        $toolIndicators = ToolIndicator::with('indicator', 'tool')->where('tool_id', $toolId)->get();
        $tool = Tool::where('id', $toolId)->first();
        $indicators = Indicator::where('status', 1)->get();

        return Inertia::render('File/Index', compact('toolIndicators', 'indicators','tool'));
    }

    public function store(Request $request, $toolId)
    {
        $validated = $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
        ]);

        $tool = Tool::findOrFail($toolId);

        $existingAssociation = $tool->indicators()->where('indicator_id', $validated['indicator_id'])->exists();
        if ($existingAssociation) {
            return redirect()->route('toolIndicators.index', $toolId)
                ->with('toast', ['este indicador ya existe!', 'danger']);
        }

        $tool->indicators()->attach($validated['indicator_id']);

        return redirect()->route('toolIndicators.index', $toolId)
            ->with('toast', ['Indicador agregado exitosamente!', 'success']);
    }

    public function destroy($toolIndicatorId)
    {
        $toolIndicator = ToolIndicator::findOrFail($toolIndicatorId);
        $toolIndicator->delete();

        return redirect()->route('toolIndicators.index', $toolIndicator->tool_id)
            ->with('toast', ['Indicador eliminado exitosamente!', 'success']);
    }
}
