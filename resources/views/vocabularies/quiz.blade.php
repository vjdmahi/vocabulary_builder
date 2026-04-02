@extends('layouts.app')

@section('content')
<div class="quiz-container">
    <div class="card quiz-card">
        <div class="card-body text-center">
            <h2 class="card-title text-primary mb-4">Quiz Time! 🧠</h2>
            
            @if(!$correctWord)
                <div class="alert alert-warning py-5">
                    <i class="fas fa-exclamation-circle fa-3x mb-3 text-warning"></i>
                    <h4>The vocabulary list is empty!</h4>
                    <p class="mb-4">Please add some words to start the quiz.</p>
                    <a href="{{ route('vocabularies.create') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-plus"></i> Add New Word
                    </a>
                </div>
            @else
                <h4 class="mb-3 text-muted">What is the meaning of?</h4>
                <h1 class="display-4 fw-bold mb-5 text-dark" style="text-shadow: 0 2px 4px rgba(0,0,0,0.1);">"{{ $correctWord->word }}"</h1>

                <form id="quiz-form">
                    <div class="d-grid gap-3">
                        @foreach($options as $option)
                            <button type="button" class="btn btn-light btn-lg btn-option shadow-sm border" onclick="checkAnswer(this, {{ $option->id }}, {{ $correctWord->id }})">
                                <span class="small">{{ Str::limit($option->meaning, 100) }}</span>
                            </button>
                        @endforeach
                    </div>
                </form>

                <div id="result-message" class="mt-4" style="display: none;"></div>
                
                <div class="mt-4" id="next-btn" style="display: none;">
                    <a href="{{ route('vocabularies.quiz') }}" class="btn btn-primary btn-lg">Next Question ➡️</a>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-link text-muted">Exit Quiz</a>
            </div>
        </div>
    </div>
</div>

<style>
    .quiz-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 200px); /* Adjust for navbar and footer */
        padding: 20px;
        position: relative;
        /* Quiz background image */
        background-image: url('https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        border-radius: 15px; /* Optional: adds rounded corners to the container if it has margin */
        margin: 20px;
        overflow: hidden;
    }

    /* Dark overlay for readability */
    .quiz-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5); /* 50% opacity black */
        z-index: 0;
    }

    .quiz-card {
        z-index: 1; /* Ensure card is above the overlay */
        width: 100%;
        max-width: 600px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        border: none;
        background: rgba(255, 255, 255, 0.95); /* Slightly transparent white card */
    }
    .btn-option {
        text-align: left;
        padding: 15px 20px;
        font-size: 1.1rem;
        border-radius: 10px;
        transition: all 0.2s;
        white-space: normal;
    }
    .btn-option:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .btn-correct {
        background-color: #28a745 !important;
        color: white !important;
        border-color: #28a745 !important;
    }
    .btn-wrong {
        background-color: #dc3545 !important;
        color: white !important;
        border-color: #dc3545 !important;
    }
</style>

<script>
    function checkAnswer(btn, optionId, correctId) {
        // Disable all buttons
        const buttons = document.querySelectorAll('.btn-option');
        buttons.forEach(b => b.disabled = true);

        const resultDiv = document.getElementById('result-message');
        const nextBtn = document.getElementById('next-btn');

        if (optionId === correctId) {
            btn.classList.add('btn-correct');
            resultDiv.innerHTML = '<h3 class="text-success">Correct! 🎉</h3>';
            playAudio('correct');
        } else {
            btn.classList.add('btn-wrong');
            resultDiv.innerHTML = '<h3 class="text-danger">Oops! Wrong answer. 😢</h3>';
            
            
        }

        resultDiv.style.display = 'block';
        nextBtn.style.display = 'block';
    }

    function playAudio(type) {
        // Optional: Add sound effects here
    }
</script>
@endsection
