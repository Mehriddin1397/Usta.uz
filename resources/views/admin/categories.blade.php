@extends('layouts.app')

@section('title', 'Kategoriyalar - Admin')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Kategoriyalar</h1>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Orqaga
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Add Category Form -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Yangi kategoriya qo'shish</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Kategoriya nomi</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Tavsif</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle"></i> Qo'shish
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Categories List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Mavjud kategoriyalar</h5>
                </div>
                <div class="card-body">
                    @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Tavsif</th>
                                        <th>Ustalar soni</th>
                                        <th>O'chirish</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td><strong>{{ $category->name }}</strong></td>
                                            <td>{{ Str::limit($category->description, 50) ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $category->masters_count }}</span>
                                            </td>
                                            <td><form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Rostdan ham o‘chirilsinmi?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $categories->links() }}
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Hozircha kategoriyalar yo'q</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
