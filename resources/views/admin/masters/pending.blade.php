@extends('layouts.app')

@section('title', 'Kutilayotgan ustalar - Admin')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Kutilayotgan ustalar</h1>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Orqaga
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tasdiq kutayotgan ustalar</h5>
                </div>
                <div class="card-body">
                    @if($pendingMasters->count() > 0)
                        <div class="row">
                            @foreach($pendingMasters as $master)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $master->user->name }}</h6>
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-envelope"></i> {{ $master->user->email }}
                                            </p>
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-telephone"></i> {{ $master->user->phone ?? 'Kiritilmagan' }}
                                            </p>
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-geo-alt"></i> {{ $master->user->region->name ?? 'Kiritilmagan' }}
                                            </p>
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-briefcase"></i> {{ $master->category->name }}
                                            </p>
                                            <p class="text-muted mb-2">
                                                <i class="bi bi-calendar-check"></i> {{ $master->experience_years }} yil tajriba
                                            </p>
                                            
                                            @if($master->description)
                                                <div class="mb-3">
                                                    <strong>Tavsif:</strong>
                                                    <p class="small">{{ Str::limit($master->description, 100) }}</p>
                                                </div>
                                            @endif
                                            
                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    Ariza sanasi: {{ $master->created_at->format('d.m.Y H:i') }}
                                                </small>
                                            </div>
                                            
                                            <form method="POST" action="{{ route('admin.masters.approve', $master) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" 
                                                        onclick="return confirm('Bu ustani tasdiqlaysizmi?')">
                                                    <i class="bi bi-check-circle"></i> Tasdiqlash
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $pendingMasters->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-check-circle display-1 text-success"></i>
                            <h3 class="mt-3">Barcha arizalar ko'rib chiqildi</h3>
                            <p class="text-muted">Hozircha tasdiq kutayotgan ustalar yo'q</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
