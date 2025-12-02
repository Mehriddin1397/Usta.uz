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
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Yangi tuman qo'shish</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.districts.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>Viloyat</label>
                            <select name="region_id" class="form-control" required>
                                <option value="">Viloyatni tanlang</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Tuman nomi</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <button class="btn btn-primary">Qo‘shish</button>
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

                        <div class="accordion" id="regionAccordion">

                            @foreach($regions as $region)
                                <div class="accordion-item mb-2">

                                    <h2 class="accordion-header" id="heading{{ $region->id }}">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $region->id }}"
                                                aria-expanded="false"
                                                aria-controls="collapse{{ $region->id }}">

                                            <span class="me-3">#{{ $region->id }}</span>
                                            <strong>{{ $region->name }}</strong>
                                            <span class="badge bg-primary ms-auto">
                                        {{ $region->users_count }} foydalanuvchi
                                    </span>
                                        </button>
                                    </h2>

                                    <div id="collapse{{ $region->id }}" class="accordion-collapse collapse"
                                         aria-labelledby="heading{{ $region->id }}"
                                         data-bs-parent="#regionAccordion">

                                        <div class="accordion-body">

                                            @if($region->districts->count() > 0)
                                                <ul class="list-group">
                                                    @foreach($region->districts as $district)
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            {{ $district->name }}
                                                            <span class="text-muted"><form action="{{ route('districts.destroy', $district->id) }}" method="POST"
                                                                                           onsubmit="return confirm('Rostdan o‘chirilsinmi?')">
                            @csrf
                                                                    @method('DELETE')
                            <button class="btn btn-danger btn-sm">O‘chirish</button>
                        </form></span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted">Bu viloyatda hali tumanlar yo‘q.</p>
                                            @endif

                                        </div>
                                    </div>

                                </div>
                            @endforeach

                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
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
