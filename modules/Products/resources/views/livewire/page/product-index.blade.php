<div>
    {{-- @livewire('message-alert') --}}

    <div class="dock dock-xl bg-neutral text-neutral-content ">

        @foreach ($stores as $item)
            <button wire:click='changeStore({{ $item->id }})' class="rounded-box shadow-lg ">
                @if ($item->logo_path)
                    <img class="h-12"
                        src="{{ url('storage/stores/' . $item->id . '/' . $item->code_image . '_list.png') }}"
                        alt="{{ $item->title }}">
                @else
                    <x-layouts.admin.application-logo width="h-12"></x-layouts.admin.application-logo>
                @endif
                <span class="dock-label">{{ $item->title }}</span>
            </button>
        @endforeach

    </div>
    <h1 class="text-2xl font-bold mb-1" wire:model='store'>Produtos da loja: </h1>
    <h2 class="text-xl font-bold mb-4 w-full text-center bg-amber-600 rounded-md py-2">{{ $store->title }}</h2>
    <ul class="list rounded-box shadow-md">

        <li class="p-4 pb-2 text-xs tracking-wide">Selecione seu produto</li>
        @foreach ($inStock as $stock)
            @php
                $inCart = collect($cart)->contains(fn($item) => $item['product_id'] === $stock->product->id);
            @endphp
            <li class="list-row dark:bg-gray-900 dark:text-white bg-white">
                <div>
                    <img class="size-10
                rounded-box"
                        src="{{ url('storage/products/' . $stock->product->id . '/' . $stock->product->code_image . '_list.png') }}"
                        alt="{{ $stock->product->title }}" />
                </div>
                <div>
                    <div>{{ $stock->product->title }}</div>
                    <div class="text-xs uppercase font-semibold ">R$ {{ $stock->product->value_view }}</div>
                </div>
                @if ($inCart)
                    <button class="btn btn-square btn-outline btn-error"
                        wire:click="removeFromCart({{ $stock->product->id }})">
                        <x-svg.cart-less class="size-[1.5em]"></x-svg.cart-less>
                    </button>
                    <button class="btn btn-square btn-outline btn-ghost">
                        <x-svg.dollar class="size-[1.5em]"></x-svg.dollar>
                    </button>
                @else
                    <button class="btn btn-square btn-outline btn-success"
                        wire:click="addToCart({{ $stock->product->id }})">
                        <x-svg.cart-plus class="size-[1.5em]"></x-svg.cart-plus>
                    </button>

                    <button class="btn btn-square btn-outline btn-success"
                        wire:click="addToCartRedirect({{ $stock->product->id }})">
                        <x-svg.dollar class="size-[1.5em]"></x-svg.dollar>
                    </button>
                @endif

            </li>
        @endforeach


    </ul>

</div>
