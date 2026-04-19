<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'sku', 'quantity', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
      // حساب وسطي سعر البيع (Sales Average)
    public function getAvgSalesPriceAttribute()
    {
        return $this->invoiceItems()
            ->whereHas('invoice', fn($q) => $q->where('type', 'out'))
            ->avg('price') ?? 0;
    }
    // حساب الرصيد الحالي (المحرك الأساسي)
    public function getBalanceAttribute()
    {
        $in = $this->invoiceItems()->whereHas('invoice', fn($q) => $q->where('type', 'in'))->sum('quantity');
        $out = $this->invoiceItems()->whereHas('invoice', fn($q) => $q->where('type', 'out'))->sum('quantity');
        return $in - $out;
    }
    // حساب الأرباح
    public function getProfitAttribute()
    {
        $avgSales = $this->invoiceItems()->whereHas('invoice', fn($q) => $q->where('type', 'out'))->avg('price') ?? 0;
        $avgPurchase = $this->invoiceItems()->whereHas('invoice', fn($q) => $q->where('type', 'in'))->avg('price') ?? 0;
        $totalSold = $this->invoiceItems()->whereHas('invoice', fn($q) => $q->where('type', 'out'))->sum('quantity');
        return ($avgSales - $avgPurchase) * $totalSold;
    }

    // وسطي سعر الشراء لقيمة المستودع
    public function getAvgPurchasePriceAttribute()
    {
        return $this->invoiceItems()->whereHas('invoice', fn($q) => $q->where('type', 'in'))->avg('price') ?? 0;
    } 
    // تعريف العلاقة مع الفواتير
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function getReportAttribute()
    {
        $invoices = $this->invoices;

        // وسطي سعر الشراء
        $avgPurchase = $invoices->where('type', 'in')->avg('pivot.price') ?? 0;

        // وسطي سعر البيع
        $avgSales = $invoices->where('type', 'out')->avg('pivot.price') ?? 0;

        // إجمالي الكمية المباعة
        $totalSold = $invoices->where('type', 'out')->sum('pivot.quantity');

        return [
            'avg_purchase' => $avgPurchase,
            'avg_sales'    => $avgSales,
            'profit'       => ($avgSales - $avgPurchase) * $totalSold // ربح المادة
        ];
    }

    public function getStatsAttribute()
    {
        $invoices = $this->invoices;

        // وسطي سعر الشراء والبيع
        $avgIn = $invoices->where('type', 'in')->avg('pivot.price') ?? 0;
        $avgOut = $invoices->where('type', 'out')->avg('pivot.price') ?? 0;

        // الربح = (سعر البيع - سعر الشراء) * الكمية المباعة
        $totalSold = $invoices->where('type', 'out')->sum('pivot.quantity');
        $profit = ($avgOut - $avgIn) * $totalSold;

        return compact('avgIn', 'avgOut', 'profit', 'totalSold');
    }
}