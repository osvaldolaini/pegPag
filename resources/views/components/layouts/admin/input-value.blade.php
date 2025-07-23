@props(['field' => null, 'value' => null, 'placeholder' => null])

<div x-data="{
    value: '{{ old($field, $value) }}',
    formatValue() {
        // Remove caracteres não numéricos
        let valueValor = this.value.replace(/[^\d]/g, '');

        // Se o valor estiver vazio, não formata
        if (valueValor.length === 0) {
            this.value = '';
            return;
        }

        // Definindo centavos e inteiros com base no número de dígitos
        let centavos, inteiros;

        // Garante que centavos estejam sempre disponíveis
        if (valueValor.length === 1) {
            centavos = '0' + valueValor; // Um dígito significa '0,0X'
            inteiros = '0'; // Não há inteiros neste caso
        } else if (valueValor.length === 2) {
            centavos = valueValor; // Dois dígitos são os centavos
            inteiros = '0'; // Não há inteiros neste caso
        } else {
            // Caso geral: mais de 2 dígitos
            centavos = valueValor.slice(-2); // Últimos 2 dígitos são os centavos
            inteiros = valueValor.slice(0, valueValor.length - 2); // O restante são os inteiros

            // Remove zeros à esquerda dos inteiros
            inteiros = inteiros.replace(/^0+/, '');

            // Se não houver dígitos inteiros, assegura que tenhamos '0' antes da vírgula
            if (inteiros.length === 0) {
                inteiros = '0';
            }
        }

        // Adiciona separadores de milhar nos inteiros
        inteiros = inteiros.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Atualiza o campo com os valores inteiros e os centavos
        this.value = inteiros + ',' + centavos;
    },
    getFormattedValue() {
        // Para envio, remove pontos e substitui vírgula por ponto
        let rawValue = this.value.replace(/\./g, '').replace(',', '.');
        return parseFloat(rawValue).toFixed(2);
    }
}" x-init="formatValue()" @input="formatValue()" class="w-full">

    <input type="text" x-model="value" id="{{ $field }}" name="{{ $field }}" maxlength="5"
        wire:model.lazy="{{ $field }}" placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' =>
                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500',
        ]) }}
        autocomplete="off" @blur="$dispatch('input', getFormattedValue())" />

    @error($field)
        <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror
</div>
