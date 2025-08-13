@extends('layouts.app')

@section('title', 'Email tasdiqlash')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4 class="mb-0">Email tasdiqlash</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-muted">
                        Ro'yxatdan o'tganingiz uchun rahmat! Davom etishdan oldin, 
                        email manzilingizni tasdiqlang. Agar email kelmagan bo'lsa, 
                        qayta yuborish tugmasini bosing.
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success mb-4">
                            Yangi tasdiqlash havolasi email manzilingizga yuborildi.
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Qayta yuborish
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link">
                                Chiqish
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
