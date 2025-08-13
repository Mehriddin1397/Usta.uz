@extends('layouts.app')

@section('title', 'Ustani yo\'llash')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ustani yo'llash</h5>
                </div>
                <div class="card-body">
                    <!-- Master Info -->
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <i class="bi bi-person-circle display-1 text-primary"></i>
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $master->user->name }}</h4>
                            <p class="text-muted mb-1">
                                <i class="bi bi-briefcase"></i> {{ $master->category->name }}
                            </p>
                            @if($master->user->region)
                                <p class="text-muted mb-1">
                                    <i class="bi bi-geo-alt"></i> {{ $master->user->region->name }}
                                </p>
                            @endif
                            <div class="mb-2">
                                @if($master->rating > 0)
                                    <div class="d-flex align-items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $master->rating)
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @else
                                                <i class="bi bi-star text-muted"></i>
                                            @endif
                                        @endfor
                                        <span class="ms-2">{{ number_format($master->rating, 1) }} ({{ $master->reviews_count }} ta sharh)</span>
                                    </div>
                                @else
                                    <span class="text-muted">Hali baholanmagan</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Order Form -->
                    <form method="POST" action="{{ route('orders.store', $master) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="description" class="form-label">Ish tavsifi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5" 
                                      placeholder="Qanday ish bajarishni xohlaysiz? Batafsil yozing..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted">
                                Ish haqida qanchalik batafsil yozsangiz, usta sizga yaxshiroq yordam bera oladi.
                            </small>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Eslatma:</strong> Buyurtma yuborilgandan so'ng usta uni ko'rib chiqadi va javob beradi. 
                            Usta buyurtmani qabul qilgandan so'ng siz bilan bog'lanadi.
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('masters.show', $master) }}" class="btn btn-secondary me-md-2">
                                Bekor qilish
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Buyurtma yuborish
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
