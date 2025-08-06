@extends('layouts.admin')

@section('content')
    <div class="bg-white dark:bg-gray-800 shadow sticky top-0 z-10 p-6 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Manajemen Pesanan</h2>
        <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="w-full md:w-1/2">
                <input type="text" name="search" placeholder="Cari nama atau ID..." value="{{ request('search') }}"
                       class="p-2 rounded border border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-200 w-full" />
            </form>
            <form action="{{ route('admin.orders.index') }}" method="GET" class="w-full md:w-auto">
                <select name="sort_by" onchange="this.form.submit()" class="p-2 border rounded border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-200 w-full md:w-auto">
                    <option value="newest" @selected(request('sort_by') == 'newest')>Terbaru</option>
                    <option value="status" @selected(request('sort_by') == 'status')>Status</option>
                </select>
            </form>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="text-center py-10 text-gray-500 dark:text-gray-400">
            <p>Tidak ada pesanan yang ditemukan.</p>
        </div>
    @else
        @foreach($orders as $order)
            @php
                $statusClasses = [
                    'Dipesan' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                    'Disiapkan' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                    'Dikirim' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
                    'Selesai' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                    'Dibatalkan' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                ];
            @endphp
            <div class="bg-white dark:bg-gray-800 p-4 rounded shadow my-4">
                <details>
                    <summary class="flex justify-between items-center cursor-pointer font-semibold text-gray-900 dark:text-white">
                        <span>Order #{{ $order->id }} - {{ $order->customer_name }}</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                            {{ $order->status }}
                        </span>
                    </summary>

                    <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Dibuat: {{ $order->created_at->locale('id')->diffForHumans() }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Status: <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">{{ $order->status }}</span></p>

                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="mt-2 flex items-center">
                            @csrf
                            @method('PATCH')
                            <label class="text-sm mr-2 text-gray-700 dark:text-gray-300">Ubah Status:</label>
                            <select name="status" onchange="this.form.submit()" class="p-1 border rounded dark:bg-gray-700 dark:text-gray-200">
                                <option value="Dipesan" @selected($order->status == 'Dipesan')>Dipesan</option>
                                <option value="Disiapkan" @selected($order->status == 'Disiapkan')>Disiapkan</option>
                                <option value="Dikirim" @selected($order->status == 'Dikirim')>Dikirim</option>
                                <option value="Selesai" @selected($order->status == 'Selesai')>Selesai</option>
                                <option value="Dibatalkan" @selected($order->status == 'Dibatalkan')>Dibatalkan</option>
                            </select>
                        </form>
                        
                        <div class="mt-2 space-x-2">
                             <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Dibatalkan">
                                @if($order->status !== 'Dibatalkan' && $order->status !== 'Selesai')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Batalkan</button>
                                @endif
                            </form>
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Selesai">
                                @if($order->status !== 'Selesai' && $order->status !== 'Dibatalkan')
                                    <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition">Selesaikan</button>
                                @endif
                            </form>
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Disiapkan">
                                @if($order->status == 'Dipesan')
                                    <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Konfirmasi</button>
                                @endif
                            </form>
                        </div>

                        <div class="mt-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Alamat: {{ $order->shipping_address }}</p>
                            <ul class="text-sm mt-2 text-gray-700 dark:text-gray-300">
                                @foreach($order->items as $item)
                                    <li>- {{ $item->menu_item_name }} x{{ $item->quantity }}</li>
                                @endforeach
                            </ul>
                            <p class="text-sm font-bold mt-2 text-gray-900 dark:text-white">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </details>
            </div>
        @endforeach

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
@endsection