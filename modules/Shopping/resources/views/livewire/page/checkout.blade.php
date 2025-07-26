<div class="space-y-4">
    <h1 class="items-center text-center">
        <button wire:click='submit' type="submit" class="flex btn btn-success text-lg w-full">
            <x-svg.dollar class="size-[1.8em]"></x-svg.dollar>
            Continuar para pagamento
        </button>
    </h1>
    <div class="max-w-md mx-auto p-6 bg-white rounded shadow">

        <h2 class="text-xl font-bold mb-4">Informações do Comprador</h2>

        <form wire:submit.prevent="submit">

            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold mb-1">Nome</label>
                <input wire:model.defer="name" id="name" type="text" class="w-full border rounded px-3 py-2" />
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="cpf" class="block text-sm font-semibold mb-1">CPF</label>
                <input wire:model.defer="cpf" id="cpf" type="text" class="w-full border rounded px-3 py-2"
                    x-mask="999.999.999-99" />
                @error('cpf')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="phone" class="block text-sm font-semibold mb-1">Telefone</label>
                <input wire:model.defer="phone" id="phone" x-mask="(99) 99999-9999" type="text"
                    class="w-full border rounded px-3 py-2" />
                @error('phone')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>



        </form>
    </div>
</div>
