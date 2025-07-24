<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-lg text-center">
    @if (!$paid)
        <button class="btn btn-accent" wire:click='simulatePayment'>Simular pagamento</button>
        <h1 class="text-2xl font-bold mb-4">Pagamento via Pix</h1>
        <p class="text-gray-600 mb-6">Escaneie o QR Code abaixo com seu aplicativo bancário para concluir o pagamento.
        </p>

        {{-- <div class="flex justify-center mb-6">
            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode($pixQrCode) }}&size=200x200"
                alt="QR Code Pix" class="mx-auto border rounded-lg" />
        </div> --}}
        {{-- Código Copia e Cola com botão --}}
        <div class="flex flex-col items-center space-y-2">
            <textarea id="pixCode" class="w-full max-w-md p-2 border rounded" rows="3" readonly>{{ $pixQrCode }}</textarea>

            <button onclick="copyPixCode()" class="btn btn-outline btn-active">
                📋 Copiar código Pix
            </button>
        </div>
        {{-- Temporizador com Alpine.js --}}
        <div x-data="pixTimer()" x-init="start()" class="text-center mt-6">
            <p class="text-sm text-gray-500">Este código expira em:</p>
            <p class="text-3xl font-semibold text-red-500 mt-1" x-text="formatTime()"></p>

            <template x-if="expired">
                <p class="text-red-600 text-sm mt-4">Tempo expirado! Gere um novo QR Code.</p>
            </template>
        </div>
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
        function copyPixCode() {
            const textArea = document.getElementById('pixCode');
            navigator.clipboard.writeText(textArea.value)
                .then(() => alert('Código Pix copiado!'))
                .catch(err => alert('Erro ao copiar código Pix'));
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
