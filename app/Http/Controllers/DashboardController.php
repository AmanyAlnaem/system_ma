<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. الإحصائيات الأساسية
        $totalItems = Item::count();
        $inCount = Invoice::where('type', 'in')->where('user_id', Auth::id())->count();
        $outCount = Invoice::where('type', 'out')->where('user_id', Auth::id())->count();

        // 2. جلب آخر 10 عمليات (سجل الحركات التفصيلي)
        $recentActivities = DB::table('invoice_items')
            ->join('items', 'invoice_items.item_id', '=', 'items.id')
            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->select(
                'items.id as item_id', // التأكد من جلب المعرف بهذا المسمى
                'items.name as item_name',
                'invoices.type',
                'invoices.date',
                'invoice_items.quantity',
                'invoice_items.price'
            )
            ->orderBy('invoices.date', 'desc')
            ->take(5)
            ->get();

        // 3. الأصناف الأكثر طلباً (حسب كمية المبيعات)
        $topSellingItems = Item::withSum(['invoiceItems as total_qty' => function ($query) {
            $query->whereHas('invoice', fn($q) => $q->where('type', 'out'));
        }], 'quantity')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // 4. الأصناف الراكدة (لم تبع منذ 30 يوماً)
        $stagnantItems = Item::where('quantity', '>', 0) // فقط المواد التي لها رصيد فعلي
            ->whereDoesntHave('invoices', function ($query) {
                $query->where('invoices.created_at', '>=', now()->subDays(30));
            })->get();

        // 5. الأرباح الإجمالية وقيمة المستودع
        // ملاحظة: تعتمد هذه الحسابات على الـ Accessors في موديل Item
        $items = Item::all();
        $totalProfit = $items->sum->profit;
        $totalInventoryValue = $items->sum(function ($item) {
            return $item->balance * $item->avg_purchase_price;
        });

        // 6. الأكثر ربحاً 
        $mostProfitableItems = $items->sortByDesc('profit')->take(5);

        $activities = DB::table('invoice_items')
            ->join('items', 'items.id', '=', 'invoice_items.item_id')
            ->join('invoices', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->select(
                'invoices.type',
                'invoices.date',
                'items.name as item_name',
                'items.id as item_id', 
                'invoice_items.quantity',
                'invoice_items.price'
            )
            ->orderBy('invoices.date', 'desc')
            ->take(10)
            ->get();

        // حساب الإحصائيات بدقة (عدد الفواتير وليس المواد)
        $inCount = Invoice::where('type', 'in')->count();
        $outCount = Invoice::where('type', 'out')->count();


        return view('dashboard', compact(
            'totalItems',
            'inCount',
            'outCount',
            'totalProfit',
            'totalInventoryValue',
            'topSellingItems',
            'mostProfitableItems',
            'stagnantItems',
            'recentActivities',
            'activities'
        ));
    }

    /**
     * تقرير بطاقة حركة المادة (تقرير يومي)
     */
    public function itemLedger($id)
    {
        $item = Item::with(['invoiceItems.invoice'])->findOrFail($id);

        // ترتيب الحركات من الأحدث إلى الأقدم
        $ledger = $item->invoiceItems->sortByDesc(fn($ii) => $ii->invoice->date);

        return view('reports.item_ledger', compact('item', 'ledger'));
    }

    public function dailyReport()
{
    $today = now()->format('Y-m-d');

    // إجمالي المشتريات (الوارد) اليوم
    $totalPurchases = DB::table('invoice_items')
        ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
        ->where('invoices.type', 'in')
        ->whereDate('invoices.date', $today)
        ->sum(DB::raw('quantity * price'));

    // إجمالي المبيعات (الصادر) اليوم
    $totalSales = DB::table('invoice_items')
        ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
        ->where('invoices.type', 'out')
        ->whereDate('invoices.date', $today)
        ->sum(DB::raw('quantity * price'));

    // حركات اليوم التفصيلية
    $dailyActivities = DB::table('invoice_items')
        ->join('items', 'invoice_items.item_id', '=', 'items.id')
        ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
        ->select('items.name', 'invoices.type', 'invoice_items.quantity', 'invoice_items.price', 'invoices.date')
        ->whereDate('invoices.date', $today)
        ->get();

    return view('reports.daily', compact('totalPurchases', 'totalSales', 'dailyActivities', 'today'));
}
}
