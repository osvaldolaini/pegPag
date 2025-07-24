<div>
    @livewire('message-alert')
    <h1 class="text-2xl font-bold mb-4">Produtos</h1>
    <ul class="list bg-base-100 rounded-box shadow-md">

        <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">Selecione seu produto</li>
        @foreach ($products as $product)
            @php
                $inCart = collect($cart)->contains(fn($item) => $item['product_id'] === $product->id);
            @endphp
            <li class="list-row">
                <div>
                    <img class="size-10 rounded-box"
                        src="{{ url('storage/products/' . $product->id . '/' . $product->code_image . '_list.png') }}"
                        alt="{{ $product->title }}" />
                </div>
                <div>
                    <div>{{ $product->title }}</div>
                    <div class="text-xs uppercase font-semibold opacity-60">R$ {{ $product->value_view }}</div>
                </div>
                @if ($inCart)
                    <button class="btn btn-square btn-outline btn-error" wire:click="removeFromCart({{ $product->id }})">
                        <x-svg.cart-less class="size-[1.5em]"></x-svg.cart-less>
                    </button>
                    <button class="btn btn-square btn-outline btn-ghost">
                        <x-svg.dollar class="size-[1.5em]"></x-svg.dollar>
                    </button>
                @else
                    <button class="btn btn-square btn-outline btn-success" wire:click="addToCart({{ $product->id }})">
                        <x-svg.cart-plus class="size-[1.5em]"></x-svg.cart-plus>
                    </button>

                    <button class="btn btn-square btn-outline btn-success"
                        wire:click="addToCartRedirect({{ $product->id }})">
                        <x-svg.dollar class="size-[1.5em]"></x-svg.dollar>
                    </button>
                @endif

            </li>
        @endforeach


    </ul>

</div>
