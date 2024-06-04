<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\ToolIndicator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QuestionController extends Controller
{
    public function index($toolIndicatorId): Response
    {
        $questions = ToolIndicator::with('questions')->findOrFail($toolIndicatorId);
        return Inertia::render('Question/Index', compact('questions'));
    }

    public function store(Request $request, $toolIndicatorId)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $toolIndicator = ToolIndicator::findOrFail($toolIndicatorId);
        $toolIndicator->questions()->create($validated);

        return redirect()->route('questions.index', $toolIndicatorId)
            ->with('toast', ['Pregunta creada exitosamente!', 'success']);
    }

    public function destroy($questionId)
    {
        $question = Question::findOrFail($questionId);
        $question->delete();

        return redirect()->back()->with('toast', ['Pregunta eliminada exitosamente!', 'success']);
    }
}
