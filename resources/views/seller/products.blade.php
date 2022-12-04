<?php
$user = Auth::user();
$products = $user->products()->paginate(\App\Models\Product::PAGINATE_ITEMS);
?>
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-3 p-4">

    <form method="POST" action="{{ route('products.import') }}" enctype="multipart/form-data">
        @csrf
        <div class="">
            <x-input-label for="csv" :value="__('Bulk Upload Products (Allowed: csv)')" />
            <input id="csv" class="block mt-1 w-full text-gray-700 dark:text-gray-300" type="file" name="file"
                required />
            <x-input-error :messages="$errors->get('file')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-primary-button class="">
                {{ __('Upload') }}
            </x-primary-button>
        </div>
    </form>
</div>

<h2 class="text-white mt-5">Your Products List</h2>

<div class="mt-4">
    <div class="grid grid-cols-4 gap-4">
        @foreach ($products as $product)
            @include('products.product-card', ['product' => $product])
        @endforeach
    </div>
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
