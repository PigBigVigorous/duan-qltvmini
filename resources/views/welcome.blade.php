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
        /* CSS tùy chỉnh cho trang chủ công khai */
        .hero-section {
            background: linear-gradient(to right, rgba(29, 78, 216, 0.8), rgba(30, 64, 175, 0.9)), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 8rem 0;
            text-align: center;
        }
        .book-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 0;
            border-radius: 0.5rem;
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .book-card-img-top {
            width: 100%;
            height: 300px; /* Chiều cao cố định cho ảnh bìa */
            object-fit: cover; /* Đảm bảo ảnh vừa vặn đẹp */
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }
        .navbar-brand {
            font-weight: bold;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 2rem 0;
            margin-top: 4rem;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-book-open me-2"></i>
                    Thư Viện Mini
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
                            {{-- Bạn có thể ẩn Đăng ký nếu không muốn độc giả tự tạo tài khoản --}}
                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-primary ms-2" href="{{ route('register') }}">{{ __('Đăng ký') }}</a>
                                </li>
                            @endif --}}
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
                <form action="#" method="GET"> {{-- Nâng cấp: Tạo route tìm kiếm công khai sau --}}
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
                    @forelse ($featuredBooks as $book)
                        <div class="col">
                            <div class="card h-100 book-card">
                                {{-- Giả sử chúng ta dùng ảnh placeholder, bạn có thể thêm trường ảnh cho Book sau --}}
                                <img src="{{ $book->image ?? 'https://via.placeholder.com/400x600.png/003366/FFFFFF?text=No+Image' }}" class="book-card-img-top" alt="{{ $book->title }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $book->title }}</h5>
                                    <p class="card-text text-muted grow">{{ $book->author }}</p>
                                    <span class="badge {{ $book->available_copies > 0 ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $book->available_copies > 0 ? 'Còn Sách' : 'Đã Hết' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Chưa có sách nào trong thư viện.</p>
                    @endforelse
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