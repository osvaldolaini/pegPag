<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-lg text-center">
    @if (!$paid)
        <h1 class="items-center text-center">
            <button wire:click='simulatePayment' class="flex btn btn-lg btn-error text-lg w-full py-2">
                <x-svg.dollar class="size-[1.8em]"></x-svg.dollar>
                Clique aqui para informar pagamento
            </button>
        </h1>
        <h1 class="text-2xl font-bold mb-4">Pagamento via Pix</h1>
        <p class="text-gray-600 mb-6">Escaneie o QR Code abaixo com seu aplicativo bancário para concluir o pagamento.
        </p>

        <div class="flex justify-center mb-6">
            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode($pixQrCode) }}&size=200x200"
                alt="QR Code Pix" class="mx-auto border rounded-lg" />
        </div>
        {{-- Código Copia e Cola com botão --}}
        <div class="max-w-md mx-auto mt-6">
            <label for="pixCode" class="block text-sm font-medium text-gray-700 mb-2">Chave Pix:</label>
            <textarea id="pixCode" class="w-full max-w-md p-2 border rounded" rows="3" readonly>{{ $pixQrCode }}</textarea>
            <div class="flex items-center space-x-2 w-full">
                {{-- <input id="pixCode" type="text" value="chave-pix-exemplo@exemplo.com"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                    readonly> --}}
                <button onclick="copyToClipboard()" class="btn btn-outline btn-active w-full ">
                    📋 Copiar código Pix
                </button>
            </div>
            <p id="copyMsg" class="text-green-600 text-sm mt-2 hidden">Copiado com sucesso!</p>
        </div>
        {{-- Temporizador com Alpine.js --}}
        {{-- <div x-data="pixTimer()" x-init="start()" class="text-center mt-6">
            <p class="text-sm text-gray-500">Este código expira em:</p>
            <p class="text-3xl font-semibold text-red-500 mt-1" x-text="formatTime()"></p>

            <template x-if="expired">
                <p class="text-red-600 text-sm mt-4">Tempo expirado! Gere um novo QR Code.</p>
            </template>
        </div> --}}
        {{-- Resumo da compra --}}
        <div class="mb-6 text-left">
            <h2 class="text-xl font-bold mb-2">Resumo da compra</h2>
            <ul class="text-sm text-gray-700 space-y-1">
                @foreach ($cart as $product)
                    <li>
                        {{ $product['title'] }} x {{ $product['quantity'] }} = R$
                        {{ number_format($product['price'] * $product['quantity'], 2, ',', '.') }}
                    </li>
                @endforeach
            </ul>
            <div class="mt-2 font-semibold">Total: R$ {{ number_format($total, 2, ',', '.') }}</div>
        </div>
    @else
        {{-- Mensagem de sucesso --}}
        <div class="flex flex-col items-center justify-center mt-8 space-y-4 animate-pulse">
            <svg class="w-24 h-24 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <p class="text-green-600 text-xl font-semibold">Pagamento confirmado!</p>
            <p class="text-gray-500 text-sm">Redirecionando para a lista de produtos...</p>
        </div>
    @endif




    {{-- Script de cópia --}}
    <script>
        function copyToClipboard() {
            const input = document.getElementById('pixCode');
            const msg = document.getElementById('copyMsg');

            input.select();
            input.setSelectionRange(0, 99999); // Para mobile

            if (navigator.clipboard) {
                navigator.clipboard.writeText(input.value).then(() => {
                    msg.classList.remove('hidden');
                    setTimeout(() => msg.classList.add('hidden'), 2000);
                });
            } else {
                document.execCommand('copy');
                msg.classList.remove('hidden');
                setTimeout(() => msg.classList.add('hidden'), 2000);
            }
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('redirect-to-list', () => {
                setTimeout(() => {
                    window.location.href = '{{ route('products.products') }}'
                }, 3000)
            })
        })

        function pixTimer() {
            return {
                timeLeft: 300, // 5 minutos em segundos
                expired: false,
                start() {
                    const interval = setInterval(() => {
                        if (this.timeLeft > 0) {
                            this.timeLeft--;
                        } else {
                            this.expired = true;
                            clearInterval(interval);
                        }
                    }, 1000);
                },
                formatTime() {
                    const minutes = String(Math.floor(this.timeLeft / 60)).padStart(2, '0');
                    const seconds = String(this.timeLeft % 60).padStart(2, '0');
                    return `${minutes}:${seconds}`;
                }
            }
        }
    </script>
