<x-layouts.page>

    @section('title', 'Página Inicial - Minha Empresa')
    @section('meta_description', 'Serviços contábeis especializados para pequenas empresas.')
    @section('meta_keywords', 'contabilidade, empresa, impostos')
    @section('meta_image', asset('images/home-banner.jpg'))

    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:pb-16 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1
                    class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">
                    Sistema rápido de Pegue & Pague
                </h1>
                <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                    Deixe seus clientes comprarem sozinhos e pagarem via Pix em segundos. Simplifique vendas e aumente a
                    eficiência do seu negócio.
                </p>

                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    Painel de controle
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
                <a href="{{ route('products.products') }}" class="btn btn-active">
                    Lojas <x-svg.cart-plus class="w-5 h-5 ml-2 -mr-1"></x-svg.cart-plus>
                </a>
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                <x-app-logo-icon class="me-2 h-32 fill-current text-white" />
            </div>
        </div>
    </section>


</x-layouts.page>
