<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 rounded-lg text-white shadow-lg">
                <p>ID: 100{{ $order->id }}</p>
                <p>Grand Total: ￡{{ $order->grand_total }}</p>
                <p>Total Items: {{ $order->items->count() }}</p>
                <p>Status: {{ $order->status_name }}</p>

                <div class="my-4">
                    <h2 class="mb-2 font-bold">Products:</h2>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach ($order->items as $item)
                            <div class="p-4 rounded-lg bg-gray-500 shadow-lg">
                                <p>Product: {{ $item->product->name }}</p>
                                <p>Price: ￡{{ $item->price }}</p>
                                <p>Quantity: {{ $item->quantity }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
