@extends('layouts.app')

@section('content')
<div class="container py-4" dir="rtl">
    {{-- عرض رسائل الخطأ إن وجدت --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
        @csrf
        {{-- تحديد نوع الفاتورة --}}
        <input type="hidden" name="type" value="{{ $type }}">
        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
               <h5 class="mb-0">
    إشناء فاتورة {{ $type == 'out' ? 'صادر' : 'وارد' }}
</h5>
                <div class="w-25">
                    <label class="form-label fw-bold">رقم الفاتورة</label>
        <input type="text" 
               name="invoice_number" 
               class="form-control bg-light fw-bold text-blak" 
               value="{{ $generatedCode }}" 
               readonly>
                </div>
            </div>
            
            <div class="card-body">
                {{-- حقل التاريخ --}}
                <div class="row mb-4">
                    <div class="col-md-4">
        <label class="form-label fw-bold">تاريخ الفاتورة</label>
        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
    </div>
                </div>

                {{-- جدول المواد --}}
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="items-table">
                        <thead class="table-light">
                            <tr>
                                <th>المادة</th>
                                <th width="150">الكمية</th>
                                <th width="150">السعر</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
    <select name="items[0][item_id]" class="form-control" required>
        <option value="">اختر المادة...</option>
        @foreach($items as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
    </select>
</td>
<td>
    <input type="number" name="items[0][quantity]" class="form-control" required>
</td>
<td>
    <input type="number" name="items[0][price]" class="form-control" required>
</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addRow()">
                    <i class="fas fa-plus"></i> إضافة مادة أخرى
                </button>
            </div>
            
            <div class="card-footer bg-light py-3 text-end">
                <button type="submit" class="btn btn-success px-5 fw-bold">
                    حفظ وتأكيد الفاتورة
                </button>
            </div>
        </div>
    </form>
</div>

{{-- سكريبت إضافة الأسطر ديناميكياً --}}
<script>
    let rowIdx = 1;
    function addRow() {
        const tbody = document.querySelector('#items-table tbody');
        const newRow = `
            <tr>
                <td>
                    <select name="items[${rowIdx}][id]" class="form-select" required>
                        <option value="">اختر المادة...</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="items[${rowIdx}][qty]" class="form-control" min="1" required></td>
                <td><input type="number" step="0.01" name="items[${rowIdx}][price]" class="form-control" required></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>`;
        tbody.insertAdjacentHTML('beforeend', newRow);
        rowIdx++;
    }

    // لمنع الإرسال المتكرر عند الضغط أكثر من مرة
    document.getElementById('invoiceForm').addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = 'جاري الحفظ...';
    });
</script>
@endsection