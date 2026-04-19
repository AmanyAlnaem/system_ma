@extends('layouts.app')

@section('content')
<div class="container py-4" dir="rtl">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-primary">بطاقة حركة المادة: {{ $item->name }}</h5>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">عودة للوحة التحكم</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-center align-middle" dir="rtl">
                    <thead class="bg-light">
                        <tr>
                            <th>التاريخ</th>
                            <th>نوع الحركة</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($item->invoices as $invoice)
                        <tr>
                            <td class="text-muted small">{{ $invoice->date }}</td>
                            <td>
                                <span class="badge {{ $invoice->type == 'in' ? 'bg-success-light text-success' : 'bg-danger-light text-danger' }} border-0">
                                    {{ $invoice->type == 'in' ? 'وارد' : 'صادر' }}
                                </span>
                            </td>
                            <td class="fw-bold">{{ $invoice->pivot->quantity }}</td>
                            <td>{{ number_format($invoice->pivot->price, 2) }}</td>
                            <td class="text-primary fw-bold">{{ number_format($invoice->pivot->quantity * $invoice->pivot->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection