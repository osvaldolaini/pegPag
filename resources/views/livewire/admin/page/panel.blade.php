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
                                                        <button wire:click="paid({{ $sale->id }})"
                                                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition">
                                                            <x-svg.dollar class="ml-2 size-6"></x-svg.dollar>
                                                        </button>
                                                        <button wire:click="showSaleDetails({{ $sale->id }})"
                                                            class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition">
                                                            <x-svg.eyes class="ml-2 size-6"></x-svg.eyes>
                                                        </button>
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



</div>
