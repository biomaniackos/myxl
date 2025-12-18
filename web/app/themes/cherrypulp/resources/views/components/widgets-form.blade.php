@if ($item)
<section @if(isset($first) && $first) id="page" @endif class="widget-form">
<div class="container-wide grid grid-cols-12 gap-4">

    <div class="wrapper-content col-span-12 md:col-span-6 lg:col-span-5 pb-12">
        @if ($item['title'])
        <h2 class="h1">{!! $item['title'] !!}</h2>
        @endif

        @if ($item['text'])
        <p class="content">{!! $item['text'] !!}</p>
        @endif
    </div>

    <div class="wrapper-form col-span-12 md:col-span-6 lg:col-start-7">
        <span class="background"></span>

        <div class="form">
        @if ($item['form'])
        {{ gravity_form( $item['form'], false, false, false, '', false ) }}
        @endif
        </div>
    </div>

    <div class="elem-scene">
        {{-- cube(s) --}}
        <img src="@asset('images/elem-cube-2.png')" data-depth="0.2" class="elem_cube-01 absolute" alt="">
        {{-- dot(s) --}}
        <span class="elem_dot elem_dot-01 absolute bg-warning" data-depth="0.07"></span>
        <span class="elem_dot elem_dot-02 absolute bg-warning" data-depth="0.2"></span>
        <span class="elem_dot elem_dot-03 absolute bg-primary-400" data-depth="0.2"></span>
        <span class="elem_dot elem_dot-04 absolute bg-danger" data-depth="0.3"></span>
        {{-- triangle(s) --}}
        <img src="@asset('images/elem-triangle-2.png')" data-depth="0.2" class="elem_triangle-01 absolute" alt="">
        {{-- wave(s) --}}
        <img src="@asset('images/elem-wave-1.png')" data-depth="0.1" class="elem_wave-01 absolute" alt="">
    </div>
</div>
</section>
@endif