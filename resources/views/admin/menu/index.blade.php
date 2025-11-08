@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Menu Items</h2>
        <a href="{{ route('admin.menu.create') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded">+ Add New</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-3">{{ session('success') }}</div>
    @endif

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border p-2">#</th>
                <th class="border p-2">Name</th>
                <th class="border p-2">Category</th>
                <th class="border p-2">Price</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menuItems as $item)
                <tr>
                    <td class="border p-2">{{ $item->id }}</td>
                    <td class="border p-2">{{ $item->name }}</td>
                    <td class="border p-2">{{ $item->category->name ?? '—' }}</td>
                    <td class="border p-2">₹{{ $item->price }}</td>
                    <td class="border p-2">
                        <a href="{{ route('admin.menu.edit', $item->id) }}" class="text-blue-600">Edit</a> |
                        <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600"
                                    onclick="return confirm('Delete item?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center p-4">No menu items yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
