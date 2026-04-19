@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f8fafc] p-4 md:p-10" dir="rtl" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    <div class="max-w-7xl mx-auto d-flex justify-content-between align-items-end mb-5">
        <div>
            <span class="text-uppercase text-muted small fw-bold tracking-wider">نظام الإدارة المركزية</span>
            <h2 class="fw-bold text-dark m-0 mt-1">نظام المستودع الذكي</h2>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end d-none d-md-block">
                <p class="small text-muted mb-0">المستخدم الحالي</p>
                <p class="fw-bold mb-0 text-primary">{{ Auth::user()->name }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-white shadow-sm border rounded-3 px-3 py-2 text-danger" title="تسجيل الخروج">
                    <i class="fas fa-power-off"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="row g-4 mb-5">
            <div class="col-md-2">
                <a href="{{ route('items.index') }}" class="text-decoration-none h-100">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-card h-100">
                    <div class="card-body p-4 border-bottom border-primary border-4 text-dark text-center">
                        <p class="text-muted small fw-bold">إجمالي المواد</p>
                        <h2 class="fw-bold mb-0">{{ $totalItems }}</h2>
                        <div class="text-primary opacity-25 mt-2"><i class="fas fa-box-open fa-2x"></i></div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('invoices.index', ['type' => 'in']) }}" class="text-decoration-none h-100">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-card h-100">
                        <div class="card-body p-4 border-bottom border-success border-4 text-dark text-center">
                            <p class="text-muted small fw-bold">حركات الوارد</p>
                            <h2 class="fw-bold mb-0 text-success">{{ $inCount }}</h2>
                            <div class="text-success opacity-25 mt-2"><i class="fas fa-download fa-2x"></i></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('invoices.index', ['type' => 'out']) }}" class="text-decoration-none h-100">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-card h-100">
                        <div class="card-body p-4 border-bottom border-danger border-4 text-dark text-center">
                            <p class="text-muted small fw-bold">حركات الصادر</p>
                            <h2 class="fw-bold mb-0 text-danger">{{ $outCount }}</h2>
                            <div class="text-danger opacity-25 mt-2"><i class="fas fa-upload fa-2x"></i></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-card h-100">
                    <div class="card-body p-4 border-bottom border-info border-4 text-dark text-center" style="border-color: #6f42c1 !important;">
                        <p class="text-muted small fw-bold">الأكثر طلباً</p>
                        <h2 class="fw-bold mb-0" style="color: #6f42c1;">{{ $topSellingItems->first()->name ?? 'N/A' }}</h2>
                        <div class="opacity-25 mt-2" style="color: #6f42c1;"><i class="fas fa-fire fa-2x"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-card h-100">
                    <div class="card-body p-4 border-bottom border-primary border-4 text-dark text-center" style="border-color: #0d6efd !important;">
                        <p class="text-muted small fw-bold">قيمة المستودع</p>
                        <h2 class="fw-bold mb-0 text-primary">${{ number_format($totalInventoryValue ?? 0, 2) }}</h2>
                        <div class="text-primary opacity-25 mt-2"><i class="fas fa-warehouse fa-2x"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-card h-100">
                    <div class="card-body p-4 border-bottom border-success border-4 text-dark text-center">
                        <p class="text-muted small fw-bold">إجمالي الأرباح</p>
                        <h2 class="fw-bold mb-0 text-success">${{ number_format($totalProfit, 2) }}</h2>
                        <div class="text-success opacity-25 mt-2"><i class="fas fa-chart-line fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-4 shadow-sm p-4 mb-5 border">
            <h6 class="fw-bold text-muted mb-4 px-2 text-start small uppercase">الوصول السريع للوظائف</h6>
            <div class="row g-3">
                <div class="col-md-3">
                    <a href="{{ route('invoices.create', ['type' => 'in']) }}" class="btn btn-light w-100 py-3 border rounded-3 d-flex align-items-center justify-content-center gap-3 hover-shadow">
                        <i class="fas fa-plus-circle text-success fs-4"></i>
                        <span class="fw-bold text-dark">تسجيل وارد</span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('invoices.create', ['type' => 'out']) }}" class="btn btn-light w-100 py-3 border rounded-3 d-flex align-items-center justify-content-center gap-3 hover-shadow">
                        <i class="fas fa-minus-circle text-danger fs-4"></i>
                        <span class="fw-bold text-dark">تسجيل صادر</span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('items.create') }}" class="btn btn-light w-100 py-3 border rounded-3 d-flex align-items-center justify-content-center gap-3 hover-shadow">
                        <i class="fas fa-barcode text-primary fs-4"></i>
                        <span class="fw-bold text-dark">إضافة مادة جديدة</span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('inventory.index') }}" class="btn btn-dark w-100 py-3 rounded-3 d-flex align-items-center justify-content-center gap-3 shadow transition-all hover:scale-105">
                        <i class="fas fa-box text-warning fs-4"></i>
                        <span class="fw-bold text-white">نظام الجرد</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden border">
                    <div class="card-header bg-white py-4 border-0">
                        <div class="d-flex justify-content-between align-items-center px-2">
                            <h5 class="fw-bold m-0 text-dark"><i class="fas fa-history me-2 text-muted"></i> سجل الحركات</h5>
                            <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 font-bold">عرض الكل</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-center">
                            <thead class="bg-light border-top text-muted small fw-bold">
                                <tr>
                                    <th class="py-3">النوع</th>
                                    <th>التاريخ</th>
                                    <th>المادة</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $activity)
                                <tr>
                                    <td>
                                        <span class="badge {{ $activity->type == 'in' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} border px-3 py-2 rounded-pill">
    {{ $activity->type == 'in' ? 'وارد' : 'صادر' }}
</span>
                                    </td>
                                    <td class="text-muted small">{{ $activity->date }}</td>
<td class="fw-bold">
    <a href="{{ route('items.show', $activity->item_id) }}" class="text-decoration-none fw-bold text-dark">
        {{ $activity->item_name }} 
    </a>
</td>
                                    <td class="fw-bold text-dark">{{ $activity->quantity }}
                                    <td class="text-dark">{{ $activity->price }}
                                </tr>
                                @empty
                                <tr><td colspan="5" class="py-5 text-muted">لا توجد حركات مسجلة</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100" dir="rtl">
    <div class="card-body">
        <div class="d-flex align-items-center mb-3">
            <div class="text-start w-100">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-exclamation-triangle text-warning me-1"></i> أصناف راكدة
                </h5>
                <small class="text-muted">لم تُبع منذ 30 يوماً</small>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-borderless align-middle">
                <thead class="text-muted border-bottom">
                    <tr>
                        <th class="py-2 text-right">المادة</th>   <th class="py-2 text-center">الرصيد</th>
                        <th class="py-2 text-center">آخر حركة</th>
                        <th class="py-2 text-left">الحالة</th>    </tr>
                </thead>
                <tbody>
                    @forelse($stagnantItems as $item)
                    <tr>
                        <td class="text-right fw-bold text-dark">{{ $item->name }}</td>
                        <td class="text-center fw-bold">{{ $item->quantity }}</td>
                        <td class="text-center text-muted small">{{ $item->updated_at->format('Y-m-d') }}</td>
                        <td class="text-left">
                            <span class="badge bg-light text-secondary border-0">راكد</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-muted">لا توجد أصناف راكدة حالياً</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8fafc; color: #1e293b; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .hover-card { transition: all 0.3s ease; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1) !important; cursor: pointer; }
    .hover-shadow:hover { background-color: #fff !important; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    .transition-all { transition: all 0.2s ease-in-out; }
</style>
@endsection