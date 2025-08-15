<div class="card h-100">
    @if($master->works->count() > 0 && $master->works->first()->media_paths)
        @php
            $firstMedia = $master->works->first()->media_paths[0] ?? null;
        @endphp
        @if($firstMedia)
            <img src="{{ asset('storage/' . $firstMedia) }}" class="card-img-top clickable-image" style="height: 200px; object-fit: cover; cursor: pointer;" alt="Ish namunasi">
        @endif
    @else
        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-tools display-4 text-muted"></i>
        </div>
    @endif
    
    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $master->user->name }}</h5>
        <p class="text-muted mb-2">
            <i class="bi bi-briefcase"></i> {{ $master->category->name }}
        </p>
        
        @if($master->user->region)
            <p class="text-muted mb-2">
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
                    <span class="ms-2 text-muted">({{ $master->reviews_count }})</span>
                </div>
            @else
                <span class="text-muted">Hali baholanmagan</span>
            @endif
        </div>
        
        @if($master->description)
            <p class="card-text text-muted small">{{ Str::limit($master->description, 100) }}</p>
        @endif
        
        <div class="mt-auto">
            <a href="{{ route('masters.show', $master) }}" class="btn btn-primary w-100">
                <i class="bi bi-eye"></i> Profilni ko'rish
            </a>
        </div>
    </div>
</div>
