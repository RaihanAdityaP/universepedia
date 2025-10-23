@extends('layouts.app')

@section('title', 'Create Event - Universepedia')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('events.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
            ← Back to Events
        </a>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Create New Event</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Event Title *</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                >
            </div>

            <div class="mb-6">
                <label for="type" class="block text-gray-700 font-semibold mb-2">Event Type *</label>
                <select 
                    name="type" 
                    id="type" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                >
                    <option value="">Select event type...</option>
                    @foreach(\App\Models\Event::$types as $key => $label)
                        <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="date" class="block text-gray-700 font-semibold mb-2">Event Date *</label>
                <input 
                    type="date" 
                    name="date" 
                    id="date" 
                    value="{{ old('date') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                >
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description *</label>
                <textarea 
                    name="description" 
                    id="description" 
                    class="w-full"
                    required
                >{{ old('description') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="image" class="block text-gray-700 font-semibold mb-2">Event Image (Optional)</label>
                <input 
                    type="file" 
                    name="image" 
                    id="image" 
                    accept="image/*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                <p class="text-sm text-gray-500 mt-2">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF</p>
            </div>

            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="flex-1 px-6 py-3 gradient-bg text-white rounded-lg hover:opacity-90 transition font-semibold"
                >
                    Create Event
                </button>
                <a 
                    href="{{ route('events.index') }}" 
                    class="flex-1 px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-semibold text-center"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
    let editorInstance;
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
        })
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => {
            console.error(error);
        });

    // Ensure CKEditor data is synced before form submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (editorInstance) {
            document.querySelector('#description').value = editorInstance.getData();
        }
    });
</script>
@endpush
@endsection