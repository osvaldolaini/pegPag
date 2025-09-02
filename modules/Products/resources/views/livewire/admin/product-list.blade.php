<div x-init>
    <x-layouts.admin.breadcrumb>
        <x-slot name="left">
            <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                {{ $breadcrumb }}
            </h3>
        </x-slot>

    </x-layouts.admin.breadcrumb>
    <x-layouts.admin.search.block>
        <x-slot name="button">
            <button wire:click="showCreate()"
                class="flex items-center justify-center p-3 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg lg:px-5 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                <svg class="w-4 h-4 mr-0 lg:mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                <span class="">Novo </span>
            </button>
        </x-slot>
    </x-layouts.admin.search.block>
    <x-layouts.admin.table.table>
        <x-slot name="head">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr scope="col" class="text-gray-500 dark:text-gray-400">
                    <th scope="col" wire:click="addSort('title')"
                        class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                        <x-layouts.admin.table.table-sort-button :sorts='$sorts' field="title">
                            Produto
                        </x-layouts.admin.table.table-sort-button>
                    </th>
                    <th scope="col"
                        class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">

                        Valor
                    </th>
                    <th scope="col"
                        class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                        Opções
                    </th>
                </tr>
            </thead>
        </x-slot>
        <x-slot name="body">
            <tbody class="relative p-0 m-0 bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                @foreach ($dataTable as $item)
                    <tr>
                        <td
                            class="relative flex items-center px-4 py-1 space-x-2 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                            @if ($item->logo_path)
                                <div class="avatar">
                                    <div class="relative w-8 rounded-full cursor-pointer">
                                        <!-- Avatar pequeno -->
                                        <img src="{{ url('storage/products/' . $item->id . '/' . $item->code_image . '_list.png') }}"
                                            alt="{{ $item->title }}">
                                    </div>
                                </div>
                            @else
                                <div class="avatar">
                                    <div class="relative w-8 rounded-full cursor-pointer">
                                        <x-layouts.admin.application-logo
                                            width="h-12"></x-layouts.admin.application-logo>
                                    </div>
                                </div>
                            @endif
                            <span>
                                {{ $item->title }}
                            </span>
                        </td>

                        <td
                            class="items-center px-4 py-1 space-x-2 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            R$ {{ $item->value_view }}
                        </td>

                        <td class="w-1/6 px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            <x-layouts.admin.table.table-options id='{{ $item->id }}' active='{{ $item->status }}'>
                            </x-layouts.admin.table.table-options>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-slot>

        <x-slot name="link">
            {{ $dataTable->links() }}
        </x-slot>
    </x-layouts.admin.table.table>

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
            <button wire:click="$toggle('showJetModal')" wire:loading.attr="disabled">
                Cancelar
            </button>

            <button class="ml-2 btn btn-error" wire:click="delete({{ $id }})" wire:loading.attr="disabled">
                Apagar registro
            </button>
        </x-slot>
    </x-layouts.admin.confirmation-modal>

    {{-- MODAL READ --}}
    <x-layouts.admin.dialog-modal wire:model="showModalView">
        <x-slot name="title">Detalhes</x-slot>
        <x-slot name="content">
            <dl class="text-gray-900 divide-y divide-gray-200 max-w dark:text-white dark:divide-gray-700">
                @if ($detail)
                    @foreach ($detail as $item => $value)
                        @if ($value)
                            @if ($item == 'Foto')
                                <figure class="w-48">
                                    <img class="photo" src="{{ $value }}" alt="Movie" />
                                </figure>
                            @else
                                <div class="flex flex-col pb-1">
                                    <dt class="text-gray-500 md:text-lg dark:text-gray-400">{{ $item }}:</dt>
                                    <dd class="text-lg font-semibold">
                                        {{ $value }}
                                    </dd>
                                </div>
                            @endif
                        @endif
                    @endforeach
                @endif
            </dl>
        </x-slot>
        <x-slot name="footer">
            <button wire:click="$toggle('showModalView')" class="mx-2">
                Fechar
            </button>
        </x-slot>
    </x-layouts.admin.dialog-modal>
    {{-- MODAL FORM --}}

    <x-layouts.admin.dialog-modal wire:model="showModalForm" maxWidth="4xl">
        <x-slot name="title">{{ $breadcrumb }} </x-slot>
        <x-slot name="content">
            @if ($product)
                @livewire('admin.product-form', ['product' => $product], key($product->id))
            @else
                @livewire('admin.product-form')
            @endif
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-layouts.admin.dialog-modal>

</div>
