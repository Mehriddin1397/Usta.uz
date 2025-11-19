<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ustalar24.uz') }} - @yield('title', 'Ustalar platformasi')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-tools"></i> Ustalar24.uz
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Bosh sahifa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Aloqa</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <!-- Language Switcher -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-globe"></i>
                            @switch(app()->getLocale())
                                @case('uz')
                                    O'zbekcha
                                    @break
                                @case('uz-Cyrl')
                                    Ўзбекча
                                    @break
                                @case('ru')
                                    Русский
                                    @break
                                @default
                                    O'zbekcha
                            @endswitch
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() == 'uz' ? 'active' : '' }}"
                                   href="{{ route('language.change', 'uz') }}">
                                    O'zbekcha (Lotin)
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() == 'uz-Cyrl' ? 'active' : '' }}"
                                   href="{{ route('language.change', 'uz-Cyrl') }}">
                                    Ўзбекча (Кирилл)
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() == 'ru' ? 'active' : '' }}"
                                   href="{{ route('language.change', 'ru') }}">
                                    Русский
                                </a>
                            </li>
                        </ul>
                    </li>

                    @auth
                        @if(auth()->user()->isMaster())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('master.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Usta paneli
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-gear"></i> Admin panel
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">
                                <i class="bi bi-list-task"></i> Buyurtmalarim
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Chiqish
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Kirish</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Ro'yxatdan o'tish</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Back Button (show on all pages except home) -->
        @if(!request()->routeIs('home'))
            <div class="container py-2">
                <button onclick="history.back()" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Ortga
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Rasm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Katta rasm">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Ustalar24.uz</h5>
                    <p>Foydalanuvchi va ustalarni bog'lovchi platforma</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; {{ date('Y') }} Ustalar24.uz. Barcha huquqlar himoyalangan.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Image Modal Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add click event to all images with class 'clickable-image'
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('clickable-image')) {
                    const modalImage = document.getElementById('modalImage');
                    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));

                    modalImage.src = e.target.src;
                    modalImage.alt = e.target.alt;

                    imageModal.show();
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
