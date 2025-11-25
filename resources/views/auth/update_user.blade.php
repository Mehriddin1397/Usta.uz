@extends('layouts.app')

@section('title', 'Ro\'yxatdan o\'tish')


@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Profil ma'lumotlarini tahrirlash</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            {{-- Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Ism</label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefon</label>
                                <input type="text"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       name="phone"
                                       id="phone"
                                       value="{{ old('phone', $user->phone) }}"
                                       placeholder="+998901234567">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Region --}}
                            <div class="mb-3">
                                <label for="region_id" class="form-label">Hudud</label>
                                <select class="form-select @error('region_id') is-invalid @enderror"
                                        name="region_id" required>
                                    <option value="">Hududni tanlang</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}"
                                            {{ old('region_id', $user->region_id) == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('region_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- User Type --}}
                            <div class="mb-3">
                                <label class="form-label">Foydalanuvchi turi</label>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="user_type" id="user_type_user" value="user"
                                        {{ old('user_type', $user->master ? 'master' : 'user') == 'user' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="user_type_user">
                                        Oddiy foydalanuvchi
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="user_type" id="user_type_master" value="master"
                                        {{ old('user_type', $user->master ? 'master' : 'user') == 'master' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="user_type_master">
                                        Usta
                                    </label>
                                </div>

                                @error('user_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Master Fields --}}
                            <div id="master_fields"
                                 style="display: {{ old('user_type', $user->master ? 'master' : 'user') == 'master' ? 'block' : 'none' }};">

                                {{-- Category --}}
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kasb turi</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                            name="category_id">
                                        <option value="">Kasb turini tanlang</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $user->master->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Experience --}}
                                <div class="mb-3">
                                    <label for="experience_years" class="form-label">Tajriba (yil)</label>
                                    <input type="number"
                                           class="form-control @error('experience_years') is-invalid @enderror"
                                           name="experience_years"
                                           value="{{ old('experience_years', $user->master->experience_years ?? '') }}"
                                           min="0" max="50">
                                    @error('experience_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Description --}}
                                <div class="mb-3">
                                    <label for="description" class="form-label">O'zingiz haqingizda</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              name="description"
                                              rows="3">{{ old('description', $user->master->description ?? '') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Yangi parol (majburiy emas)</label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Parolni tasdiqlang</label>
                                <input type="password"
                                       class="form-control"
                                       name="password_confirmation">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Saqlash
                                </button>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const radios = document.querySelectorAll('input[name="user_type"]');
                const masterFields = document.getElementById('master_fields');

                radios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        masterFields.style.display = (this.value === 'master') ? 'block' : 'none';
                    });
                });
            });
        </script>
    @endpush

@endsection

