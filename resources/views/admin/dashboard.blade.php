@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Admin Dashboard</h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['total_users'] }}</h4>
                            <p class="mb-0">Jami foydalanuvchilar</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-people display-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['total_masters'] }}</h4>
                            <p class="mb-0">Jami ustalar</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-tools display-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['pending_masters'] }}</h4>
                            <p class="mb-0">Kutilayotgan ustalar</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-clock display-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['total_orders'] }}</h4>
                            <p class="mb-0">Jami buyurtmalar</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-list-task display-4"></i>
                        </div>
                    </div>
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
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-people"></i> Foydalanuvchilar
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.masters.pending') }}" class="btn btn-outline-warning w-100">
                                <i class="bi bi-clock"></i> Kutilayotgan ustalar
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.categories') }}" class="btn btn-outline-success w-100">
                                <i class="bi bi-tags"></i> Kategoriyalar
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.regions') }}" class="btn btn-outline-info w-100">
                                <i class="bi bi-geo-alt"></i> Hududlar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">So'nggi buyurtmalar</h5>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mijoz</th>
                                        <th>Usta</th>
                                        <th>Status</th>
                                        <th>Sana</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->master->user->name }}</td>
                                            <td>
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
                                            </td>
                                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Hozircha buyurtmalar yo'q</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
