<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        (() => {
            const savedTheme = localStorage.getItem('theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <title>Premiere Birthing Clinic | Dashboard</title>

    @vite([
        'resources/css/app.css',
        'resources/js/darkMode.js',
        'resources/js/app.js'
    ])
</head>

<body class="min-h-screen bg-[#f5f8fb] text-slate-800 transition-colors duration-200 dark:bg-slate-950 dark:text-slate-100">

    <div class="flex min-h-screen">

        <aside class="flex w-64 flex-col border-r border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-200 px-6 py-6 dark:border-slate-800">

                <h1 class="text-xl font-bold text-slate-900 dark:text-white">
                    Premiere Birthing Clinic
                </h1>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Inventory System
                </p>

            </div>

            <nav class="flex-1 space-y-2 px-4 py-6">

                <a
                    href="{{ route('dashboard') }}"
                    class="flex rounded-lg bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700 dark:bg-blue-950/50 dark:text-blue-300"
                >
                    Dashboard
                </a>

                <a
                    href="{{ route('inventory.index') }}"
                    class="flex rounded-lg px-4 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white"
                >
                    Inventory
                </a>

            </nav>

            <div class="border-t border-slate-200 px-6 py-5 dark:border-slate-800">

                <p class="text-xs text-slate-400 dark:text-slate-500">
                    Inventory Management System
                </p>

                <p class="mt-1 text-sm font-medium text-slate-700 dark:text-slate-300">
                    Premiere Birthing Clinic
                </p>

            </div>

        </aside>

        <main class="min-w-0 flex-1">

            <header class="border-b border-slate-200 bg-white px-8 py-6 dark:border-slate-800 dark:bg-slate-900">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Overview
                        </p>

                        <h2 class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">
                            Inventory Dashboard
                        </h2>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Monitor stock levels and medicine expiry status.
                        </p>

                    </div>

                    <div class="flex items-center gap-3">

                        <button
                            type="button"
                            id="themeToggle"
                            class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300"
                        >
                            <span id="themeLabel">Dark Mode</span>
                        </button>

                        <a
                            href="{{ route('inventory.create') }}"
                            class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700"
                        >
                            Add Item
                        </a>

                    </div>

                </div>

            </header>

            <div class="space-y-8 p-8">

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

                    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Total Items
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                            {{ $totalItems }}
                        </p>

                        <p class="mt-4 text-xs text-slate-400 dark:text-slate-500">
                            Different inventory items
                        </p>

                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Total Quantity
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                            {{ number_format($totalQuantity) }}
                        </p>

                        <p class="mt-4 text-xs text-slate-400 dark:text-slate-500">
                            Items currently recorded
                        </p>

                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Expiring Soon
                        </p>

                        <p class="mt-2 text-3xl font-bold text-orange-600 dark:text-orange-400">
                            {{ $expiringSoon }}
                        </p>

                        <p class="mt-4 text-xs text-slate-400 dark:text-slate-500">
                            Within the next 30 days
                        </p>

                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Expired
                        </p>

                        <p class="mt-2 text-3xl font-bold text-red-600 dark:text-red-400">
                            {{ $expired }}
                        </p>

                        <p class="mt-4 text-xs text-slate-400 dark:text-slate-500">
                            Items with expired batches
                        </p>

                    </div>

                </div>

                <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                            <h3 class="font-semibold text-slate-900 dark:text-white">
                                Inventory by Category
                            </h3>

                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                Number of items in each category.
                            </p>

                        </div>

                        <div class="space-y-5 p-6">

                            @forelse ($categoryStats as $category)

                                @php
                                    $percentage = $totalItems > 0
                                        ? ($category->inventory_items_count / $totalItems) * 100
                                        : 0;
                                @endphp

                                <div>

                                    <div class="mb-2 flex items-center justify-between">

                                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                            {{ $category->name }}
                                        </span>

                                        <span class="text-sm text-slate-500 dark:text-slate-400">
                                            {{ $category->inventory_items_count }}
                                        </span>

                                    </div>

                                    <div class="h-2 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">

                                        <div
                                            class="h-full rounded-full bg-blue-600 dark:bg-blue-500"
                                            style="width: {{ $percentage }}%"
                                        ></div>

                                    </div>

                                </div>

                            @empty

                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                    No inventory categories available.
                                </p>

                            @endforelse

                        </div>

                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                            <h3 class="font-semibold text-slate-900 dark:text-white">
                                Stock Overview
                            </h3>

                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                Items requiring attention.
                            </p>

                        </div>

                        <div class="space-y-4 p-6">

                            <div class="flex items-center justify-between rounded-lg bg-red-50 px-4 py-4 dark:bg-red-950/30">

                                <div>

                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                        Expired Items
                                    </p>

                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        Require immediate attention
                                    </p>

                                </div>

                                <span class="text-lg font-bold text-red-600 dark:text-red-400">
                                    {{ $expired }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between rounded-lg bg-orange-50 px-4 py-4 dark:bg-orange-950/30">

                                <div>

                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                        Expiring Soon
                                    </p>

                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        Expiring within 30 days
                                    </p>

                                </div>

                                <span class="text-lg font-bold text-orange-600 dark:text-orange-400">
                                    {{ $expiringSoon }}
                                </span>

                            </div>

                            <div class="flex items-center justify-between rounded-lg bg-yellow-50 px-4 py-4 dark:bg-yellow-950/30">

                                <div>

                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                        Low Stock
                                    </p>

                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        10 units or fewer in total
                                    </p>

                                </div>

                                <span class="text-lg font-bold text-yellow-600 dark:text-yellow-400">
                                    {{ $lowStock }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                            <div>

                                <h3 class="font-semibold text-slate-900 dark:text-white">
                                    Upcoming Expiry
                                </h3>

                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    Next batches requiring attention.
                                </p>

                            </div>

                            <a
                                href="{{ route('inventory.index') }}"
                                class="text-sm font-medium text-blue-600 transition hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                            >
                                View all
                            </a>

                        </div>

                        <div class="divide-y divide-slate-100 dark:divide-slate-800">

                            @forelse ($upcomingExpiries as $expiry)

                                @php
                                    $days = now()->startOfDay()->diffInDays(
                                        $expiry['expiry_date'],
                                        false
                                    );
                                @endphp

                                <div class="flex items-center justify-between px-6 py-4">

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-medium text-slate-800 dark:text-slate-200">
                                            {{ $expiry['item_name'] }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                            Batch: {{ $expiry['batch_number'] }}
                                        </p>

                                    </div>

                                    <div class="ml-4 text-right">

                                        <p class="text-sm font-medium
                                            {{
                                                $days < 0
                                                    ? 'text-red-600 dark:text-red-400'
                                                    : ($days <= 30
                                                        ? 'text-orange-600 dark:text-orange-400'
                                                        : 'text-slate-700 dark:text-slate-300')
                                            }}"
                                        >
                                            {{ $expiry['expiry_date']->format('M d, Y') }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">

                                            @if ($days < 0)
                                                Expired
                                            @elseif ($days === 0)
                                                Expires today
                                            @elseif ($days === 1)
                                                1 day left
                                            @else
                                                {{ $days }} days left
                                            @endif

                                        </p>

                                    </div>

                                </div>

                            @empty

                                <div class="px-6 py-10 text-center">

                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        No expiry records available.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                            <div>

                                <h3 class="font-semibold text-slate-900 dark:text-white">
                                    Recently Added
                                </h3>

                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    Latest inventory records.
                                </p>

                            </div>

                            <a
                                href="{{ route('inventory.index') }}"
                                class="text-sm font-medium text-blue-600 transition hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                            >
                                View all
                            </a>

                        </div>

                        <div class="divide-y divide-slate-100 dark:divide-slate-800">

                            @forelse ($recentItems as $item)

                                <a
                                    href="{{ route('inventory.show', $item) }}"
                                    class="flex items-center justify-between px-6 py-4 transition hover:bg-slate-50 dark:hover:bg-slate-800/50"
                                >

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-medium text-slate-800 dark:text-slate-200">
                                            {{ $item->item_name }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                            {{ $item->category->name }} · {{ $item->unit }}
                                        </p>

                                    </div>

                                    <div class="ml-4 text-right">

                                        <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                            {{ number_format($item->total_quantity) }}
                                        </p>

                                        <p class="text-xs text-slate-400 dark:text-slate-500">
                                            total quantity
                                        </p>

                                    </div>

                                </a>

                            @empty

                                <div class="px-6 py-10 text-center">

                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        No inventory items available.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>

</body>

</html>