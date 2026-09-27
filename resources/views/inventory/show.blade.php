<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite([
        'resources/css/app.css',
        'resources/js/darkMode.js'
    ])

    <title>{{ $inventory->item_name }} | Inventory</title>
</head>

<body class="min-h-screen bg-gray-100 text-gray-800 transition-colors duration-200 dark:bg-slate-950 dark:text-slate-100">

    <div class="mx-auto max-w-5xl px-6 py-10">

        <div class="mb-8 flex items-center justify-between">

            <div>

                <a
                    href="{{ route('inventory.index') }}"
                    class="text-sm text-blue-600 transition hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                >
                    ← Back to Inventory
                </a>

                <h1 class="mt-3 text-3xl font-bold text-gray-800 dark:text-white">
                    {{ $inventory->item_name }}
                </h1>

                <p class="mt-1 text-gray-500 dark:text-slate-400">
                    Inventory item details
                </p>

            </div>

            <a
                href="{{ route('inventory.edit', $inventory) }}"
                class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-950"
            >
                Edit Item
            </a>

        </div>

        <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-colors duration-200 dark:border-slate-800 dark:bg-slate-900">

                <p class="text-sm text-gray-500 dark:text-slate-400">
                    In Display
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-800 dark:text-white">
                    {{ $inventory->in_display }}
                </p>

                <p class="mt-1 text-sm text-gray-400 dark:text-slate-500">
                    {{ $inventory->unit }}
                </p>

            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-colors duration-200 dark:border-slate-800 dark:bg-slate-900">

                <p class="text-sm text-gray-500 dark:text-slate-400">
                    In Stock
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-800 dark:text-white">
                    {{ $inventory->in_stock }}
                </p>

                <p class="mt-1 text-sm text-gray-400 dark:text-slate-500">
                    {{ $inventory->unit }}
                </p>

            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-colors duration-200 dark:border-slate-800 dark:bg-slate-900">

                <p class="text-sm text-gray-500 dark:text-slate-400">
                    Total Quantity
                </p>

                <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400">
                    {{ $inventory->total_quantity }}
                </p>

                <p class="mt-1 text-sm text-gray-400 dark:text-slate-500">
                    {{ $inventory->unit }}
                </p>

            </div>

        </div>

        <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-colors duration-200 dark:border-slate-800 dark:bg-slate-900">

            <h2 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white">
                Item Information
            </h2>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <div>

                    <p class="text-sm text-gray-500 dark:text-slate-400">
                        Item Name
                    </p>

                    <p class="mt-1 font-medium text-gray-800 dark:text-slate-100">
                        {{ $inventory->item_name }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500 dark:text-slate-400">
                        Category
                    </p>

                    <p class="mt-1 font-medium text-gray-800 dark:text-slate-100">
                        {{ $inventory->category->name }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500 dark:text-slate-400">
                        Unit
                    </p>

                    <p class="mt-1 font-medium text-gray-800 dark:text-slate-100">
                        {{ $inventory->unit }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500 dark:text-slate-400">
                        Date Added
                    </p>

                    <p class="mt-1 font-medium text-gray-800 dark:text-slate-100">
                        {{ $inventory->created_at->format('M d, Y h:i A') }}
                    </p>

                </div>

            </div>

        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-colors duration-200 dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-slate-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    Expiry Batches
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">
                    All registered batches and their expiry dates.
                </p>

            </div>

            @if ($inventory->expiries->count())

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="border-b border-gray-200 bg-gray-50 dark:border-slate-800 dark:bg-slate-800/60">

                            <tr>

                                <th class="px-6 py-4 text-left font-semibold text-gray-600 dark:text-slate-300">
                                    #
                                </th>

                                <th class="px-6 py-4 text-left font-semibold text-gray-600 dark:text-slate-300">
                                    Batch Number
                                </th>

                                <th class="px-6 py-4 text-left font-semibold text-gray-600 dark:text-slate-300">
                                    Expiry Date
                                </th>

                                <th class="px-6 py-4 text-left font-semibold text-gray-600 dark:text-slate-300">
                                    Status
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-slate-800">

                            @foreach ($inventory->expiries as $index => $expiry)

                                @php

                                    $daysUntilExpiry = now()->startOfDay()->diffInDays(
                                        $expiry->expiry_date->startOfDay(),
                                        false
                                    );

                                @endphp

                                <tr class="transition hover:bg-gray-50 dark:hover:bg-slate-800/50">

                                    <td class="px-6 py-4 text-gray-500 dark:text-slate-400">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-slate-100">
                                        {{ $expiry->batch_number }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-700 dark:text-slate-300">
                                        {{ $expiry->expiry_date->format('M d, Y') }}
                                    </td>

                                    <td class="px-6 py-4">

                                        @if ($daysUntilExpiry < 0)

                                            <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-950/50 dark:text-red-300">
                                                Expired
                                            </span>

                                        @elseif ($daysUntilExpiry <= 30)

                                            <span class="inline-flex rounded-full bg-orange-50 px-3 py-1 text-xs font-medium text-orange-700 dark:bg-orange-950/50 dark:text-orange-300">
                                                Expiring Soon
                                            </span>

                                        @else

                                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-950/50 dark:text-green-300">
                                                Valid
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="px-6 py-12 text-center text-sm text-gray-500 dark:text-slate-400">
                    No expiry batches have been registered.
                </div>

            @endif

        </div>

    </div>

</body>

</html>