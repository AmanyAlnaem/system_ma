@extends('layouts.app')

@section('content')
<div class="container py-4" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary">التقرير اليومي لبيانات: {{ $today }}</h4>
        <button onclick="window.print()" class="btn btn-outline-dark btn-sm">طباعة التقرير</button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3">
                <p class="text-muted small mb-1">إجمالي المبيعات</p>
                <h3 class="text-success fw-bold">{{ number_format($totalSales, 2) }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3">
                <p class="text-muted small mb-1">إجمالي المشتريات</p>
                <h3 class="text-danger fw-bold">{{ number_format($totalPurchases, 2) }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3 bg-primary-subtle">
                <p class="text-primary small mb-1">صافي حركة الصندوق</p>
                <h3 class="text-primary fw-bold">{{ number_format($totalSales - $totalPurchases, 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">جدول حركات اليوم</div>
        <div class="card-body">
            <table class="table text-center align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>المادة</th>
                        <th>النوع</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dailyActivities as $activity)
                    <tr>
                        <td class="fw-bold">{{ $activity->name }}</td>
                        <td>
                            <span class="badge {{ $activity->type == 'in' ? 'bg-success' : 'bg-danger' }}">
                                {{ $activity->type == 'in' ? 'شراء' : 'بيع' }}
                            </span>
                        </td>
                        <td>{{ $activity->quantity }}</td>
                        <td>{{ number_format($activity->price, 2) }}</td>
                        <td class="fw-bold">{{ number_format($activity->quantity * $activity->price, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-muted py-4">لا توجد حركات مسجلة لهذا اليوم</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection