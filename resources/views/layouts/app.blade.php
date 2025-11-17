<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Quản Lý Thư Viện') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app" class="d-flex"> {{-- Sử dụng Flexbox của Bootstrap --}}

        @auth {{-- Chỉ hiển thị Sidebar nếu đã đăng nhập --}}
        <div class="sidebar d-flex flex-column">
            
            {{-- Header --}}
            <a href="{{ route('home') }}" class="sidebar-header text-decoration-none">
                <i class="fas fa-book-open"></i>
                <span>Thư Viện Mini</span>
            </a>

            {{-- Navigation Links --}}
            <ul class="nav nav-pills flex-column mb-auto">
                
                @if (Auth::user()->isLibrarian()) {{-- Chỉ Thủ thư mới thấy menu này --}}
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Bảng điều khiển
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">
                            <i class="fas fa-book me-2"></i> Quản Lý Sách
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('members.*') ? 'active' : '' }}" href="{{ route('members.index') }}">
                            <i class="fas fa-users me-2"></i> Quản Lý Độc Giả
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('borrows.*') ? 'active' : '' }}" href="{{ route('borrows.index') }}">
                            <i class="fas fa-clipboard-list me-2"></i> Quản Lý Mượn/Trả
                        </a>
                    </li>
                @else
                    {{-- Menu cho Độc giả (member) --}}
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">
                            <i class="fas fa-home me-2"></i> Trang chủ
                        </a>
                    </li>
                    {{-- (Thêm link tìm kiếm sách, lịch sử mượn cho độc giả ở đây) --}}
                @endif
            </ul>

            {{-- Footer (User & Logout) --}}
            <div class="sidebar-footer">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2 fs-4"></i>
                        <strong>{{ Auth::user()->name }}</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Đăng xuất') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endauth

        <div class="content-wrapper">
            
            {{-- Top Navbar (Chỉ để hiển thị thông báo, nếu cần) --}}
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm p-3">
                @guest
                    {{-- Nếu chưa đăng nhập, hiển thị link Login/Register ở đây --}}
                    <div class="container-fluid">
                         <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Quản Lý Thư Viện') }}
                         </a>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a></li>
                        </ul>
                    </div>
                @else
                    {{-- Đã đăng nhập, có thể hiển thị nút Toggle (nếu làm responsive) --}}
                    <span class="navbar-brand mb-0 h1">@yield('page_title', 'Bảng điều khiển')</span>
                @endguest
            </nav>

            {{-- Main Content --}}
            <main class="py-4">
                <div class="container-fluid px-4">
                    {{-- Hiển thị thông báo (Lỗi/Thành công) --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>

    </div>
</body>
</html>