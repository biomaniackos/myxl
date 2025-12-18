@if(isset($hero) && $hero['title'] || $hero['text'])
<section class="widget-hero @if($is_front) widget-hero-front @else wave wave-bottom wave-white @endif">
    <div class="container-wide items-start grid grid-cols-12 gap-4" style="z-index: 1;">
        @if($hero['title'] && $is_front)
        <div class="flex justify-start col-span-12 lg:col-span-4 lg:col-start-2 xl:col-start-1">
            <img class="logo lg:w-full" src="@asset('images/logo.svg')" alt="logo myxl">
        </div>
        @endif

        @if($hero['title'])
        <div class="wrapper-content col-span-12 flex flex-col max-w-xl lg:max-w-none
                    @if($is_front) lg:col-span-6 lg:col-start-6 xl:col-span-6 xl:col-start-7
                    @else lg:col-span-6 lg:col-start-4 text-center mx-auto
                    @endif">
            @if($hero['title'])
            <h2 class="h1">{!! $hero['title'] !!}</h2>
            @endif
            @if($hero['text'])
            <p>{{ $hero['text'] }}</p>
            @endif
            @if((isset($hero['button']) && isset($hero['button']['url'])) || (isset($hero['video']) && isset($hero['video']['url'])))
            <div class="flex flex-col lg:flex-row mt-5">
                @if(($hero['button'] && $hero['button']['url']))
                <a class="btn btn-basic btn-primary w-max" href="{{ $hero['button']['url'] }}" target="{{ $hero['button']['target'] }}">{{ $hero['button']['title'] ? $hero['button']['title'] : 'clique myxl' }}</a>
                @endif
                @if(($hero['video'] && $hero['video']['url']))
                <a class="btn-video btn-warning w-max mt-8 lg:mt-0 ml-0 lg:ml-6" href="{{ $hero['video']['url'] }}" target="{{ $hero['video']['target'] }}">
                    <span class="play"><img src="@asset('images/play.svg')" alt=""></span>
                    {{ $hero['video']['title'] ? $hero['video']['title'] : 'video' }}
                </a>
                @endif
            </div>
            @endif
        </div>
        @endif
        
        @if ($is_front)
        <div class="mt-14 col-span-12 w-full pb-20">
            <a class="btn min-w-0 bg-primary-100 rounded-full p-0 w-20 h-20 flex justify-center items-center" href="#page">
                <span class="sr-only">scroll</span>
                <img class="object-contain block w-8 h-8" src="@asset('images/down.png')" alt="">
            </a>
        </div>
        @endif
    </div>

    @if ($is_front)
    <div class="elem-scene">
        {{-- cube(s) --}}
        <img src="@asset('images/elem-cube-2.png')" data-depth="0.2" class="elem_cube-01 absolute" alt="">
        <img src="@asset('images/elem-cube-3.png')" data-depth="0.5" class="elem_cube-02 absolute" alt="">
        {{-- dot(s) --}}
        <span class="elem_dot elem_dot-01 absolute bg-warning" data-depth="0.07"></span>
        <span class="elem_dot elem_dot-02 absolute bg-warning" data-depth="0.2"></span>
        <span class="elem_dot elem_dot-03 absolute bg-primary-400" data-depth="0.2"></span>
        <span class="elem_dot elem_dot-04 absolute bg-primary-400" data-depth="0.2"></span>
        <span class="elem_dot elem_dot-05 absolute bg-danger" data-depth="0.3"></span>
        {{-- line(s) --}}
        <img src="@asset('images/elem-line-1.png')" data-depth="0.7" class="elem_line-01 absolute" alt="">
        {{-- triangle(s) --}}
        <img src="@asset('images/elem-triangle-2.png')" data-depth="0.2" class="elem_triangle-01 absolute" alt="">
        {{-- wave(s) --}}
        <img src="@asset('images/elem-wave-1.png')" data-depth="0.1" class="elem_wave-01 absolute" alt="">
    </div>
    @else
    <div class="elem-scene elem-scene-widget">
        {{-- cube(s) --}}
        <img src="@asset('images/elem-cube-2.png')" data-depth="0.2" class="elem_cube-01 absolute" alt="">
        <img src="@asset('images/elem-cube-3.png')" data-depth="0.1" class="elem_cube-02 absolute" alt="">
        {{-- dot(s) --}}
        <span class="elem_dot elem_dot-01 absolute bg-danger" data-depth="0.3"></span>
        <span class="elem_dot elem_dot-02 absolute bg-warning" data-depth="0.07"></span>
        <span class="elem_dot elem_dot-03 absolute bg-warning" data-depth="0.2"></span>
        <span class="elem_dot elem_dot-04 elem_dot-big absolute bg-warning" data-depth="0.3"></span>
        <span class="elem_dot elem_dot-05 absolute bg-primary-400" data-depth="0.2"></span>
        <span class="elem_dot elem_dot-06 absolute" style="background-color:#C153A4;" data-depth="0.5"></span>
        {{-- line(s) --}}
        <img src="@asset('images/elem-line-2.png')" data-depth="0.7" class="elem_line-01 absolute" alt="">
        <img src="@asset('images/elem-line-1.png')" data-depth="0.4" class="elem_line-02 absolute" alt="">
        {{-- triangle(s) --}}
        <img src="@asset('images/elem-triangle-1.png')" data-depth="0.2" class="elem_triangle-01 absolute" alt="">
        <img src="@asset('images/elem-triangle-2.png')" data-depth="0.3" class="elem_triangle-02 absolute" alt="">
        {{-- wave(s) --}}
        <img src="@asset('images/elem-wave-1.png')" data-depth="0.1" class="elem_wave-01 absolute" alt="">
    </div>
    @endif
</section>
@endif