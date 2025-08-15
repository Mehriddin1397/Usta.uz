@extends('layouts.app')

@section('title', 'Aloqa')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-4 mb-3">Biz bilan bog'laning</h1>
                <p class="lead text-muted">Savollaringiz bormi? Yordam kerakmi? Biz sizga yordam berishga tayyormiz!</p>
            </div>

            <div class="row">
                <!-- Contact Form -->
                <div class="col-md-8 mb-4">
                    <div class="card shadow">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-envelope"></i> Xabar yuborish
                            </h5>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('contact.send') }}">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Ismingiz</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', auth()->user()->name ?? '') }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', auth()->user()->email ?? '') }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Telefon raqam</label>
                                    <input type="text" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', auth()->user()->phone ?? '') }}" 
                                           placeholder="+998901234567">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="subject" class="form-label">Mavzu</label>
                                    <select class="form-select @error('subject') is-invalid @enderror" 
                                            id="subject" 
                                            name="subject" 
                                            required>
                                        <option value="">Mavzuni tanlang</option>
                                        <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>Umumiy savol</option>
                                        <option value="technical" {{ old('subject') == 'technical' ? 'selected' : '' }}>Texnik muammo</option>
                                        <option value="master" {{ old('subject') == 'master' ? 'selected' : '' }}>Usta bilan bog'liq</option>
                                        <option value="payment" {{ old('subject') == 'payment' ? 'selected' : '' }}>To'lov masalasi</option>
                                        <option value="complaint" {{ old('subject') == 'complaint' ? 'selected' : '' }}>Shikoyat</option>
                                        <option value="suggestion" {{ old('subject') == 'suggestion' ? 'selected' : '' }}>Taklif</option>
                                    </select>
                                    @error('subject')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">Xabar</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" 
                                              name="message" 
                                              rows="5" 
                                              placeholder="Xabaringizni batafsil yozing..." 
                                              required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send"></i> Xabar yuborish
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-info-circle"></i> Aloqa ma'lumotlari
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6><i class="bi bi-telephone text-primary"></i> Telefon</h6>
                                <p class="mb-0">+998 (71) 123-45-67</p>
                                <small class="text-muted">Dushanba-Juma: 9:00-18:00</small>
                            </div>

                            <div class="mb-4">
                                <h6><i class="bi bi-envelope text-primary"></i> Email</h6>
                                <p class="mb-0">info@usta.uz</p>
                                <p class="mb-0">support@usta.uz</p>
                            </div>

                            <div class="mb-4">
                                <h6><i class="bi bi-geo-alt text-primary"></i> Manzil</h6>
                                <p class="mb-0">Toshkent shahri,<br>
                                Yunusobod tumani,<br>
                                Amir Temur ko'chasi, 108</p>
                            </div>

                            <div class="mb-4">
                                <h6><i class="bi bi-clock text-primary"></i> Ish vaqti</h6>
                                <p class="mb-0">Dushanba-Juma: 9:00-18:00</p>
                                <p class="mb-0">Shanba: 9:00-14:00</p>
                                <p class="mb-0">Yakshanba: Dam olish</p>
                            </div>

                            <div>
                                <h6><i class="bi bi-chat-dots text-primary"></i> Ijtimoiy tarmoqlar</h6>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-telegram"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ -->
                    <div class="card shadow mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-question-circle"></i> Tez-tez so'raladigan savollar
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                            Qanday qilib usta bo'laman?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Ro'yxatdan o'tishda "Usta bo'lmoqchiman" ni tanlang va kerakli ma'lumotlarni to'ldiring. Admin tasdiqlashidan so'ng faoliyat boshlashingiz mumkin.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                            To'lov qanday amalga oshiriladi?
                                        </button>
                                    </h2>
                                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            To'lov ish tugagandan so'ng mijoz va usta o'rtasida kelishilgan tartibda amalga oshiriladi.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                            Usta sifatini qanday tekshiraman?
                                        </button>
                                    </h2>
                                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Har bir ustaning profili, reytingi, ish namunalari va mijozlar sharhlari mavjud. Bularni ko'rib chiqing.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
