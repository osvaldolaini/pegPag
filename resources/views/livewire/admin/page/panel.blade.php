<div>
    @php
        use App\Enums\SalesStatus;
    @endphp
    <x-layouts.admin.tabs.tabs>
        <x-slot name="nav">
            @foreach ($stores as $item)
                @php
                    $tab = $item->id;
                @endphp
                <div>
                    <button wire:click='changeStore({{ $tab }})'
                        class="{{ $store->id == $tab
                            ? 'bg-gray-500 text-white active dark:text-gray-900 rounded-md'
                            : 'border-transparent text-gray-500 hover:text-gray-600 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-300' }} === '#tab{{ $tab }}'
                           cursor-pointer flex items-center px-3 py-2 text-sm font-medium transition duration-75">
                        @if ($item->logo_path)
                            <div class="avatar">
                                <div class="relative w-8 rounded-full cursor-pointer">
                                    <!-- Avatar pequeno -->
                                    <img src="{{ url('storage/stores/' . $item->id . '/' . $item->code_image . '_list.png') }}"
                                        alt="{{ $item->title }}">
                                </div>
                            </div>
                        @else
                            <div class="avatar">
                                <div class="relative w-8 rounded-full cursor-pointer">
                                    <x-layouts.admin.application-logo width="h-12"></x-layouts.admin.application-logo>
                                </div>
                            </div>
                        @endif
                        <span class="px-1 transition duration-75 text-primary-600 dark:text-primary-400">
                            {{ $item->title }}
                        </span>
                    </button>
                </div>
            @endforeach

        </x-slot>
        <x-slot name="content">
            @if ($store)
                <div class="block">
                    <div role="tabpanel"
                        class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6">

                            {{-- Total de vendas --}}
                            <div class="bg-white rounded-2xl shadow p-6">
                                <h3 class="text-sm text-gray-500">Total de Vendas</h3>
                                <p class="text-3xl font-bold text-indigo-600">{{ $totalSales }}</p>
                            </div>

                            {{-- Valor total vendido --}}
                            <div class="bg-white rounded-2xl shadow p-6">
                                <h3 class="text-sm text-gray-500">Valor Total Vendido</h3>
                                <p class="text-3xl font-bold text-green-600">R$
                                    {{ number_format($totalValue, 2, ',', '.') }}</p>
                            </div>

                            {{-- Ticket médio --}}
                            <div class="bg-white rounded-2xl shadow p-6">
                                <h3 class="text-sm text-gray-500">Ticket Médio</h3>
                                <p class="text-3xl font-bold text-yellow-600">R$
                                    {{ number_format($averageTicket, 2, ',', '.') }}</p>
                            </div>

                            {{-- Última venda --}}
                            <div class="bg-white rounded-2xl shadow p-6">
                                <h3 class="text-sm text-gray-500">Última Venda</h3>
                                <p class="text-lg font-semibold text-gray-800">
                                    {{ $lastSaleDate ? $lastSaleDate->format('d/m/Y H:i') : 'Nenhuma' }}
                                </p>
                            </div>
                        </div>

                        {{-- Lista de vendas recentes --}}
                        <div class="p-6 space-y-6">

                            {{-- Tabela de Vendas Recentes --}}
                            <div>
                                <h2 class="text-xl font-bold mb-4 text-gray-800">Últimas Vendas</h2>
                                <div class="bg-white rounded-2xl shadow overflow-hidden">
                                    <table class="min-w-full text-sm text-gray-700">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-4 py-2 text-left">ID</th>
                                                <th class="px-4 py-2 text-left">Data</th>
                                                <th class="px-4 py-2 text-left">Cliente</th>
                                                <th class="px-4 py-2 text-center">Valor</th>
                                                <th class="px-4 py-2 text-center">Status</th>
                                                <th class="px-4 py-2 text-center">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentSales as $sale)
                                                <tr class="border-b">
                                                    <td class="px-4 py-2">{{ $sale->id }}</td>
                                                    <td class="px-4 py-2">{{ $sale->created_at->format('d/m/Y H:i') }}
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        {{ json_decode($sale->customer)->name ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-4 py-2 text-center">R$
                                                        {{ number_format($sale->value, 2, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-2 text-center">
                                                        {{-- <span class="badge badge-success"></span>
                                                        <span class="badge badge-warning"></span> --}}
                                                        <span
                                                            class="badge {{ SalesStatus::From($sale->status)->badgeClass() }}">
                                                            {{ SalesStatus::From($sale->status)->dbName() }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2 text-center">
                                                        @if ($sale->status == 0)
                                                            <div class="p-0 tooltip tooltip-top" data-tip="Pagar">

                                                                <button wire:click="showModalPaid({{ $sale->id }})"
                                                                    class="px-3 py-2 transition-colors duration-200 rounded-sm  hover:bg-green-500 hover:text-white">
                                                                    <x-svg.dollar class="w-6 h-6"></x-svg.dollar>
                                                                </button>
                                                            </div>
                                                        @endif
                                                        <div class="p-0 tooltip tooltip-top" data-tip="Detalhes">

                                                            <button wire:click="showSaleDetails({{ $sale->id }})"
                                                                class="px-3 py-2 transition-colors duration-200 rounded-sm  hover:bg-indigo-700 hover:text-white">
                                                                <x-svg.eyes class="w-6 h-6"></x-svg.eyes>
                                                            </button>
                                                        </div>
                                                        <div class="p-0 tooltip tooltip-top" data-tip="Apagar">
                                                            <button wire:click="showModalDelete({{ $sale->id }})"
                                                                class="px-3 py-2 -ml-1 transition-colors duration-200 rounded-sm dark:hover:bg-red-500 hover:bg-red-500 hover:text-white">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                                        Nenhuma
                                                        venda
                                                        encontrada.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Modal --}}
                            @if ($showModal && $selectedSale)
                                <div
                                    class="fixed inset-0 flex items-center text-gray-900 justify-center bg-black bg-opacity-50 z-50">
                                    <div class="bg-white p-6 rounded-2xl shadow max-w-lg w-full space-y-4">
                                        <h2 class="text-xl font-bold text-gray-900">Detalhes da Venda
                                            #{{ $selectedSale->id }}</h2>

                                        <div>
                                            <p><strong>Cliente:</strong>
                                                {{ json_decode($selectedSale->customer)->name ?? 'N/A' }}</p>
                                            <p><strong>Valor:</strong> R$
                                                {{ number_format($selectedSale->value, 2, ',', '.') }}</p>
                                            <p><strong>Data:</strong>
                                                {{ $selectedSale->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>

                                        <div class="mt-4">
                                            <h3 class="font-semibold mb-2 text-gray-900">Itens:</h3>
                                            <ul class="list-disc list-inside space-y-1 text-gray-900">
                                                @foreach (json_decode($selectedSale->items ?? '[]') as $item)
                                                    <li>{{ $item->name ?? 'Produto' }} - {{ $item->quantity ?? 1 }}x
                                                        R$
                                                        {{ number_format($item->price ?? 0, 2, ',', '.') }}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="text-right pt-4">
                                            <button wire:click="$set('showModal', false)" class="btn btn-error">
                                                Fechar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif


        </x-slot>
    </x-layouts.admin.tabs.tabs>
    {{-- MODAL DELETE --}}
    <x-layouts.admin.confirmation-modal wire:model="showJetModal">
        <x-slot name="title">
            Excluir registro
        </x-slot>

        <x-slot name="content">
            <h2 class="h2">Deseja realmente excluir o registro?</h2>
            <p>Não será possível reverter esta ação!</p>
        </x-slot>

        <x-slot name="footer">
            <button class="ml-2 btn btn-active" wire:click="$toggle('showJetModal')" wire:loading.attr="disabled">
                Cancelar
            </button>

            <button class="ml-2 btn btn-error" wire:click="delete({{ $registerId }})" wire:loading.attr="disabled">
                Apagar registro
            </button>
        </x-slot>
    </x-layouts.admin.confirmation-modal>
    {{-- MODAL PAGAR --}}
    <x-layouts.admin.confirmation-modal wire:model="showPaid">
        <x-slot name="title">
            Pagar
        </x-slot>

        <x-slot name="content">
            <h2 class="h2">Deseja realmente informar o pagamento?</h2>
        </x-slot>

        <x-slot name="footer">
            <button class="ml-2 btn btn-active" wire:click="$toggle('showPaid')" wire:loading.attr="disabled">
                Cancelar
            </button>

            <button class="ml-2 btn btn-success" wire:click="paid({{ $registerId }})" wire:loading.attr="disabled">
                Pagar
            </button>
        </x-slot>
    </x-layouts.admin.confirmation-modal>



</div>
