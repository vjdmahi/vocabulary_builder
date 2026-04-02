@extends('layouts.app')

@section('content')
<div class="add-vocab-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <!-- Left Side: Image -->
                        <div class="col-md-6 d-none d-md-block position-relative" style="min-height: 400px; background-color: #2d3436;">
                            <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                 alt="Library and Books" 
                                 class="img-fluid h-100 w-100 object-fit-cover" 
                                 style="position: absolute; top:0; left:0;"
                                 onerror="this.style.display='none'; this.parentElement.style.background='linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%)'">
                            <div class="position-absolute top-0 start-0 w-100 h-100" 
                                 style="background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.6));"></div>
                            <div class="position-absolute bottom-0 start-0 p-4 text-white">
                                <h4 class="fw-bold text-shadow">Expand Your World</h4>
                                <p class="small text-shadow-sm opacity-90">"One word at a time."</p>
                            </div>
                        </div>

                        <!-- Right Side: Form -->
                        <div class="col-md-6 bg-white">
                            <div class="card-body p-5">
                                <div class="text-center mb-4">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-pen-fancy fa-lg"></i>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-0">Add New Word</h3>
                                    <p class="text-muted small">Build your personal dictionary</p>
                                </div>
                                
                                <form action="{{ route('vocabularies.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="word" class="form-label fw-bold text-uppercase text-muted small" style="font-size: 0.75rem; letter-spacing: 1px;">Vocabulary Word</label>
                                        <div class="input-group input-group-lg border rounded-3 overflow-hidden focus-ring">
                                            <span class="input-group-text bg-white border-0 text-muted ps-3">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" name="word" class="form-control border-0 ps-2" id="word" placeholder="Type a word..." required style="font-weight: 500;">
                                            <button type="button" class="btn btn-white border-0 border-start text-primary" onclick="speakWord()" title="Listen">
                                                <i class="fas fa-volume-up"></i>
                                            </button>
                                        </div>
                                        <div class="d-flex align-items-center mt-2 text-success small">
                                            <i class="fas fa-check-circle me-1"></i>
                                            <span>Auto-fetch enabled: Meaning & Examples</span>
                                        </div>
                                        @error('word')
                                            <div class="text-danger small mt-1">
                                                <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="d-grid mb-4">
                                        <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold shadow-sm transition-hover">
                                            Add Word to List
                                        </button>
                                    </div>
                                    
                                    <div class="text-center">
                                        <a href="{{ route('vocabularies.index') }}" class="text-decoration-none text-muted small hover-primary">
                                            <i class="fas fa-arrow-left me-1"></i> Cancel & Return
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .add-vocab-container {
        /* Soft background to let the card pop */
        background-color: #f3f4f6;
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        padding: 20px 0;
    }
    
    .object-fit-cover {
        object-fit: cover;
    }
    
    .text-shadow {
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    
    .text-shadow-sm {
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }
    
    .focus-ring:focus-within {
        box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.25);
        border-color: #6c5ce7 !important;
    }
    
    .transition-hover {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .transition-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3) !important;
    }
    
    .hover-primary:hover {
        color: #6c5ce7 !important;
    }
</style>

<script>
    function speakWord() {
        const word = document.getElementById('word').value;
        if (word) {
            const speech = new SpeechSynthesisUtterance(word);
            window.speechSynthesis.speak(speech);
        } else {
            const input = document.getElementById('word');
            input.focus();
            input.parentElement.classList.add('border-danger');
            setTimeout(() => input.parentElement.classList.remove('border-danger'), 2000);
        }
    }
</script>
@endsection
