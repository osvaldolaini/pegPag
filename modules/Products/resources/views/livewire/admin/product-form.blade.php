<div>
    <form>
        <x-layouts.admin.tabs.tabs>
            <x-slot name="nav">
                <x-layouts.admin.tabs.tabs-link tab="tab1">
                    <x-slot name="svg">
                        <x-svg.products
                            class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"></x-svg.products>

                    </x-slot>
                    <x-slot name="title">{{ $breadcrumb }}</x-slot>
                </x-layouts.admin.tabs.tabs-link>
                @if ($id)
                    <x-layouts.admin.tabs.tabs-link tab="tab2">
                        <x-slot name="svg">
                            <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.6471 16.375L12.0958 14.9623C11.3351 14.2694 10.9547 13.923 10.5236 13.7918C10.1439 13.6762 9.73844 13.6762 9.35878 13.7918C8.92768 13.923 8.5473 14.2694 7.78652 14.9623L4.92039 17.5575M13.6471 16.375L13.963 16.0873C14.7238 15.3944 15.1042 15.048 15.5352 14.9168C15.9149 14.8012 16.3204 14.8012 16.7 14.9168C17.1311 15.048 17.5115 15.3944 18.2723 16.0873L19.4237 17.0896M13.6471 16.375L17.0469 19.4528M17 9C17 10.1046 16.1046 11 15 11C13.8954 11 13 10.1046 13 9C13 7.89543 13.8954 7 15 7C16.1046 7 17 7.89543 17 9ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">Foto</x-slot>
                    </x-layouts.admin.tabs.tabs-link>
                @endif

                <x-layouts.admin.button-back route="{{ $back }}"></x-layouts.admin.button-back>
            </x-slot>
            <x-slot name="content">
                <div id="tab1" x-show="activeTab === '#tab1'" class="block">
                    <div role="tabpanel"
                        class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                        <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                            <div class="col-span-full ">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="name">
                                    Produto</label>
                                <input type="text" wire:model="title" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('title')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full sm:col-span-2 ">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Valor</label>
                                <x-layouts.admin.input-value value="{{ $value }}" field="value"
                                    placeholder="Valor"></x-layout.input-value>
                                    {{-- @error('grau')
                                    <span class="error">{{ $message }}</span>
                                @enderror --}}
                            </div>
                        </div>
                    </div>
                </div>
                @if ($id)
                    <div id="tab2" x-show="activeTab === '#tab2'">

                    </div>
                @endif
            </x-slot>
        </x-layouts.admin.tabs.tabs>
    </form>
    <div class="px-4 text-right">
        {{-- <button type="submit" wire:click="save"
            class="text-white
                        bg-blue-700 hover:bg-blue-800
                        focus:ring-4 focus:outline-none focus:ring-blue-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-blue-600 dark:hover:bg-blue-700
                        dark:focus:ring-blue-800">
            Salvar
        </button> --}}
        <button type="submit" wire:click="save_out"
            class="text-white
                        bg-green-700 hover:bg-green-800
                        focus:ring-4 focus:outline-none focus:ring-green-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-green-600 dark:hover:bg-green-700
                        dark:focus:ring-green-800">
            Salvar e sair
        </button>
    </div>
</div>
