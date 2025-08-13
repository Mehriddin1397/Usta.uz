@extends('layouts.app')

@section('title', 'Foydalanuvchilar - Admin')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Foydalanuvchilar</h1>
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
                    <h5 class="mb-0">Barcha foydalanuvchilar</h5>
                </div>
                <div class="card-body">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ism</th>
                                        <th>Email</th>
                                        <th>Telefon</th>
                                        <th>Hudud</th>
                                        <th>Rol</th>
                                        <th>Ro'yxatdan o'tgan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone ?? '-' }}</td>
                                            <td>{{ $user->region->name ?? '-' }}</td>
                                            <td>
                                                @switch($user->role)
                                                    @case('admin')
                                                        <span class="badge bg-danger">Admin</span>
                                                        @break
                                                    @case('master')
                                                        <span class="badge bg-success">Usta</span>
                                                        @break
                                                    @case('user')
                                                        <span class="badge bg-primary">Foydalanuvchi</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $user->created_at->format('d.m.Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $users->links() }}
                        </div>
                    @else
                        <p class="text-muted text-center py-4">Hozircha foydalanuvchilar yo'q</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
