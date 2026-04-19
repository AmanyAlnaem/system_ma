@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light" dir="rtl">
    <div class="card border-0 shadow-lg" style="width: 450px; border-radius: 20px; overflow: hidden;">
        <div class="row g-0">
            <div class="col-12 p-5">
                <div class="text-center mb-4">
                    <div class="bg-primary text-white d-inline-block p-3 rounded-circle mb-3 shadow">
                        <i class="fas fa-warehouse fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-dark">نظام إدارة المستودعات</h3>
                    <p class="text-muted">مرحباً بك، يرجى تسجيل الدخول</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small text-muted">البريد الإلكتروني</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="far fa-envelope text-primary"></i></span>
                            <input type="email" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" placeholder="name@company.com" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small text-muted">كلمة المرور</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-lock text-primary"></i></span>
                            <input type="password" name="password" class="form-control border-start-0 ps-0 shadow-none" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm" style="border-radius: 12px;">
                        دخول للمنصة <i class="fas fa-sign-in-alt ms-2"></i>
                    </button>
                    
                    <div class="text-center mt-4">
                        <span class="small text-muted">ليس لديك حساب؟</span>
                        <a href="{{ route('register') }}" class="small fw-bold text-decoration-none">إنشاء حساب جديد</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection