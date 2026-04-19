@extends('layouts.app')

@section('content')
<div class="container py-4" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0 text-primary">
                        <i class="fas fa-edit me-2"></i> تعديل بيانات المادة: {{ $item->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">اسم المادة</label>
                            <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">كود المادة (SKU)</label>
                            <input type="text" name="sku" class="form-control" value="{{ $item->sku }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">الكمية الحالية في المخزن</label>
                            <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}" readonly>
                            <small class="text-muted">يتم تحديث الكمية آلياً عبر الفواتير فقط.</small>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <button type="submit" class="btn btn-primary px-4">حفظ التغييرات</button>
                            <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection