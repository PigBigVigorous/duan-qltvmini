<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thư Viện Mini</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
    .hero-section {
        /* Thêm lớp phủ gradient đen nhẹ để chữ trắng dễ đọc hơn */
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080') no-repeat center center;
        background-size: cover;
        color: white;
        padding: 6rem 0;
        text-align: center;
    }
    
    .book-card {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: none;
        border-radius: 1rem; /* Bo tròn nhiều hơn */
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        background: #fff;
        overflow: hidden; /* Để ảnh không bị tràn ra ngoài bo góc */
        height: 100%;
    }

    .book-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }

    .book-card-img-top {
        width: 100%;
        aspect-ratio: 2/3; /* Tỷ lệ vàng cho sách */
        object-fit: cover;
        background-color: #f1f1f1;
        border-bottom: 1px solid #eee;
    }

    .card-body {
        padding: 1.25rem;
    }

    .card-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        /* Giới hạn tiêu đề 2 dòng */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
    }
    
    footer {
        background-color: #212529;
        color: #adb5bd;
        padding: 3rem 0;
        margin-top: auto;
    }
</style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-book-open me-2"></i> Thư Viện Mini
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="publicNavbar">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{ route('home') }}">
                                    <i class="fas fa-user me-1"></i>
                                    Vào trang của bạn ({{ Auth::user()->name }})
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <header class="hero-section">
            <div class="container">
                <h1 class="display-4 fw-bold">Chào mừng đến với Thư Viện Mini</h1>
                <p class="lead">Khám phá kho tàng tri thức, tìm kiếm những cuốn sách yêu thích của bạn.</p>
                <form action="#" method="GET">
                    <div class="input-group input-group-lg mt-4 mx-auto" style="max-width: 600px;">
                        <input type="text" class="form-control" placeholder="Tìm kiếm sách theo tên, tác giả...">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </header>

        <main class="py-5">
            <div class="container">
                <h2 class="text-center mb-4">Sách Nổi Bật</h2>
                
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                    {{-- $featuredBooks được truyền từ WelcomeController --}}
                    @if(isset($featuredBooks) && $featuredBooks->count() > 0)
                        @foreach ($featuredBooks as $book)
                            <div class="col">
                                <div class="card h-100 book-card">
                                    {{-- SỬ DỤNG ẢNH THẬT (ĐÃ SỬA) --}}
                                    <img src="{{ $book->image ? asset($book->image) : 'https://via.placeholder.com/400x600.png/003366/FFFFFF?text=No+Image' }}" class="book-card-img-top" alt="{{ $book->title }}">
                                    
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $book->title }}</h5>
                                        <p class="card-text text-muted flex-grow-1">{{ $book->author }}</p>
                                        <span class="badge {{ $book->available_copies > 0 ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $book->available_copies > 0 ? 'Còn Sách' : 'Đã Hết' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center">Chưa có sách nào trong thư viện.</p>
                    @endif
                </div>
            </div>
        </main>

        <footer>
            <div class="container text-center">
                <p>&copy; {{ date('Y') }} Thư Viện Mini. Đồ án môn học Công Nghệ Web.</p>
            </div>
        </footer>
    </div>
</body>
</html>