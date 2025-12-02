@extends('layouts.app')

@section('title', 'Ro\'yxatdan o\'tish')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4 class="mb-0">Ro'yxatdan o'tish</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Ism</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   autofocus
                                   autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="username">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefon raqam</label>
                            <input type="text"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="+998901234567">
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Region -->
                        <div class="mb-3">
                            <label for="region_id" class="form-label">Hudud</label>
                            <select class="form-select @error('region_id') is-invalid @enderror"
                                    id="region_id"
                                    name="region_id"
                                    required>
                                <option value="">Hududni tanlang</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                        {{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('region_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- District -->
                        <div class="mb-3">
                            <label for="district_id" class="form-label">Tuman</label>
                            <select class="form-select @error('district_id') is-invalid @enderror"
                                    id="district_id"
                                    name="district_id"
                                    required>
                                <option value="">Avval hududni tanlang</option>
                            </select>

                            @error('district_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <!-- User Type -->
                        <div class="mb-3">
                            <label class="form-label">Foydalanuvchi turi</label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="user_type" id="user_type_user" value="user" {{ old('user_type', 'user') == 'user' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="user_type_user">
                                        Oddiy foydalanuvchi
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="user_type" id="user_type_master" value="master" {{ old('user_type') == 'master' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="user_type_master">
                                        Usta bo'lmoqchiman
                                    </label>
                                </div>
                            </div>
                            @error('user_type')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Master Fields (hidden by default) -->
                        <div id="master_fields" style="display: {{ old('user_type') == 'master' ? 'block' : 'none' }};">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kasb turi</label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id"
                                        name="category_id">
                                    <option value="">Kasb turini tanlang</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="experience_years" class="form-label">Tajriba (yil)</label>
                                <input type="number"
                                       class="form-control @error('experience_years') is-invalid @enderror"
                                       id="experience_years"
                                       name="experience_years"
                                       value="{{ old('experience_years') }}"
                                       min="0"
                                       max="50">
                                @error('experience_years')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">O'zingiz haqingizda</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="3"
                                          placeholder="Qanday ishlarni bajarasiz, tajribangiz haqida yozing...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Parol</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   required
                                   autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Parolni tasdiqlang</label>
                            <input type="password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Ro'yxatdan o'tish
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <p class="mb-0">Hisobingiz bormi?</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                Kirish
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userTypeRadios = document.querySelectorAll('input[name="user_type"]');
    const masterFields = document.getElementById('master_fields');

    userTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'master') {
                masterFields.style.display = 'block';
            } else {
                masterFields.style.display = 'none';
            }
        });
    });
});


    document.addEventListener('DOMContentLoaded', function() {

    // Master fields toggling
    const userTypeRadios = document.querySelectorAll('input[name="user_type"]');
    const masterFields = document.getElementById('master_fields');

    userTypeRadios.forEach(radio => {
    radio.addEventListener('change', function() {
    masterFields.style.display = this.value === 'master' ? 'block' : 'none';
});
});

    // ------- AJAX District loading -------
    const regionSelect = document.getElementById('region_id');
    const districtSelect = document.getElementById('district_id');

    regionSelect.addEventListener('change', function() {
    let regionId = this.value;

    districtSelect.innerHTML = '<option value="">Yuklanmoqda...</option>';

    fetch(`/get-districts/${regionId}`)
    .then(response => response.json())
    .then(data => {
    districtSelect.innerHTML = '<option value="">Tuman tanlang</option>';

    data.forEach(district => {
    let option = `<option value="${district.id}">${district.name}</option>`;
    districtSelect.innerHTML += option;
});
});
});
});


</script>
@endpush
@endsection
