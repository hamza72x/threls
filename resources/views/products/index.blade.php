<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-4 gap-4">
                @foreach ($products as $product)
                    <form method="POST" action="{{ route('cart.add-item', ['product_id' => $product->id]) }}">
                        @csrf
                        <div class="p-4 rounded-lg bg-gray-500 shadow-lg">
                            <h2 class='font-bold'>{{ $product->name }}</h2>
                            <span>{{ $product->brand }}</span>
                            <p>￡{{ $product->price }}</p>
                            <button class="text-gray-800 font-bold py-2 rounded-l">
                                Add to cart
                            </button>
                        </div>
                    </form>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
