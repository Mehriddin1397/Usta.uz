@extends('layouts.app')

@section('title', 'Yangi ish qo\'shish')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Yangi ish qo'shish</h5>
                        <a href="{{ route('master.dashboard') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Orqaga
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('master.works.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Ish nomi</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   placeholder="Masalan: Oshxona ta'mirlash"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Tavsif</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Ish haqida batafsil ma'lumot...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="media" class="form-label">Rasm va videolar</label>
                            <input type="file" 
                                   class="form-control @error('media.*') is-invalid @enderror" 
                                   id="media" 
                                   name="media[]" 
                                   multiple 
                                   accept="image/*,video/*">
                            <small class="text-muted">
                                Bir nechta rasm va video yuklashingiz mumkin. 
                                Maksimal fayl hajmi: 10MB
                            </small>
                            @error('media.*')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                <strong>Maslahat:</strong> Sifatli rasm va videolar yuklang. 
                                Bu mijozlarning sizga bo'lgan ishonchini oshiradi.
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('master.dashboard') }}" class="btn btn-secondary me-md-2">
                                Bekor qilish
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Qo'shish
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
document.addEventListener('DOMContentLoaded', function() {
    const mediaInput = document.getElementById('media');
    
    mediaInput.addEventListener('change', function() {
        const files = this.files;
        let totalSize = 0;
        
        for (let i = 0; i < files.length; i++) {
            totalSize += files[i].size;
        }
        
        // Check if total size exceeds 50MB
        if (totalSize > 50 * 1024 * 1024) {
            alert('Jami fayl hajmi 50MB dan oshmasligi kerak!');
            this.value = '';
        }
    });
});
</script>
@endpush
@endsection
