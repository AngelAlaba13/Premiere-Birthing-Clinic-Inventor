<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\InventoryItem;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $soon = $today->copy()->addDays(30);

        $items = InventoryItem::with(['category', 'expiries'])
            ->latest()
            ->get();

        $totalItems = $items->count();

        $lowStock = $items->filter(function ($item) {
            return $item->total_quantity <= 10;
        })->count();

        $expired = $items->filter(function ($item) use ($today) {
            return $item->expiries->contains(function ($expiry) use ($today) {
                return $expiry->expiry_date->lt($today);
            });
        })->count();

        $expiringSoon = $items->filter(function ($item) use ($today, $soon) {
            return $item->expiries->contains(function ($expiry) use ($today, $soon) {
                return $expiry->expiry_date->between($today, $soon);
            });
        })->count();

        $totalQuantity = $items->sum(function ($item) {
            return $item->total_quantity;
        });

        $categoryStats = Category::withCount('inventoryItems')
            ->orderByDesc('inventory_items_count')
            ->get();

        $upcomingExpiries = $items
            ->flatMap(function ($item) {
                return $item->expiries->map(function ($expiry) use ($item) {
                    return [
                        'item_name' => $item->item_name,
                        'batch_number' => $expiry->batch_number,
                        'expiry_date' => $expiry->expiry_date,
                    ];
                });
            })
            ->sortBy('expiry_date')
            ->take(5);

        $recentItems = $items->take(5);

        return view('dashboard', compact(
            'totalItems',
            'lowStock',
            'expiringSoon',
            'expired',
            'totalQuantity',
            'categoryStats',
            'upcomingExpiries',
            'recentItems'
        ));
    }
}