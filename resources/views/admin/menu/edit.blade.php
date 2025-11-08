<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Menu Item
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.menu.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-4">
                    <label for="name" class="block font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $menuItem->name) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Category --}}
                <div class="mb-4">
                    <label for="category_id" class="block font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ $menuItem->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <label for="description" class="block font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $menuItem->description) }}</textarea>
                </div>

                {{-- Price --}}
                <div class="mb-4">
                    <label for="price" class="block font-medium text-gray-700">Price (₹)</label>
                    <input type="number" step="0.01" name="price" id="price" 
                           value="{{ old('price', $menuItem->price) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('price')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Image --}}
                <div class="mb-4">
                    <label for="image" class="block font-medium text-gray-700">Image</label>
                    @if($menuItem->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $menuItem->image) }}" alt="{{ $menuItem->name }}" class="h-24 rounded">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-600">
                    @error('image')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Available --}}
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="available" id="available" 
                           {{ old('available', $menuItem->available) ? 'checked' : '' }}
                           class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="available" class="ml-2 block text-gray-700">Available</label>
                </div>

                <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="available" id="available" value="1" {{ old('available', $menuItem->available ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="available">Available</label>
                </div>


                {{-- Buttons --}}
                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('admin.menu.index') }}" 
                       class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</a>

                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
