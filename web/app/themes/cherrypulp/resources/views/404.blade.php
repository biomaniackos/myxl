@php
    $header_no_bg = true;
@endphp

@extends('layouts.app')

@php
    $title = get_field('404_title', 'option') ?? "Nous n’avons pas trouvé cette page";
    $text = get_field('404_text', 'option') ?? "Oups";
    $image = get_field('404_image', 'option') ?? null;
    $button = get_field('404_button', 'option') ?? [
        'title' => 'retour sur la page d’accueil',
        'url' => get_home_url(),
        'target' => null,
    ];
@endphp

@section('content')
<section class="page-404 py-12 pb-32 pt-32">

    <div class="container-wide">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 md:col-span-6 lg:col-span-5 mb-9 md:mb-0 flex flex-col justify-center">
                <strong>errur 404</strong>
                <h2 class="mt-6">{!! $title !!}</h2>
                <p class="mt-6">{{ $text }}</p>
                <a href="{{ $button['url'] }}" class="inline-block w-max btn btn-basic btn-primary mt-6" target="{{ $button['target'] }}">{{ $button['title'] }}</a>
            </div>

            <div class="col-span-12 sm:col-span-10 sm:col-start-2 md:col-span-6 md:col-start-7 flex flex-col justify-center">
                @if ($image)
                <img src="{{ $image['url'] }}" alt="erreur 404">
                @else
                <img src="@asset('images/404.png')" alt="erreur 404">
                @endif
            </div>
        </div>
    </div>

    <div class="elem-scene">
        {{-- cube(s) --}}
        <img src="@asset('images/elem-cube-2.png')" data-depth="0.5" class="elem_cube-01 absolute" alt="">
        {{-- dot(s) --}}
        <span class="elem_dot elem_dot-01 absolute bg-warning" data-depth="0.07"></span>
        <span class="elem_dot elem_dot-02 absolute bg-warning" data-depth="0.04"></span>
        <span class="elem_dot elem_dot-03 absolute bg-danger" data-depth="0.5"></span>
        <span class="elem_dot elem_dot-04 absolute bg-primary-400" data-depth="0.2"></span>
        {{-- triangle(s) --}}
        <img src="@asset('images/elem-triangle-2.png')" data-depth="0.2" class="elem_triangle-01 absolute" alt="">
        {{-- wave(s) --}}
        <img src="@asset('images/elem-wave-1.png')" data-depth="0.1" class="elem_wave-01 absolute" alt="">
    </div>

</section>
@endsection
