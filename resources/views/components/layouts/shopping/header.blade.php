<div id="main-header" class="bg-white shadow transition duration-300">
    <div class="container mx-auto flex items-center justify-between px-4 py-8">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="text-xl font-bold text-indigo-600">
            {{ $settings->title ?? 'Minha Empresa' }}
        </a>

        {{-- Botão menu mobile --}}
        @if (Request::is('produtos'))
            <div>
                <a href="{{ url('/carrinho') }}" class="flex btn btn-soft btn-success">
                    {{-- <x-svg.cart-empty class="size-[1.8em]"></x-svg.cart-empty> --}}
                    <x-svg.basket-empty class="size-[1.8em]"></x-svg.basket-empty>
                    carrinho
                    @livewire('page.count-cart')
                </a>
            </div>
        @else
            @if (!Request::is('pagar*'))
                <div>
                    <a href="{{ url('/produtos') }}" class="flex btn btn-soft btn-active">
                        <x-svg.back class="size-[1.8em]"></x-svg.back>
                        Voltar à loja
                    </a>
                </div>
            @endif

        @endif
    </div>


</div>
