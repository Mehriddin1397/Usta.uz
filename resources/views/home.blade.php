@extends('layouts.app')

@section('title', 'Bosh sahifa')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Eng yaxshi ustalarni toping</h1>
                <p class="lead mb-4">Ustalar24.uz orqali o'z hududingizdagi malakali ustalarni toping va ularning ishlarini ko'ring</p>
            </div>
            <div class="col-lg-6">
                <!-- Search Form -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-dark">Usta qidirish</h5>
                        <form method="GET" action="{{ route('home') }}">
                            <div class="mb-3">
                                <label for="search" class="form-label text-dark">Qidiruv</label>
                                <input type="text" class="form-control" id="search" name="search"
                                       value="{{ request('search') }}" placeholder="Usta yoki kasb nomi...">
                            </div>

                            <div class="mb-3">
                                <label for="region_id" class="form-label text-dark">Hudud</label>
                                <select class="form-select" id="region_id" name="region_id">
                                    <option value="">Barcha hududlar</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}"
                                                {{ request('region_id') == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label text-dark">Kasb turi</label>
                                <select class="form-select" id="category_id" name="category_id">
                                    <option value="">Barcha kasblar</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Qidirish
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Results or Featured Masters -->
<section class="py-5">
    <div class="container">
        @if($masters->count() > 0)
            <h2 class="mb-4">Qidiruv natijalari</h2>
            <div class="row">
                @foreach($masters as $master)
                    <div class="col-md-6 col-lg-4 mb-4">
                        @include('partials.master-card', ['master' => $master])
                    </div>
                @endforeach
            </div>

            {{ $masters->links() }}
        @else
            <!-- Featured Masters -->
            <h2 class="mb-4">Tavsiya etilgan ustalar</h2>
            <div class="row">
                @forelse($featuredMasters as $master)
                    <div class="col-md-6 col-lg-4 mb-4">
                        @include('partials.master-card', ['master' => $master])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-tools display-1 text-muted"></i>
                            <h3 class="mt-3">Hozircha ustalar yo'q</h3>
                            <p class="text-muted">Tez orada yangi ustalar qo'shiladi</p>
                        </div>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5">Nega Ustalar24.uz?</h2>
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <i class="bi bi-shield-check display-4 text-primary mb-3"></i>
                <h4>Ishonchli ustalar</h4>
                <p>Barcha ustalar tekshirilgan va tasdiqlangan</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <i class="bi bi-star-fill display-4 text-warning mb-3"></i>
                <h4>Baholash tizimi</h4>
                <p>Haqiqiy mijozlarning sharh va baholari</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <i class="bi bi-geo-alt-fill display-4 text-success mb-3"></i>
                <h4>Yaqin atrofdagi ustalar</h4>
                <p>O'z hududingizdagi eng yaqin ustalarni toping</p>
            </div>
        </div>
    </div>
</section>
@endsection
