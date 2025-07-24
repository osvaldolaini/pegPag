<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6">

        {{-- Total de vendas --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-sm text-gray-500">Total de Vendas</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalSales }}</p>
        </div>

        {{-- Valor total vendido --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-sm text-gray-500">Valor Total Vendido</h3>
            <p class="text-3xl font-bold text-green-600">R$ {{ number_format($totalValue, 2, ',', '.') }}</p>
        </div>

        {{-- Ticket médio --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-sm text-gray-500">Ticket Médio</h3>
            <p class="text-3xl font-bold text-yellow-600">R$ {{ number_format($averageTicket, 2, ',', '.') }}</p>
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
                            <th class="px-4 py-2 text-right">Valor</th>
                            <th class="px-4 py-2 text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $sale->id }}</td>
                                <td class="px-4 py-2">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2">{{ json_decode($sale->customer)->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2 text-right">R$ {{ number_format($sale->value, 2, ',', '.') }}</td>
                                <td class="px-4 py-2 text-center">
                                    <button wire:click="showSaleDetails({{ $sale->id }})"
                                        class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition">
                                        Detalhes
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">Nenhuma venda encontrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal --}}
        @if ($showModal && $selectedSale)
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-white p-6 rounded-2xl shadow max-w-lg w-full space-y-4">
                    <h2 class="text-xl font-bold text-gray-800">Detalhes da Venda #{{ $selectedSale->id }}</h2>

                    <div>
                        <p><strong>Cliente:</strong> {{ json_decode($selectedSale->customer)->name ?? 'N/A' }}</p>
                        <p><strong>Valor:</strong> R$ {{ number_format($selectedSale->value, 2, ',', '.') }}</p>
                        <p><strong>Data:</strong> {{ $selectedSale->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mt-4">
                        <h3 class="font-semibold mb-2">Itens:</h3>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach (json_decode($selectedSale->items ?? '[]') as $item)
                                <li>{{ $item->name ?? 'Produto' }} - {{ $item->quantity ?? 1 }}x R$
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
