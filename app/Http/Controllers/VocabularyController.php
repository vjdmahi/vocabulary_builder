<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vocabulary;
use App\Http\Requests\StoreVocabularyRequest;
use GuzzleHttp\Client;

class VocabularyController extends Controller
{
    // Display a list of vocabularies
    public function index(Request $request)
    {
        $query = Vocabulary::query();

        if ($request->has('search')) {
            $query->where('word', 'like', '%' . $request->search . '%')
                  ->orWhere('meaning', 'like', '%' . $request->search . '%');
        }

        $vocabularies = $query->get();
        return view('vocabularies.index', compact('vocabularies'));
    }

    // Dashboard view
    public function dashboard()
    {
        $totalWords = Vocabulary::count();
        $recentWords = Vocabulary::latest()->take(5)->get();
        return view('dashboard', compact('totalWords', 'recentWords'));
    }

    // Flashcards view
    public function flashcards()
    {
        $vocabularies = Vocabulary::inRandomOrder()->get();
        return view('vocabularies.flashcards', compact('vocabularies'));
    }

    // Quiz view
    public function quiz()
    {
        $correctWord = Vocabulary::inRandomOrder()->first();

        // If no words at all, return view (view will handle empty state)
        if (!$correctWord) {
             return view('vocabularies.quiz', ['correctWord' => null, 'options' => []]);
        }

        // Get up to 3 random distractors (if available)
        $distractors = Vocabulary::where('id', '!=', $correctWord->id)
                                ->inRandomOrder()
                                ->take(3)
                                ->get();

        $options = $distractors->push($correctWord)->shuffle();

        return view('vocabularies.quiz', compact('correctWord', 'options'));
    }

    // Show form to create a new vocabulary word
    public function create()
    {
        return view('vocabularies.create');
    }

    // Store new vocabulary word
    public function store(StoreVocabularyRequest $request)
    {
        // Fetch the meaning and example sentences from the API
        try {
            $definitionData = $this->fetchWordDefinition($request->word);

            if ($definitionData && is_array($definitionData)) {
                // Extract the meaning and example sentence
                $meaning = $definitionData[0]['meanings'][0]['definitions'][0]['definition'] ?? 'Meaning not found';
                $example = $definitionData[0]['meanings'][0]['definitions'][0]['example'] ?? 'Example not found';

                // Create the vocabulary entry with the fetched data
                Vocabulary::create([
                    'word' => $request->word,
                    'meaning' => $meaning,
                    'usage_example' => $example,
                    // 'action' => $request->action, // Removed from UI, so we can ignore or set null
                ]);

                return redirect()->route('vocabularies.index')->with('success', 'Vocabulary added successfully!');
            } else {
                 // Fallback or Error if API returns valid JSON but not the expected structure
                 // For now, let's treat it as not found, but we could allow manual entry if we wanted.
                 // Given the user wants it fixed, maybe we should default to "Manual Entry" if API fails?
                 // But the prompt says "fix it" regarding "Unable to fetch".

                 \Illuminate\Support\Facades\Log::warning("API returned unexpected data for word: " . $request->word);
                 return back()->withErrors(['word' => 'Word definition not found in dictionary.']);
            }

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Store Vocabulary Error: " . $e->getMessage());
            return back()->withErrors(['word' => 'An error occurred while fetching the definition.']);
        }
    }

    // Show form to edit an existing vocabulary word
    public function edit(Vocabulary $vocabulary)
    {
        return view('vocabularies.edit', compact('vocabulary'));
    }

    // Update an existing vocabulary word
    public function update(StoreVocabularyRequest $request, Vocabulary $vocabulary)
    {
        $data = $request->validated();

        // If the word has changed, fetch the new definition from the API
        if ($request->word !== $vocabulary->word) {
            try {
                $definitionData = $this->fetchWordDefinition($request->word);

                if ($definitionData && is_array($definitionData)) {
                    // Extract the new meaning and example
                    $meaning = $definitionData[0]['meanings'][0]['definitions'][0]['definition'] ?? 'Meaning not found';
                    $example = $definitionData[0]['meanings'][0]['definitions'][0]['example'] ?? 'Example not found';

                    // Update the data array
                    $data['meaning'] = $meaning;
                    $data['usage_example'] = $example;
                } else {
                    // If word is invalid, return error and do NOT update
                    return back()->withErrors(['word' => 'Word definition not found in dictionary.']);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Update Vocabulary Error: " . $e->getMessage());
                return back()->withErrors(['word' => 'An error occurred while fetching the definition.']);
            }
        }

        $vocabulary->update($data);
        return redirect()->route('vocabularies.index')->with('success', 'Vocabulary updated successfully!');
    }

    // Delete a vocabulary word
    public function destroy(Vocabulary $vocabulary)
    {
        $vocabulary->delete();
        return redirect()->route('vocabularies.index')->with('success', 'Vocabulary deleted successfully!');
    }

    // Fetch word definition from Free Dictionary API
    private function fetchWordDefinition($word)
    {
        $client = new Client();
        $url = "https://api.dictionaryapi.dev/api/v2/entries/en/{$word}";

        try {
            $response = $client->request('GET', $url, ['verify' => false]);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Illuminate\Support\Facades\Log::error("Dictionary API Error: " . $e->getMessage());
            return null;
        }
    }
}
