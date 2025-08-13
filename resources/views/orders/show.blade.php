@extends('layouts.app')

@section('title', 'Buyurtma #' . $order->id)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Buyurtma #{{ $order->id }}</h1>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Orqaga
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <!-- Order Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Buyurtma tafsilotlari</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Status:</strong></div>
                        <div class="col-sm-9">
                            @switch($order->status)
                                @case('pending')
                                    <span class="badge bg-warning">Kutilmoqda</span>
                                    @break
                                @case('accepted')
                                    <span class="badge bg-info">Qabul qilindi</span>
                                    @break
                                @case('in_progress')
                                    <span class="badge bg-primary">Jarayonda</span>
                                    @break
                                @case('completed')
                                    <span class="badge bg-success">Tugallandi</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">Bekor qilindi</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Yaratilgan:</strong></div>
                        <div class="col-sm-9">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                    </div>
                    @if($order->updated_at != $order->created_at)
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>Yangilangan:</strong></div>
                            <div class="col-sm-9">{{ $order->updated_at->format('d.m.Y H:i') }}</div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-3"><strong>Tavsif:</strong></div>
                        <div class="col-sm-9">{{ $order->description }}</div>
                    </div>
                </div>
            </div>

            <!-- Completion Details -->
            @if($order->status === 'completed' && ($order->completion_notes || $order->completion_media))
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Ish tugallandi</h5>
                    </div>
                    <div class="card-body">
                        @if($order->completion_notes)
                            <div class="mb-3">
                                <strong>Usta izohi:</strong>
                                <p>{{ $order->completion_notes }}</p>
                            </div>
                        @endif
                        
                        @if($order->completion_media)
                            <div class="mb-3">
                                <strong>Tugallangan ish rasmlari:</strong>
                                <div class="row mt-2">
                                    @foreach($order->completion_media as $media)
                                        <div class="col-md-4 mb-2">
                                            @if(Str::contains($media, ['.jpg', '.jpeg', '.png', '.gif']))
                                                <img src="{{ asset('storage/' . $media) }}" 
                                                     class="img-fluid rounded" 
                                                     style="height: 200px; object-fit: cover; width: 100%;"
                                                     alt="Tugallangan ish">
                                            @elseif(Str::contains($media, ['.mp4', '.mov', '.avi']))
                                                <video controls class="w-100 rounded" style="height: 200px;">
                                                    <source src="{{ asset('storage/' . $media) }}" type="video/mp4">
                                                </video>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Review -->
            @if($order->review)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Sizning bahongiz</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $order->review->rating)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-muted"></i>
                                @endif
                            @endfor
                            <span class="ms-2">{{ $order->review->rating }}/5</span>
                        </div>
                        @if($order->review->comment)
                            <p>{{ $order->review->comment }}</p>
                        @endif
                        @if($order->review->media_paths)
                            <div class="row">
                                @foreach($order->review->media_paths as $media)
                                    <div class="col-md-3 mb-2">
                                        <img src="{{ asset('storage/' . $media) }}" 
                                             class="img-fluid rounded" 
                                             style="height: 100px; object-fit: cover; width: 100%;"
                                             alt="Sharh rasmi">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <small class="text-muted">{{ $order->review->created_at->format('d.m.Y H:i') }}</small>
                    </div>
                </div>
            @elseif($order->status === 'completed')
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Ishdan qoniqdingizmi?</h5>
                        <p class="text-muted">Ustani baholang va boshqa foydalanuvchilarga yordam bering</p>
                        <a href="{{ route('orders.review.create', $order) }}" class="btn btn-warning">
                            <i class="bi bi-star"></i> Baholash
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Master Info -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Usta ma'lumotlari</h5>
                </div>
                <div class="card-body text-center">
                    <i class="bi bi-person-circle display-4 text-primary mb-3"></i>
                    <h5>{{ $order->master->user->name }}</h5>
                    <p class="text-muted mb-2">{{ $order->master->category->name }}</p>
                    @if($order->master->user->region)
                        <p class="text-muted mb-3">
                            <i class="bi bi-geo-alt"></i> {{ $order->master->user->region->name }}
                        </p>
                    @endif
                    
                    @if($order->master->rating > 0)
                        <div class="mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $order->master->rating)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-muted"></i>
                                @endif
                            @endfor
                            <div class="small text-muted">{{ number_format($order->master->rating, 1) }} ({{ $order->master->reviews_count }} ta sharh)</div>
                        </div>
                    @endif
                    
                    <a href="{{ route('masters.show', $order->master) }}" class="btn btn-outline-primary">
                        <i class="bi bi-eye"></i> Profilni ko'rish
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
