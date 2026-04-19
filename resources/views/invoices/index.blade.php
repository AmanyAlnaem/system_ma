@extends('layouts.app')

@section('content')
<div class="container py-4" dir="rtl">
    {{-- إضافة العناوين الديناميكية بناءً على نوع الحركة --}}
    @if(isset($type) && $type == 'in')
        <h3 class="mb-4 text-success"><i class="fas fa-download"></i> سجل حركات الوارد</h3>
    @elseif(isset($type) && $type == 'out')
        <h3 class="mb-4 text-danger"><i class="fas fa-upload"></i> سجل حركات الصادر</h3>
    @else
        <h3 class="mb-4 text-dark"><i class="fas fa-file-invoice"></i> {{ $pageTitle ?? 'سجل الفواتير' }}</h3>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">التفاصيل</h5>
            <div class="btn-group">
                <a href="{{ route('invoices.create', ['type' => 'in']) }}" class="btn btn-sm btn-outline-success">وارد جديد</a>
                <a href="{{ route('invoices.create', ['type' => 'out']) }}" class="btn btn-sm btn-outline-danger">صادر جديد</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>رقم الفاتورة</th>
                            <th>التاريخ</th>
                            <th>المادة</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>الإجمالي</th>
                            <th>المستخدم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                            @foreach($invoice->items as $detail)
                            <tr>
                                <td class="fw-bold">{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->date }}</td>
                                <td>{{ $detail->name }}</td>
                                {{-- استخدام الـ pivot للوصول للكمية والسعر في جدول الربط --}}
                                <td>{{ $detail->pivot->quantity }}</td>
                                <td>{{ number_format($detail->pivot->price, 2) }}</td>
                                <td class="text-primary fw-bold">
                                    {{ number_format($detail->pivot->quantity * $detail->pivot->price, 2) }}
                                </td>
                                <td>
                                    <small class="text-muted"><i class="fas fa-user me-1"></i>{{ $invoice->user->name }}</small>
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection