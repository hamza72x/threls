<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cart') }}
        </h2>
        <h4 class="font-bold text-white mt-3">
            Grand Total: ￡{{ $cart->grand_total }}
        </h4>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-4 gap-4">
                @foreach ($cart->items as $cartItem)
                    @php($product = $cartItem->product)
                    <form method="POST" action="{{ route('cart.remove-item', ['product_id' => $product->id]) }}">
                        @csrf
                        <div class="p-4 rounded-lg bg-gray-500 shadow-lg">
                            <h2 class='font-bold'>{{ $product->name }}</h2>
                            <span>Brand: {{ $product->brand }}</span>
                            <p>Price: ￡{{ $product->price }}</p>
                            <p>Quantity: {{ $cartItem->quantity }}</p>
                            <p>Subtotal: {{ $cartItem->sub_total }}</p>
                            <button class="text-gray-800 font-bold py-2 rounded-l">
                                Remove from cart
                            </button>
                        </div>
                    </form>
                @endforeach
            </div>

            <div class="justify-center items-center flex m-6">
                <form action="{{ route('orders.placeMainCart') }}" method="post">
                    @csrf
                    <x-primary-button class="ml-4">
                        {{ __('Place Order') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
