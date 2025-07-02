<?php

namespace App\Http\Controllers;

use App\Models\TechnicalTerm;
use Illuminate\Http\Request;

class TechnicalTermController extends Controller
{
    public function index()
    {
        $terms = TechnicalTerm::orderBy('term')->paginate(20);
        return view('glossary.index', compact('terms'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $terms = TechnicalTerm::where('term', 'LIKE', "%{$query}%")
            ->orWhere('definition_en', 'LIKE', "%{$query}%")
            ->orWhere('definition_id', 'LIKE', "%{$query}%")
            ->paginate(20);
        
        return view('glossary.index', compact('terms', 'query'));
    }

    public function show(TechnicalTerm $term)
    {
        return view('glossary.show', compact('term'));
    }

    public function create()
    {
        return view('glossary.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'term' => 'required|unique:technical_terms|max:255',
            'definition_en' => 'required',
            'definition_id' => 'required',
            'category' => 'required',
            'usage_example' => 'required|array',
            'pronunciation' => 'nullable|max:255'
        ]);

        TechnicalTerm::create($validated);

        return redirect()->route('glossary.index')
            ->with('success', 'Term added successfully.');
    }

    public function edit(TechnicalTerm $term)
    {
        return view('glossary.edit', compact('term'));
    }

    public function update(Request $request, TechnicalTerm $term)
    {
        $validated = $request->validate([
            'term' => 'required|max:255|unique:technical_terms,term,' . $term->id,
            'definition_en' => 'required',
            'definition_id' => 'required',
            'category' => 'required',
            'usage_example' => 'required|array',
            'pronunciation' => 'nullable|max:255'
        ]);

        $term->update($validated);

        return redirect()->route('glossary.index')
            ->with('success', 'Term updated successfully.');
    }

    public function destroy(TechnicalTerm $term)
    {
        $term->delete();
        return redirect()->route('glossary.index')
            ->with('success', 'Term deleted successfully.');
    }
} 