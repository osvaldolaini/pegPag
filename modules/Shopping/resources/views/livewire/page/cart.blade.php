<div class="space-y-4">
    @if (count($items) === 0)
        <div
            class="flex flex-col items-center justify-center text-center py-16 text-gray-500 bg-white rounded-xl shadow">
            <x-svg.basket-empty class="size-[3em]"></x-svg.basket-empty>
            <p class="text-xl font-semibold">Seu carrinho está vazio</p>
            <p class="text-sm text-gray-400 mt-2">Adicione produtos para continuar.</p>
            <p class="mt-10">
            <div class="md:hidden">
                <a href="{{ url('/produtos') }}" class="flex btn btn-soft btn-active">
                    <x-svg.back class="size-[1.8em]"></x-svg.back>
                    Voltar
                </a>
            </div>
            </p>
        </div>
    @else
        <h1>
            <a href="{{ url('/cliente') }}" class="flex btn btn-info text-lg">
                <x-svg.customer class="size-[1.8em]"></x-svg.customer>
                Identificação
            </a>
        </h1>
        @foreach ($items as $id => $item)
            <div class="p-4 border rounded-xl bg-white shadow flex flex-col space-y-2">
                {{-- Primeira linha: imagem + nome + descrição --}}
                <div class="flex items-center space-x-4">
                    <img src="{{ $item['image'] ?? 'https://via.placeholder.com/80' }}" alt="Imagem"
                        class="w-20 h-20 rounded object-cover border" />
                    <div>
                        <p class="font-semibold text-lg">{{ $item['title'] }}</p>
                    </div>
                </div>

                {{-- Segunda linha: preço unitário + botões de quantidade + botão remover --}}
                <div class="flex items-center justify-between mt-2">
                    <p class="text-sm text-gray-700">Preço unitário: <strong>R$
                            {{ number_format($item['price'], 2, ',', '.') }}</strong></p>

                    <div class="flex items-center space-x-2">
                        <button wire:click="decreaseQuantity({{ $id }})"
                            class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 text-lg">−</button>

                        <span class="w-6 text-center">{{ $item['quantity'] }}</span>

                        <button wire:click="increaseQuantity({{ $id }})"
                            class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 text-lg">+</button>

                        <button wire:click="removeFromCart({{ $id }})"
                            class="ml-4 text-red-500 hover:underline text-sm">Remover</button>
                    </div>
                </div>

                {{-- Total por item --}}
                <div class="text-right text-sm text-gray-700">
                    Subtotal: <strong>R$
                        {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</strong>
                </div>
            </div>
        @endforeach
    @endif

    {{-- MODAL DELETE --}}
    <x-layouts.admin.confirmation-modal wire:model="modalRemove">
        <x-slot name="title">
            Remover item
        </x-slot>

        <x-slot name="content">
            <h2 class="h2">Deseja realmente remover o item?</h2>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="$toggle('modalRemove')" wire:loading.attr="disabled">
                Cancelar
            </button>

            <button class="ml-2 btn btn-error" wire:click="removeFromCart({{ $idRemove }})"
                wire:loading.attr="disabled">
                Remover
            </button>
        </x-slot>
    </x-layouts.admin.confirmation-modal>
</div>
