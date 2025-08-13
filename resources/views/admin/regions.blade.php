@extends('layouts.app')

@section('title', 'Hududlar - Admin')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Hududlar</h1>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Orqaga
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Add Region Form -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Yangi hudud qo'shish</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.regions.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Hudud nomi</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masalan: Toshkent shahri"
                                   required>
                            @error('name')
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

        <!-- Regions List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Mavjud hududlar</h5>
                </div>
                <div class="card-body">
                    @if($regions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Foydalanuvchilar soni</th>
                                        <th>Yaratilgan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regions as $region)
                                        <tr>
                                            <td>{{ $region->id }}</td>
                                            <td><strong>{{ $region->name }}</strong></td>
                                            <td>
                                                <span class="badge bg-primary">{{ $region->users_count }}</span>
                                            </td>
                                            <td>{{ $region->created_at->format('d.m.Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $regions->links() }}
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Hozircha hududlar yo'q</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
