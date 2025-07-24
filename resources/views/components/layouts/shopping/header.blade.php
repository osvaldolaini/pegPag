<div id="main-header" class="bg-white/80 shadow transition duration-300">
    <div class="container mx-auto flex items-center justify-between px-4 py-8">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="text-xl font-bold text-indigo-600">
            {{ $settings->title ?? 'Minha Empresa' }}
        </a>

        {{-- Menu Desktop --}}
        <nav class="hidden md:flex space-x-6">
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600">Início</a>
            <a href="{{ url('/sobre') }}" class="text-gray-700 hover:text-indigo-600">Sobre</a>
            <a href="{{ url('/contato') }}" class="text-gray-700 hover:text-indigo-600">Contato</a>
        </nav>

        {{-- Botão menu mobile --}}
        @if (Request::is('produtos'))
            <div class="md:hidden">
                <a href="{{ url('/carrinho') }}" class="flex btn btn-soft btn-success">
                    <x-svg.basket-plus class="size-[1.8em]"></x-svg.basket-plus>
                    Ir para o carrinho
                </a>
            </div>
        @else
            <div class="md:hidden">
                <a href="{{ url('/produtos') }}" class="flex btn btn-soft btn-active">
                    <x-svg.back class="size-[1.8em]"></x-svg.back>
                    Voltar
                </a>
            </div>
        @endif

    </div>

</div>
