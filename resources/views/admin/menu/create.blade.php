@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Add New Menu Item</h2>

    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name" class="border w-full p-2 rounded"
                   value="{{ old('name') }}" required>
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

    
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="available" id="available" value="1" {{ old('available', $menuItem->available ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="available">Available</label>
            </div>



        <div class="mb-3">
            <label class="block mb-1 font-medium">Price (₹)</label>
            <input type="number" name="price" step="0.01"
                   class="border w-full p-2 rounded" value="{{ old('price') }}" required>
            @error('price') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description" class="border w-full p-2 rounded"
                      rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="block mb-1 font-medium">Image</label>
            <input type="file" name="image" class="border w-full p-2 rounded">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
        <a href="{{ route('admin.menu.index') }}" class="ml-3 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
