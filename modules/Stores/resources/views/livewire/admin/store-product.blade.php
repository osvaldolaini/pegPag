<div x-init>
    <x-layouts.admin.breadcrumb>
        <x-slot name="left">
            <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                {{ $breadcrumb }}
            </h3>
        </x-slot>
    </x-layouts.admin.breadcrumb>

    <div class="flex flex-row items-center w-full px-1 mt-2 lg:px-0">


        @if ($stores->logo_path)
            <div class="avatar">
                <div class="relative w-20 rounded-full cursor-pointer">
                    <!-- Avatar pequeno -->
                    <img src="{{ url('storage/stores/' . $stores->id . '/' . $stores->code_image . '_list.png') }}"
                        alt="{{ $stores->title }}">
                </div>
            </div>
        @else
            <div class="avatar">
                <div class="relative w-20 rounded-full cursor-pointer">
                    <x-layouts.admin.application-logo width="h-12"></x-layouts.admin.application-logo>
                </div>
            </div>
        @endif
        <div class="w-full ml-5">
            @if ($products->count() > 0)
                <label class="flex text-sm font-medium mb-1 dark:text-gray-50">Selecionar Produtos</label>
                <div x-data="{ open: false, search: '' }" class="relative w-full">
                    <input x-model="search" @focus="open = true" @click.outside="open = false" type="text"
                        placeholder="Buscar produto..."
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-gray-50" />

                    <ul x-show="open"
                        class="absolute z-10 bg-white border w-full max-h-60 overflow-y-auto rounded shadow-md mt-1 dark:bg-gray-900">
                        @foreach ($products as $product)
                            <li x-show="search === '' || '{{ mb_strtolower($product->title) }}'.includes(search.toLowerCase())"
                                class="flex items-center justify-between px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer">
                                <div class="flex items-center gap-3 dark:text-gray-50">
                                    <img class="size-10 rounded"
                                        src="{{ url('storage/products/' . $product->id . '/' . $product->code_image . '_list.png') }}"
                                        alt="{{ $product->title }}">
                                    <div>
                                        <div>{{ $product->title }}</div>
                                        <div class="text-xs text-gray-500">R$ {{ $product->value_view }}</div>
                                    </div>
                                </div>
                                <button wire:click="insert({{ $product->id }})" class="btn btn-info">
                                    <svg class="w-4 h-4 mr-0 lg:mr-2" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                    </svg>
                                    <span class="">Adicionar </span>
                                </button>

                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-50 mt-2 text-sm h1 ">Todos os produtos já estão na loja.
                </p>
            @endif
        </div>



    </div>
    <div class="mt-10">
        <ul class="list bg-base-100  dark:bg-gray-800 dark:text-white rounded-box shadow-md">

            <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">Produtos disponíveis para o cliente</li>
            @foreach ($productsStore as $item)
                <li class="list-row">
                    <div>
                        <img class="size-10 rounded-box"
                            src="{{ url('storage/products/' . $item->product->id . '/' . $item->product->code_image . '_list.png') }}"
                            alt="{{ $item->product->title }}" />
                    </div>
                    <div>
                        <div>{{ $item->product->title }}</div>
                        <div class="text-xs uppercase font-semibold opacity-60">R$ {{ $item->product->value_view }}
                        </div>
                    </div>
                    <button class="btn btn-square btn-outline btn-error" wire:click="remove({{ $item->id }})">
                        <x-svg.cart-less class="size-[1.5em]"></x-svg.cart-less>
                    </button>


                </li>
            @endforeach
        </ul>
    </div>


</div>
