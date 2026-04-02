@extends('layouts.app')

@section('content')
<div class="flashcard-container">
    <h2 class="text-center text-dark mb-4">Vocabulary Flashcards</h2>

    @if($vocabularies->isEmpty())
        <div class="alert alert-warning text-center">
            No words found. <a href="{{ route('vocabularies.create') }}">Add some words</a> to start practicing!
        </div>
    @else
        <div class="scene scene--card">
            <div class="card-flip" id="flashcard">
                <div class="card__face card__face--front">
                    <!-- Image Container -->
                    <div class="mb-3" style="width: 100%; height: 250px; overflow: hidden; border-radius: 12px; background-color: #f0f0f0;">
                         <img id="card-image" src="" alt="Word Image" class="img-fluid w-100 h-100 object-fit-cover">
                    </div>
                    <h2 class="word-text mt-2" id="card-word"></h2>
                    <small class="click-hint text-white-50"><i class="fas fa-sync-alt me-1"></i> Click to flip</small>
                </div>
                <div class="card__face card__face--back">
                    <div class="card-content d-flex flex-column h-100 justify-content-center">
                        <div class="mb-3">
                            <p class="meaning-label text-white-50 mb-1">Meaning</p>
                            <p class="meaning-text fw-bold text-white mb-0" id="card-meaning"></p>
                        </div>
                        <hr class="border-white opacity-25 my-3">
                        <div>
                            <p class="example-label text-white-50 mb-1">Example</p>
                            <p class="example-text text-white fst-italic mb-0" id="card-example"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="controls mt-4 d-flex align-items-center gap-3">
            <button class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm" onclick="prevCard()">
                <i class="fas fa-arrow-left me-2"></i> Previous
            </button>
            <span class="text-dark fw-bold fs-5 bg-white px-4 py-2 rounded-pill shadow-sm border" id="card-counter"></span>
            <button class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm" onclick="nextCard()">
                Next <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </div>
    @endif
    
    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-link text-muted">Back to Dashboard</a>
    </div>
</div>

<style>
    .flashcard-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 80px); /* Adjusted for navbar */
        padding: 40px 20px;
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    h2.text-dark {
        color: #fff !important;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    /* Flip Card Styles */
    .scene {
        width: 100%;
        max-width: 500px;
        height: 500px; /* Increased height for image */
        perspective: 1000px;
    }

    .card-flip {
        width: 100%;
        height: 100%;
        transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        cursor: pointer;
        position: relative;
    }

    .card-flip.is-flipped {
        transform: rotateY(180deg);
    }

    .card__face {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        overflow: hidden;
    }

    .card__face--front {
        background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 100%);
        border: 1px solid rgba(255,255,255,0.5);
    }

    .card__face--back {
        background: linear-gradient(135deg, #6c5ce7 0%, #8e7ce6 100%);
        transform: rotateY(180deg);
        color: white;
    }

    .word-text {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2d3436;
        text-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin: 0;
        text-transform: capitalize;
    }
    
    .meaning-label, .example-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 600;
    }
    
    .meaning-text {
        font-size: 1.5rem;
        line-height: 1.4;
    }

    .example-text {
        font-size: 1.1rem;
        line-height: 1.5;
        opacity: 0.9;
    }

    .click-hint {
        position: absolute;
        bottom: 25px;
        font-size: 0.9rem;
        color: #b2bec3 !important;
        font-weight: 500;
    }

    .object-fit-cover {
        object-fit: cover;
    }
</style>

<script>
    const vocabularies = @json($vocabularies ?? []);
    let currentIndex = 0;
    const card = document.getElementById('flashcard');
    
    // Array of beautiful, distinct gradients
    const gradients = [
        ['linear-gradient(135deg, #ffffff 0%, #f3f4f6 100%)', 'linear-gradient(135deg, #6c5ce7 0%, #8e7ce6 100%)'], // Default (White / Purple)
        ['linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%)', 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'], // Light Blue-Purple / Blue
        ['linear-gradient(135deg, #fad0c4 0%, #ffd1ff 100%)', 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%)'], // Pink / Darker Pink
        ['linear-gradient(135deg, #cfd9df 0%, #e2ebf0 100%)', 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'], // Grey / Deep Purple
        ['linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%)', 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)'], // White / Green
        ['linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%)', 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)'], // Light Blue / Orange-Pink
        ['linear-gradient(135deg, #fee140 0%, #fa709a 100%)', 'linear-gradient(135deg, #0ba360 0%, #3cba92 100%)'], // yellow-pink / green
    ];

    function updateCard() {
        if (vocabularies.length === 0) return;
        
        const currentVocab = vocabularies[currentIndex];
        const cardImage = document.getElementById('card-image');
        
        // Update Content
        document.getElementById('card-word').textContent = currentVocab.word;
        document.getElementById('card-meaning').textContent = currentVocab.meaning;
        document.getElementById('card-example').textContent = currentVocab.usage_example || 'No example provided.';
        
        // Dynamic Image
        const encodedWord = encodeURIComponent(currentVocab.word);
        // Using LoremFlickr for reliable keyword-based photos
        // Added timestamp to prevent caching when switching words
        cardImage.src = `https://loremflickr.com/500/400/${encodedWord}?lock=${currentIndex}`;
        
        // Placeholder on error
        cardImage.onerror = function() {
            this.onerror = null;
            this.src = `https://placehold.co/500x400?text=${currentVocab.word.charAt(0).toUpperCase()}`;
        };

        document.getElementById('card-counter').textContent = `${currentIndex + 1} / ${vocabularies.length}`;
        
        // Change Colors
        // Use index modulo length to cycle through colors consistently, or use random
        // Let's use random for "fun" or based on index for consistency. User said "change colors" so cycle is safe.
        const colorIndex = currentIndex % gradients.length;
        const [frontGradient, backGradient] = gradients[colorIndex];
        
        document.querySelector('.card__face--front').style.background = frontGradient;
        document.querySelector('.card__face--back').style.background = backGradient;

        // Reset Flip
        card.classList.remove('is-flipped');
    }

    function nextCard() {
        if (currentIndex < vocabularies.length - 1) {
            currentIndex++;
            updateCard();
        } else {
            currentIndex = 0; // Loop back
            updateCard();
        }
    }

    function prevCard() {
        if (currentIndex > 0) {
            currentIndex--;
            updateCard();
        } else {
            currentIndex = vocabularies.length - 1; // Loop to end
            updateCard();
        }
    }

    if (card) {
        card.addEventListener('click', function() {
            card.classList.toggle('is-flipped');
        });
        
        // Initialize
        updateCard();
    }
</script>
@endsection
