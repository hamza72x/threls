<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($orders as $order)
            <div>
                <a class="block bg-gray-500 rounded-lg mb-4 p-4 hover:bg-white"
                    href="{{ route('orders.show', ['order_id' => $order->id]) }}">
                    <p>ID: 100{{ $order->id }}</p>
                    <p>Grand Total: ￡{{ $order->grand_total }}</p>
                    <p>Total Items: {{ $order->items->count() }}</p>
                    <p>Status: {{ $order->status_name }}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
