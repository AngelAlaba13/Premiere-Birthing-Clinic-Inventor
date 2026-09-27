<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite([
        'resources/css/app.css',
        'resources/js/darkMode.js',
        'resources/js/inventory.js'
    ])

    <title>Inventory</title>
</head>

<body class="min-h-screen bg-[#f5f8fb] text-slate-800 transition-colors duration-200 dark:bg-slate-950 dark:text-slate-100">

    <div class="mx-auto max-w-7xl px-6 py-10">

        <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <a
                    href="{{ route('dashboard') }}"
                    class="mb-3 inline-block text-sm font-medium text-blue-600 transition hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                >
                    ← Dashboard
                </a>

                <p class="mb-1 text-xs font-semibold uppercase tracking-wider text-sky-600 dark:text-sky-400">
                    Clinic Inventory
                </p>

                <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Inventory
                </h1>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Manage medicines and supplies.
                </p>
            </div>

            <a
                href="{{ route('inventory.create') }}"
                class="rounded-xl bg-[#1769aa] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#145d97] focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2"
            >
                Add Inventory Item
            </a>

        </div>

        @if (session('success'))

            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-900/50 dark:bg-green-950/40 dark:text-green-300">
                {{ session('success') }}
            </div>

        @endif

        @if (session('error'))

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-300">
                {{ session('error') }}
            </div>

        @endif

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-colors duration-200 dark:border-slate-800 dark:bg-slate-900">

            @if ($items->count())

                <div class="border-b border-slate-200 p-5 dark:border-slate-800">

                    <div class="flex flex-col gap-3 lg:flex-row">

                        <div class="flex-1">

                            <input
                                type="text"
                                id="searchInput"
                                placeholder="Search item name..."
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:placeholder:text-slate-500 dark:focus:border-sky-500 dark:focus:bg-slate-800 dark:focus:ring-sky-900/40"
                            >

                        </div>

                        <div class="w-full lg:w-52">

                            <select
                                id="categoryFilter"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:border-sky-500 dark:focus:bg-slate-800 dark:focus:ring-sky-900/40"
                            >

                                <option value="all">
                                    All Categories
                                </option>

                                @foreach ($items->pluck('category.name')->unique()->sort() as $category)

                                    <option value="{{ strtolower($category) }}">
                                        {{ $category }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="w-full lg:w-52">

                            <select
                                id="statusFilter"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:border-sky-500 dark:focus:bg-slate-800 dark:focus:ring-sky-900/40"
                            >

                                <option value="all">
                                    All Status
                                </option>

                                <option value="normal">
                                    Normal
                                </option>

                                <option value="expiring">
                                    Expiring Soon
                                </option>

                                <option value="expired">
                                    Expired
                                </option>

                                <option value="low-stock">
                                    Low Stock
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <div
                    id="noResults"
                    class="hidden px-6 py-12 text-center"
                >

                    <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                        No matching inventory items
                    </h2>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Try changing your search or filters.
                    </p>

                </div>

                <div class="overflow-x-auto">

                    <table
                        id="inventoryTable"
                        class="w-full text-sm"
                    >

                        <thead class="border-b border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-800/60">

                            <tr>

                                <th
                                    data-sort="item"
                                    class="sortable cursor-pointer px-6 py-4 text-left font-semibold text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                                >
                                    Item
                                    <span class="sort-icon"></span>
                                </th>

                                <th
                                    data-sort="category"
                                    class="sortable cursor-pointer px-6 py-4 text-left font-semibold text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                                >
                                    Category
                                    <span class="sort-icon"></span>
                                </th>

                                <th
                                    data-sort="display"
                                    class="sortable cursor-pointer px-6 py-4 text-center font-semibold text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                                >
                                    In Display
                                    <span class="sort-icon"></span>
                                </th>

                                <th
                                    data-sort="stock"
                                    class="sortable cursor-pointer px-6 py-4 text-center font-semibold text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                                >
                                    In Stock
                                    <span class="sort-icon"></span>
                                </th>

                                <th
                                    data-sort="total"
                                    class="sortable cursor-pointer px-6 py-4 text-center font-semibold text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                                >
                                    Total
                                    <span class="sort-icon"></span>
                                </th>

                                <th class="px-6 py-4 text-left font-semibold text-slate-600 dark:text-slate-300">
                                    Unit
                                </th>

                                <th
                                    data-sort="expiry"
                                    class="sortable cursor-pointer px-6 py-4 text-left font-semibold text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                                >
                                    Expiry
                                    <span class="sort-icon"></span>
                                </th>

                                <th class="px-6 py-4 text-left font-semibold text-slate-600 dark:text-slate-300">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right font-semibold text-slate-600 dark:text-slate-300">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody
                            id="inventoryBody"
                            class="divide-y divide-slate-100 dark:divide-slate-800"
                        >

                            @foreach ($items as $item)

                                @php

                                    $nearestExpiry = $item->expiries
                                        ->sortBy('expiry_date')
                                        ->first();

                                    $daysUntilExpiry = null;

                                    if ($nearestExpiry) {
                                        $daysUntilExpiry = now()
                                            ->startOfDay()
                                            ->diffInDays(
                                                $nearestExpiry->expiry_date->startOfDay(),
                                                false
                                            );
                                    }

                                    $isExpired =
                                        $daysUntilExpiry !== null &&
                                        $daysUntilExpiry < 0;

                                    $isExpiringSoon =
                                        $daysUntilExpiry !== null &&
                                        $daysUntilExpiry >= 0 &&
                                        $daysUntilExpiry <= 30;

                                    $isLowStock = $item->total_quantity <= 10;

                                    if ($isExpired) {
                                        $status = 'expired';
                                    } elseif ($isExpiringSoon) {
                                        $status = 'expiring';
                                    } elseif ($isLowStock) {
                                        $status = 'low-stock';
                                    } else {
                                        $status = 'normal';
                                    }

                                @endphp

                                <tr
                                    class="inventory-row transition hover:bg-slate-50 dark:hover:bg-slate-800/50"
                                    data-item="{{ strtolower($item->item_name) }}"
                                    data-category="{{ strtolower($item->category->name) }}"
                                    data-status="{{ $status }}"
                                    data-display="{{ $item->in_display }}"
                                    data-stock="{{ $item->in_stock }}"
                                    data-total="{{ $item->total_quantity }}"
                                    data-expiry="{{ $nearestExpiry ? $nearestExpiry->expiry_date->timestamp : PHP_INT_MAX }}"
                                >

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-800 dark:text-slate-100">
                                            {{ $item->item_name }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">

                                        <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-950/50 dark:text-blue-300">
                                            {{ $item->category->name }}
                                        </span>

                                    </td>

                                    <td class="px-6 py-4 text-center text-slate-700 dark:text-slate-300">
                                        {{ $item->in_display }}
                                    </td>

                                    <td class="px-6 py-4 text-center">

                                        @if ($isLowStock)

                                            <span class="font-semibold text-orange-600 dark:text-orange-400">
                                                {{ $item->in_stock }}
                                            </span>

                                        @else

                                            <span class="text-slate-700 dark:text-slate-300">
                                                {{ $item->in_stock }}
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4 text-center">

                                        <span class="font-semibold text-slate-800 dark:text-white">
                                            {{ $item->total_quantity }}
                                        </span>

                                    </td>

                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                        {{ $item->unit }}
                                    </td>

                                    <td class="px-6 py-4">

                                        @if ($item->expiries->count())

                                            <div class="space-y-1">

                                                @foreach ($item->expiries->sortBy('expiry_date') as $expiry)

                                                    @php

                                                        $expiryDays = now()
                                                            ->startOfDay()
                                                            ->diffInDays(
                                                                $expiry->expiry_date->startOfDay(),
                                                                false
                                                            );

                                                    @endphp

                                                    <div class="text-xs">

                                                        <span class="font-medium text-slate-700 dark:text-slate-300">
                                                            {{ $expiry->batch_number }}
                                                        </span>

                                                        <span class="text-slate-400">
                                                            —
                                                        </span>

                                                        @if ($expiryDays < 0)

                                                            <span class="font-medium text-red-600 dark:text-red-400">
                                                                {{ $expiry->expiry_date->format('M d, Y') }}
                                                            </span>

                                                        @elseif ($expiryDays <= 30)

                                                            <span class="font-medium text-orange-600 dark:text-orange-400">
                                                                {{ $expiry->expiry_date->format('M d, Y') }}
                                                            </span>

                                                        @else

                                                            <span class="text-slate-600 dark:text-slate-400">
                                                                {{ $expiry->expiry_date->format('M d, Y') }}
                                                            </span>

                                                        @endif

                                                    </div>

                                                @endforeach

                                            </div>

                                        @else

                                            <span class="text-slate-400 dark:text-slate-500">
                                                No expiry
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4">

                                        @if ($isExpired)

                                            <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-950/50 dark:text-red-300">
                                                Expired
                                            </span>

                                        @elseif ($isExpiringSoon)

                                            <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-medium text-orange-700 dark:bg-orange-950/50 dark:text-orange-300">
                                                Expiring Soon
                                            </span>

                                        @elseif ($isLowStock)

                                            <span class="inline-flex items-center rounded-full bg-yellow-50 px-3 py-1 text-xs font-medium text-yellow-700 dark:bg-yellow-950/50 dark:text-yellow-300">
                                                Low Stock
                                            </span>

                                        @else

                                            <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-950/50 dark:text-green-300">
                                                Normal
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex items-center justify-end gap-2">

                                            <a
                                                href="{{ route('inventory.show', $item) }}"
                                                class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-medium text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route('inventory.edit', $item) }}"
                                                class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-medium text-blue-600 transition hover:bg-blue-100 dark:border-blue-900 dark:bg-blue-950/50 dark:text-blue-300 dark:hover:bg-blue-950"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('inventory.destroy', $item) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this inventory item?');"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-100 dark:border-red-900 dark:bg-red-950/50 dark:text-red-300 dark:hover:bg-red-950"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="px-6 py-16 text-center">

                    <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                        No inventory items yet
                    </h2>

                    <p class="mt-1 mb-6 text-sm text-slate-500 dark:text-slate-400">
                        Start by adding your first medicine or supply.
                    </p>

                    <a
                        href="{{ route('inventory.create') }}"
                        class="inline-flex rounded-xl bg-[#1769aa] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#145d97]"
                    >
                        Add Inventory Item
                    </a>

                </div>

            @endif

        </div>

    </div>

</body>

</html>