@extends('layouts.app')

@section('title', 'Edit Planet - Universepedia')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('planets.show', $planet) }}" class="text-purple-600 hover:text-purple-800 font-semibold">
            ← Back to Planet
        </a>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Planet</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('planets.update', $planet) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Planet Name *</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name', $planet->name) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                >
            </div>

            <div class="mb-6">
                <label for="size" class="block text-gray-700 font-semibold mb-2">Size *</label>
                <input 
                    type="text" 
                    name="size" 
                    id="size" 
                    value="{{ old('size', $planet->size) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                >
            </div>

            <div class="mb-6">
                <label for="distance" class="block text-gray-700 font-semibold mb-2">Distance from Sun *</label>
                <input 
                    type="text" 
                    name="distance" 
                    id="distance" 
                    value="{{ old('distance', $planet->distance) }}"
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
                >{{ old('description', $planet->description) }}</textarea>
            </div>

            @if($planet->image)
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Current Image</label>
                    <img src="{{ asset('storage/' . $planet->image) }}" alt="{{ $planet->name }}" class="w-64 h-48 object-cover rounded-lg">
                </div>
            @endif

            <div class="mb-6">
                <label for="image" class="block text-gray-700 font-semibold mb-2">New Planet Image (Optional)</label>
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
                    Update Planet
                </button>
                <a 
                    href="{{ route('planets.show', $planet) }}" 
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