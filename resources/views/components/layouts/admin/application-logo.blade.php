<div>
    @props(['width' => 'h-24 sm:h-16'])
    @if (Storage::directoryMissing('public/logos-system'))
        <picture>
            <source srcset="{{ url('storage/logos/logo-system.png') }}" />
            <source srcset="{{ url('storage/logos/logo-system.webp') }}" />
            <img class="{{ $width }}" src="{{ url('storage/logos/logo-system.png') }}" alt="api-system">
        </picture>
    @else
        <picture class="{{ $width }}">
            <source srcset="{{ url('storage/logos-system/logo.png') }}" />
            <source srcset="{{ url('storage/logos-system/logo.webp') }}" />
            <img class="{{ $width }}" src="{{ url('storage/logos-system/logo.png') }}" alt="api-system">
        </picture>
    @endif
</div>
