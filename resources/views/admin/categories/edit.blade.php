@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Edit Category</h2>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
