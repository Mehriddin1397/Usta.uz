@extends('layouts.app')

@section('title', $master->user->name . ' - Usta profili')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Master Info -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-person-circle display-1 text-primary"></i>
                    </div>
                    
                    <h3>{{ $master->user->name }}</h3>
                    <p class="text-muted mb-2">
                        <i class="bi bi-briefcase"></i> {{ $master->category->name }}
                    </p>
                    
                    @if($master->user->region)
                        <p class="text-muted mb-2">
                            <i class="bi bi-geo-alt"></i> {{ $master->user->region->name }}
                        </p>
                    @endif

                    @if($master->user->phone)
                        @php
                            $hasActiveOrder = auth()->check() &&
                                auth()->user()->orders()
                                    ->where('master_id', $master->id)
                                    ->whereIn('status', ['accepted', 'in_progress', 'completed'])
                                    ->exists();
                        @endphp

                        @if($hasActiveOrder)
                            <p class="text-muted mb-3">
                                <i class="bi bi-telephone"></i> {{ $master->user->phone }}
                            </p>
                        @else
                            <p class="text-muted mb-3">
                                <i class="bi bi-telephone"></i>
                                <span class="text-warning">Telefon raqami buyurtma berilgandan keyin ko'rinadi</span>
                            </p>
                        @endif
                    @endif
                    
                    <!-- Rating -->
                    <div class="mb-3">
                        @if($master->rating > 0)
                            <div class="d-flex align-items-center justify-content-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $master->rating)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-muted"></i>
                                    @endif
                                @endfor
                                <span class="ms-2">{{ number_format($master->rating, 1) }}</span>
                            </div>
                            <small class="text-muted">{{ $master->reviews_count }} ta sharh</small>
                        @else
                            <span class="text-muted">Hali baholanmagan</span>
                        @endif
                    </div>
                    
                    <!-- Experience -->
                    @if($master->experience_years > 0)
                        <p class="mb-3">
                            <i class="bi bi-calendar-check"></i> 
                            {{ $master->experience_years }} yil tajriba
                        </p>
                    @endif
                    
                    <!-- Contact Button -->
                    @auth
                        @if(auth()->user()->id !== $master->user_id)
                            <a href="{{ route('orders.create', $master) }}" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-send"></i> Ustani yo'llash
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-send"></i> Ustani yo'llash
                        </a>
                    @endauth
                </div>
            </div>
            
            <!-- Description -->
            @if($master->description)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Tavsif</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $master->description }}</p>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Works and Reviews -->
        <div class="col-lg-8">
            <!-- Works -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Ish namunalari ({{ $master->works->count() }})</h5>
                </div>
                <div class="card-body">
                    @forelse($master->works as $work)
                        <div class="border-bottom pb-3 mb-3">
                            <h6>{{ $work->title }}</h6>
                            @if($work->description)
                                <p class="text-muted">{{ $work->description }}</p>
                            @endif
                            
                            @if($work->media_paths)
                                <div class="row">
                                    @foreach($work->media_paths as $media)
                                        <div class="col-md-4 mb-2">
                                            @if(Str::contains($media, ['.jpg', '.jpeg', '.png', '.gif']))
                                                <img src="{{ asset('storage/' . $media) }}"
                                                     class="img-fluid rounded clickable-image"
                                                     style="height: 150px; object-fit: cover; width: 100%; cursor: pointer;"
                                                     alt="Ish namunasi">
                                            @elseif(Str::contains($media, ['.mp4', '.mov', '.avi']))
                                                <video controls class="w-100 rounded" style="height: 150px;">
                                                    <source src="{{ asset('storage/' . $media) }}" type="video/mp4">
                                                </video>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <small class="text-muted">{{ $work->created_at->format('d.m.Y') }}</small>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">Hozircha ish namunalari yo'q</p>
                    @endforelse
                </div>
            </div>
            
            <!-- Reviews -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Sharhlar ({{ $master->reviews->count() }})</h5>
                </div>
                <div class="card-body">
                    @forelse($master->reviews as $review)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6>{{ $review->user->name }}</h6>
                                    <div class="mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @else
                                                <i class="bi bi-star text-muted"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted">{{ $review->created_at->format('d.m.Y') }}</small>
                            </div>
                            
                            @if($review->comment)
                                <p>{{ $review->comment }}</p>
                            @endif
                            
                            @if($review->media_paths)
                                <div class="row">
                                    @foreach($review->media_paths as $media)
                                        <div class="col-md-3 mb-2">
                                            @if(Str::contains($media, ['.jpg', '.jpeg', '.png', '.gif']))
                                                <img src="{{ asset('storage/' . $media) }}"
                                                     class="img-fluid rounded clickable-image"
                                                     style="height: 100px; object-fit: cover; width: 100%; cursor: pointer;"
                                                     alt="Sharh rasmi">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">Hozircha sharhlar yo'q</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
