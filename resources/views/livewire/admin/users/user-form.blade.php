<div>
    <x-layouts.admin.breadcrumb>
        <x-slot name="left">
            <h3 class="text-2xl font-bold cursor-pointer tracki dark:text-gray-50">
                {{ $breadcrumb }}
            </h3>
            <x-layouts.admin.button-back route="{{ $back }}"></x-layouts.admin.button-back>
        </x-slot>
    </x-layouts.admin.breadcrumb>
    <form>
        <x-layouts.admin.tabs.tabs>
            <x-slot name="nav">
                <x-layouts.admin.tabs.tabs-link tab="tab1">
                    <x-slot name="svg">
                        <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g id="Complete">
                                <g id="info-circle">
                                    <g>

                                        <circle cx="12" cy="12" data-name="--Circle" fill="none"
                                            id="_--Circle" r="10" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" />

                                        <line fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" x1="12" x2="12"
                                            y1="12" y2="16" />

                                        <line fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" x1="12" x2="12"
                                            y1="8" y2="8" />
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </x-slot>
                    <x-slot name="title">Dados usuário</x-slot>
                </x-layouts.admin.tabs.tabs-link>

            </x-slot>
            <x-slot name="content">
                <div id="tab1" x-show="activeTab === '#tab1'" class="block">
                    <div role="tabpanel"
                        class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                        <div class="grid gap-4 mb-1 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="name" class="block text-sm font-medium text-gray-900 dark:text-white">
                                    Nome</label>
                                <input type="text" wire:model="name" placeholder="Nome" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="email" class="block text-sm font-medium text-gray-900 dark:text-white">
                                    Email</label>
                                <input type="email" wire:model="email" placeholder="Email" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="password" class="block text-sm font-medium text-gray-900 dark:text-white">
                                    Senha</label>
                                <input type="password" wire:model="password" placeholder="Senha" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

            </x-slot>
        </x-layouts.admin.tabs.tabs>

    </form>
    <div class="px-4 text-right">
        <button type="submit" wire:click="save"
            class="text-white
                        bg-blue-700 hover:bg-blue-800
                        focus:ring-4 focus:outline-none focus:ring-blue-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-blue-600 dark:hover:bg-blue-700
                        dark:focus:ring-blue-800">
            Salvar
        </button>
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
