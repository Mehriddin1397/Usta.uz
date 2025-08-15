@extends('layouts.app')

@section('title', 'Ustani baholash')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ustani baholash</h5>
                </div>
                <div class="card-body">
                    <!-- Master Info -->
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <i class="bi bi-person-circle display-1 text-primary"></i>
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $order->master->user->name }}</h4>
                            <p class="text-muted mb-1">{{ $order->master->category->name }}</p>
                            <p class="text-muted mb-2">Buyurtma #{{ $order->id }}</p>
                            <small class="text-muted">{{ $order->created_at->format('d.m.Y') }}</small>
                        </div>
                    </div>

                    <hr>

                    <!-- Review Form -->
                    <form method="POST" action="{{ route('orders.review.store', $order) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label">Baholang (1-5 yulduz)</label>
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" 
                                           {{ old('rating') == $i ? 'checked' : '' }} required>
                                    <label for="star{{ $i }}" class="star">
                                        <i class="bi bi-star-fill"></i>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">Sharh (ixtiyoriy)</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                      id="comment" 
                                      name="comment" 
                                      rows="4" 
                                      placeholder="Usta haqida fikringizni yozing...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="media" class="form-label">Rasm yuklash (ixtiyoriy)</label>
                            <input type="file" 
                                   class="form-control @error('media.*') is-invalid @enderror" 
                                   id="media" 
                                   name="media[]" 
                                   multiple 
                                   accept="image/*">
                            <small class="text-muted">
                                Tugallangan ish rasmlarini yuklashingiz mumkin
                            </small>
                            @error('media.*')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary me-md-2">
                                Bekor qilish
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-star"></i> Baholash
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.rating-stars {
    display: flex;
    gap: 5px;
}

.rating-stars input[type="radio"] {
    display: none;
}

.rating-stars label {
    cursor: pointer;
    font-size: 2rem;
    color: #ddd;
    transition: color 0.2s;
}

.rating-stars label:hover {
    color: #ffc107;
}

.rating-stars input[type="radio"]:checked ~ label {
    color: #ffc107;
}

/* When a star is checked, highlight it and all previous stars */
.rating-stars input[type="radio"]:checked,
.rating-stars input[type="radio"]:checked ~ input[type="radio"] {
    + label {
        color: #ffc107;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-stars label');
    const radioInputs = document.querySelectorAll('.rating-stars input[type="radio"]');

    // Handle star clicks
    radioInputs.forEach((input, index) => {
        input.addEventListener('change', function() {
            if (this.checked) {
                highlightStars(this.value);
            }
        });
    });

    // Handle star hover
    stars.forEach((star, index) => {
        star.addEventListener('mouseover', function() {
            highlightStars(index + 1);
        });

        star.addEventListener('mouseout', function() {
            const checkedStar = document.querySelector('.rating-stars input[type="radio"]:checked');
            if (checkedStar) {
                highlightStars(checkedStar.value);
            } else {
                highlightStars(0);
            }
        });
    });

    function highlightStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.style.color = '#ffc107';
            } else {
                star.style.color = '#ddd';
            }
        });
    }
});
</script>
@endpush
@endsection
