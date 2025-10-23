@extends('layouts.app')

@section('title', 'Edit Event - Universepedia')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('events.show', $event) }}" class="text-purple-600 hover:text-purple-800 font-semibold">
            ← Back to Event
        </a>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Event</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Event Title *</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title', $event->title) }}"
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
                    @foreach(\App\Models\Event::$types as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $event->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="date" class="block text-gray-700 font-semibold mb-2">Event Date *</label>
                <input 
                    type="date" 
                    name="date" 
                    id="date" 
                    value="{{ old('date', $event->date->format('Y-m-d')) }}"
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
                >{{ old('description', $event->description) }}</textarea>
            </div>

            @if($event->image)
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Current Image</label>
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-64 h-48 object-cover rounded-lg">
                </div>
            @endif

            <div class="mb-6">
                <label for="image" class="block text-gray-700 font-semibold mb-2">New Event Image (Optional)</label>
                <input 
                    type="file" 
                    name="image" 
                    id="image" 
                    accept="image/*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                <p class="text-sm text-gray-500 mt-2">Leave empty to keep current image. Max size: 2MB</p>
            </div>

            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="flex-1 px-6 py-3 gradient-bg text-white rounded-lg hover:opacity-90 transition font-semibold"
                >
                    Update Event
                </button>
                <a 
                    href="{{ route('events.show', $event) }}" 
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
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
@endsection