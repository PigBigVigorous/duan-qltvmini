<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <<< IMPORT

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  Vai trò được yêu cầu (từ route, ví dụ 'librarian')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Kiểm tra đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // 2. Kiểm tra vai trò: Nếu không phải role yêu cầu VÀ không phải admin thì chặn
        if ($user->role !== $role && $user->role !== 'admin') {
            // Chuyển hướng về trang chủ và gửi thông báo lỗi
            return redirect('/home')->with('error', 'Bạn không có quyền truy cập chức năng này.');
        }

        // 3. Nếu đúng quyền, cho đi tiếp
        return $next($request);
    }
}