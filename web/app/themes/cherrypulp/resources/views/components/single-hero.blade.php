@php
    $color = $color ?? '#3097F2';
    $fullscene = $fullscene ?? false;
@endphp
<section class="hero-single">
    <div class="wrapper-content">
        @if (isset($back) && $back['url'])
        <a href="{{ $back['url'] }}" class="back">{{ $back['title'] }}</a>
        @endif
        
        <div class="relative w-full max-w-xs">
            @if (isset($title) && ($title['primary'] || $title['secondary']))
                <h2>
                    {{ $title['primary'] }}

                    @isset($title['secondary'])
                    <br>
                    <strong style="--data-color:{{ $color }};">{{ $title['secondary'] }}</strong>
                    @endisset
                </h2>
            @endif
        </div>
    </div>

    <div class="wrapper-image">
        @if (isset($image) && $image)
            <img src="{{ $image }}" alt="">
        @else
            <img src="@asset('images/thumbnail.png')" alt="">
        @endif

        @if (isset($icon) && isset($icon['url']))
            <span class="icon" style="--data-color:{{ $color }};">
                <img src="{{ $icon['url'] }}" alt="">
            </span>
        @endif
    </div>

    <div class="elem-scene">
        {{-- cube(s) --}}
        <img src="@asset('images/elem-cube-3.png')" data-depth="0.5" class="elem_cube-01 absolute" alt="">
        {{-- dot(s) --}}
        <span class="elem_dot elem_dot-01 absolute bg-warning" data-depth="0.07"></span>
        <span class="elem_dot elem_dot-02 absolute bg-primary-400" data-depth="0.2"></span>
        @if ($fullscene)
        {{-- triangle(s) --}}
        <img src="@asset('images/elem-triangle-2.png')" data-depth="0.2" class="elem_triangle-01 absolute" alt="">
        {{-- wave(s) --}}
        <img src="@asset('images/elem-wave-1.png')" data-depth="0.1" class="elem_wave-01 absolute" alt="">
        @endif
    </div>
</section>