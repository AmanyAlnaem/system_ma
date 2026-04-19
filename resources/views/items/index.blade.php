@extends('layouts.app')

@section('content')
<div class="container py-4" dir="rtl">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-primary">نظام الجرد والتقارير المالية</h5>
            <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">إضافة صنف جديد</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-center align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>المادة</th>
                            <th>الرصيد الحالي</th>
                            <th>وسطي الشراء</th> <th>وسطي البيع</th>  <th>ربح المادة</th>   <th>الحالة</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        @php 
                            $report = $item->report; // الوصول للحسابات من الموديل
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('items.show', $item->id) }}" class="text-decoration-none fw-bold text-dark">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td class="fw-bold {{ $item->quantity <= 5 ? 'text-danger' : '' }}">
                                {{ $item->quantity }}
                            </td>
                            <td class="text-muted">{{ number_format($report['avg_purchase'], 2) }}</td>
                            <td class="text-muted">{{ number_format($report['avg_sales'], 2) }}</td>
                            <td class="fw-bold text-success">
                                {{ number_format($report['profit'], 2) }}
                            </td>
                            <td>
                                @if($item->quantity > 0)
                                    <span class="badge bg-success-subtle text-success border-0">متوفر</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border-0">نفذت الكمية</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه المادة؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection