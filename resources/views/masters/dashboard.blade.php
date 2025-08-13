@extends('layouts.app')

@section('title', 'Usta Dashboard')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Usta Dashboard</h1>
            <p class="lead">Salom, {{ $master->user->name }}!</p>
        </div>
    </div>

    <!-- Master Status -->
    <div class="row mb-4">
        <div class="col-12">
            @if(!$master->is_approved)
                <div class="alert alert-warning">
                    <i class="bi bi-clock"></i> 
                    Sizning usta profilingiz hali admin tomonidan tasdiqlanmagan. 
                    Tasdiqlanganidan so'ng buyurtmalar qabul qila olasiz.
                </div>
            @else
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> 
                    Sizning profilingiz tasdiqlangan! Buyurtmalar qabul qilishingiz mumkin.
                </div>
            @endif
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3>{{ $pendingOrders->count() }}</h3>
                    <p class="mb-0">Yangi buyurtmalar</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3>{{ $activeOrders->count() }}</h3>
                    <p class="mb-0">Faol buyurtmalar</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3>{{ $completedOrders->count() }}</h3>
                    <p class="mb-0">Tugallangan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h3>{{ number_format($master->rating, 1) }}</h3>
                    <p class="mb-0">Reyting</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tezkor harakatlar</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('master.works.create') }}" class="btn btn-primary me-2 mb-2">
                        <i class="bi bi-plus-circle"></i> Yangi ish qo'shish
                    </a>
                    <a href="{{ route('masters.show', $master) }}" class="btn btn-outline-primary me-2 mb-2">
                        <i class="bi bi-eye"></i> Profilni ko'rish
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Pending Orders -->
        @if($pendingOrders->count() > 0)
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Yangi buyurtmalar</h5>
                    </div>
                    <div class="card-body">
                        @foreach($pendingOrders as $order)
                            <div class="border-bottom pb-3 mb-3">
                                <h6>{{ $order->user->name }}</h6>
                                <p class="text-muted mb-2">{{ Str::limit($order->description, 100) }}</p>
                                <small class="text-muted">{{ $order->created_at->format('d.m.Y H:i') }}</small>
                                <div class="mt-2">
                                    <form method="POST" action="{{ route('master.orders.accept', $order) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check"></i> Qabul qilish
                                        </button>
                                    </form>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> Ko'rish
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Active Orders -->
        @if($activeOrders->count() > 0)
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Faol buyurtmalar</h5>
                    </div>
                    <div class="card-body">
                        @foreach($activeOrders as $order)
                            <div class="border-bottom pb-3 mb-3">
                                <h6>{{ $order->user->name }}</h6>
                                <p class="text-muted mb-2">{{ Str::limit($order->description, 100) }}</p>
                                <span class="badge bg-{{ $order->status == 'accepted' ? 'info' : 'primary' }} mb-2">
                                    {{ $order->status == 'accepted' ? 'Qabul qilindi' : 'Jarayonda' }}
                                </span>
                                <br>
                                <small class="text-muted">{{ $order->created_at->format('d.m.Y H:i') }}</small>
                                <div class="mt-2">
                                    @if($order->status == 'accepted')
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#completeModal{{ $order->id }}">
                                            <i class="bi bi-check-circle"></i> Tugatish
                                        </button>
                                    @endif
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> Ko'rish
                                    </a>
                                </div>
                            </div>

                            <!-- Complete Order Modal -->
                            <div class="modal fade" id="completeModal{{ $order->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('master.orders.complete', $order) }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ishni tugatish</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="completion_notes" class="form-label">Izoh</label>
                                                    <textarea class="form-control" id="completion_notes" name="completion_notes" rows="3" placeholder="Ish haqida qo'shimcha ma'lumot..."></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="completion_media" class="form-label">Rasm/Video yuklash</label>
                                                    <input type="file" class="form-control" id="completion_media" name="completion_media[]" multiple accept="image/*,video/*">
                                                    <small class="text-muted">Bir nechta fayl tanlashingiz mumkin</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                                                <button type="submit" class="btn btn-success">Tugatish</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Recent Completed Orders -->
    @if($completedOrders->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">So'nggi tugallangan ishlar</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Mijoz</th>
                                        <th>Tavsif</th>
                                        <th>Tugallangan sana</th>
                                        <th>Harakat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($completedOrders as $order)
                                        <tr>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ Str::limit($order->description, 50) }}</td>
                                            <td>{{ $order->updated_at->format('d.m.Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-eye"></i> Ko'rish
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
