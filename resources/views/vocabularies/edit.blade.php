    @extends('layouts.app')

    @section('content')


        <div class="form-section">
        <h1>Edit Vocabulary</h1>
        <form action="{{ route('vocabularies.update', $vocabulary->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="word">Word</label>
                <input type="text" name="word" class="form-control" id="word" value="{{ $vocabulary->word }}" required>
                @error('word')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-light">Update</button>
        </form>
        <a href="{{ route('vocabularies.index') }}" class="btn btn-secondary mt-2">Back to List</a>
    <div>

        <style>
        body {
            background-color: #ccffcc; /* Light green color for the entire background */
        }

        .form-section {
            background: linear-gradient(to bottom, #ccffcc, #96c93d);
            padding: 30px; /* Add padding for better spacing */
            border-radius: 10px; /* Optional: Rounded corners */
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.2); /* Optional: Shadow effect */
            max-width: 600px; /* Adjust the max-width as needed */
            margin: 20px auto; /* Center the section on the page */
        }
        </style>
        @endsection

