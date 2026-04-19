@extends('layouts.app')

@section('content')
<div class="min-h-screen d-flex align-items-center justify-content-center bg-[#f8fafc] py-5" dir="rtl" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <div class="d-inline-block p-3 bg-white shadow-sm rounded-4 mb-3">
                        <i class="fas fa-warehouse fa-3x text-primary"></i>
                    </div>
                    <h3 class="fw-bold text-dark">إنشاء حساب جديد</h3>
                    <p class="text-muted small">انضم إلى نظام المستودع الذكي لإدارة مخزونك</p>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 border-top border-primary border-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label small fw-bold text-muted">الاسم الكامل</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                                    <input id="name" type="text" class="form-control bg-light border-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus placeholder="أدخل اسمك الثلاثي">
                                </div>
                                @error('name')
                                    <span class="invalid-feedback d-block mt-1 small" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label small fw-bold text-muted">البريد الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                                    <input id="email" type="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="example@domain.com">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block mt-1 small" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label small fw-bold text-muted">كلمة المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                                    <input id="password" type="password" class="form-control bg-light border-0 @error('password') is-invalid @enderror" name="password" required placeholder="********">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block mt-1 small" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label small fw-bold text-muted">تأكيد كلمة المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-check-double text-muted"></i></span>
                                    <input id="password-confirm" type="password" class="form-control bg-light border-0" name="password_confirmation" required placeholder="********">
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary py-2 fw-bold rounded-3 shadow-sm">
                                    إنشاء الحساب <i class="fas fa-user-plus ms-2"></i>
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="small text-muted mb-0">لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">تسجيل الدخول</a></p>
                            </div>
                        </form>
                    </div>
                </div>
                
                <p class="text-center mt-4 text-muted small">© {{ date('Y') }} نظام المستودع الذكي - جميع الحقوق محفوظة</p>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8fafc; }
    .card { transition: transform 0.3s ease; }
    .form-control:focus {
        box-shadow: none;
        background-color: #fff !important;
        border: 1px solid #0d6efd !important;
    }
    .input-group-text { border-radius: 0 0.5rem 0.5rem 0 !important; }
    input.form-control { border-radius: 0.5rem 0 0 0.5rem !important; }
    .btn-primary { background-color: #0d6efd; border: none; }
    .btn-primary:hover { background-color: #0b5ed7; transform: translateY(-1px); }
</style>
@endsection