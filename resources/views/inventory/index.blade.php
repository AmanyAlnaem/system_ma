@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">

<div class="min-h-screen bg-[#f1f5f9] p-4 md:p-8" dir="rtl" style="font-family: 'Tajawal', sans-serif;">
    <div class="max-w-7xl mx-auto">
        
        <div class="bg-white rounded-3xl shadow-sm p-6 mb-8 border border-slate-200">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-6">
                <div>
                    <h1 class="text-2xl font-black text-slate-800">تحليل حركة المستودع الذكي</h1>
                    <p class="text-slate-500 text-sm mt-1">مراقبة دقيقة للوارد والصادر حسب الفترات الزمنية والمواد</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('dashboard') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-5 py-2.5 rounded-xl transition-all font-bold text-sm flex items-center gap-2">
                        <i class="fas fa-home"></i> لوحة التحكم
                    </a>
                </div>
            </div>

            <form action="{{ route('inventory.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 items-end border-t pt-6">
                <div class="flex flex-col">
                    <label class="text-xs font-bold text-slate-500 mb-2 mr-2">اسم المادة</label>
                    <select name="item_id" class="bg-slate-50 border border-slate-200 text-sm rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                        <option value="">كل المواد</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col">
                    <label class="text-xs font-bold text-slate-500 mb-2 mr-2">خيارات سريعة</label>
                    <select name="period" class="bg-slate-50 border border-slate-200 text-sm rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                        <option value="">اختر الفترة...</option>
                        <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>اليوم</option>
                        <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>هذا الأسبوع</option>
                        <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>هذا الشهر</option>
                        <option value="quarter" {{ request('period') == 'quarter' ? 'selected' : '' }}>ربع سنة (3 أشهر)</option>
                        <option value="half" {{ request('period') == 'half' ? 'selected' : '' }}>نصف سنة (6 أشهر)</option>
                        <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>سنة كاملة</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label class="text-xs font-bold text-slate-500 mb-2 mr-2">من تاريخ</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="bg-slate-50 border border-slate-200 text-sm rounded-xl px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex flex-col">
                    <label class="text-xs font-bold text-slate-500 mb-2 mr-2">إلى تاريخ</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="bg-slate-50 border border-slate-200 text-sm rounded-xl px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="lg:col-span-2 flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl transition-all shadow-lg shadow-blue-200 flex-1 font-bold">
                        <i class="fas fa-filter ml-2"></i> تطبيق الفلترة
                    </button>
                    <a href="{{ route('inventory.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-500 px-4 py-2.5 rounded-xl transition-all flex items-center justify-center border border-slate-200">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-emerald-100 text-emerald-600 p-4 rounded-2xl"><i class="fas fa-file-import fa-lg"></i></div>
                    <div><p class="text-slate-500 text-xs font-bold">إجمالي الوارد</p><h4 class="text-2xl font-black text-slate-800">{{ $stats->where('type', 'in')->sum('quantity') }}</h4></div>
                </div>
                <div class="text-emerald-500 text-xs font-bold bg-emerald-50 px-2 py-1 rounded-lg">+100%</div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-rose-100 text-rose-600 p-4 rounded-2xl"><i class="fas fa-file-export fa-lg"></i></div>
                    <div><p class="text-slate-500 text-xs font-bold">إجمالي الصادر</p><h4 class="text-2xl font-black text-slate-800">{{ $stats->where('type', 'out')->sum('quantity') }}</h4></div>
                </div>
                <div class="text-rose-500 text-xs font-bold bg-rose-50 px-2 py-1 rounded-lg">-100%</div>
            </div>

            <div class="bg-slate-800 p-6 rounded-3xl shadow-xl flex items-center gap-4 border-b-4 border-blue-500">
                <div class="bg-slate-700 text-blue-400 p-4 rounded-2xl"><i class="fas fa-calculator fa-lg"></i></div>
                <div><p class="text-slate-400 text-xs font-bold">صافي الحركة</p><h4 class="text-2xl font-black text-white">{{ $stats->where('type', 'in')->sum('quantity') - $stats->where('type', 'out')->sum('quantity') }}</h4></div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 mb-8 transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-10">
                <h3 class="font-bold text-slate-800 flex items-center gap-3 text-lg">
                    <span class="w-2.5 h-8 bg-blue-600 rounded-full"></span>
                    تحليل حركة الوارد والصادر (بياني)
                </h3>
                <div class="flex items-center gap-6 text-[10px] font-black tracking-widest uppercase">
                    <span class="flex items-center gap-2"><span class="w-4 h-4 bg-emerald-500 rounded-full shadow-inner"></span> وارد (+)</span>
                    <span class="flex items-center gap-2"><span class="w-4 h-4 bg-rose-500 rounded-full shadow-inner"></span> صادر (-)</span>
                </div>
            </div>
            <div class="relative h-[450px]">
                <canvas id="inventoryAnalysisChart"></canvas>
            </div>
        </div>

    </div>
</div>

<script>
    const ctx = document.getElementById('inventoryAnalysisChart').getContext('2d');
    
    // إنشاء تدرج لوني احترافي
    const greenGradient = ctx.createLinearGradient(0, 0, 0, 450);
    greenGradient.addColorStop(0, 'rgba(16, 185, 129, 0.25)');
    greenGradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

    const redGradient = ctx.createLinearGradient(0, 0, 0, 450);
    redGradient.addColorStop(0, 'rgba(239, 68, 68, 0.15)');
    redGradient.addColorStop(1, 'rgba(239, 68, 68, 0)');

    // تجهيز البيانات القادمة من الكنترولر
    const chartLabels = {!! json_encode($stats->pluck('date')->unique()->values()) !!};
    const inData = {!! json_encode($stats->where('type', 'in')->pluck('quantity')) !!};
    const outData = {!! json_encode($stats->where('type', 'out')->pluck('quantity')) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels.length > 0 ? chartLabels : ['لا بيانات'],
            datasets: [{
                label: 'وارد',
                data: inData.length > 0 ? inData : [0],
                borderColor: '#10b981',
                borderWidth: 4,
                backgroundColor: greenGradient,
                fill: true,
                tension: 0.4, // لجعل الخط منحني وانسيابي
                pointRadius: 6,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#10b981',
                pointBorderWidth: 3,
                pointHoverRadius: 8
            }, {
                label: 'صادر',
                data: outData.length > 0 ? outData : [0],
                borderColor: '#ef4444',
                borderWidth: 4,
                backgroundColor: redGradient,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#ef4444',
                pointBorderWidth: 3,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 15,
                    titleFont: { size: 14, family: 'Tajawal' },
                    bodyFont: { size: 13, family: 'Tajawal' },
                    cornerRadius: 12,
                    displayColors: true
                }
            },
            scales: {
                y: {
                    grid: { color: '#f1f5f9', drawBorder: false },
                    ticks: { font: { family: 'Tajawal', weight: 'bold' }, color: '#64748b' }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Tajawal', weight: 'bold' }, color: '#64748b' }
                }
            }
        }
    });
</script>

<style>
    /* تحسينات إضافية للتوافق مع شاشات الجوال */
    input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        opacity: 0.6;
        filter: invert(0.5);
    }
</style>
@endsection