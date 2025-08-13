@extends('layouts.app')

@section('title', 'Mening buyurtmalarim')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Mening buyurtmalarim</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($orders->count() > 0)
                @foreach($orders as $order)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="card-title">
                                        {{ $order->master->user->name }}
                                        <small class="text-muted">({{ $order->master->category->name }})</small>
                                    </h5>
                                    <p class="card-text">{{ Str::limit($order->description, 150) }}</p>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> {{ $order->created_at->format('d.m.Y H:i') }}
                                    </small>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <div class="mb-2">
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
                                    <div>
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i> Ko'rish
                                        </a>
                                        @if($order->status === 'completed' && !$order->review)
                                            <a href="{{ route('orders.review.create', $order) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-star"></i> Baholash
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-list-task display-1 text-muted"></i>
                    <h3 class="mt-3">Hozircha buyurtmalar yo'q</h3>
                    <p class="text-muted">Ustalarni qidirib, birinchi buyurtmangizni bering!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="bi bi-search"></i> Ustalarni qidirish
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
