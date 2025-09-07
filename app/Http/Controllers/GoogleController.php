<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
     // Chuyển hướng đến Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Tìm user theo email, nếu chưa có thì tạo mới
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'fullname' => $googleUser->getName(),
                    'password' => bcrypt('123456dummy'),
                    'google_id' => $googleUser->getId(),
                ]
            );

            // Đăng nhập user
            Auth::guard('client')->login($user);

            return redirect()->route('client.home'); // chuyển về trang chính
        } catch (\Exception $e) {
            return redirect()->route('client.login')->with('error', 'Có lỗi khi đăng nhập Google!');
        }
    }
}
