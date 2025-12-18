@php
    $header_no_bg = true;
    $main_background = true;
@endphp

@extends('layouts.app')

@section('content')
<div class="page-list background pt-14 pb-28">
<div class="container">

    <h2 class="mb-10">Recherche: {{ get_search_query() }}</h2>
    
    <div class="relative grid grid-cols-12 gap-6 z-10">
    @if (have_posts())
        @while(have_posts()) @php(the_post())
            <div class="col-span-12 sm:col-span-6 md:col-span-4">
                @include('components.card-news', ['item' => get_post()])
            </div>
        @endwhile
    @else
        <p class="col-span-12">Aucun posts n'a été trouvé</p>
    @endif
    </div>
    
    <div class="mx-auto mt-12 py-2">
    {!! the_posts_pagination([
        'prev_text' => __( "Précedent", 'textdomain' ),
        'next_text' => __( "Suivant", 'textdomain' ),
    ]) !!}
    </div>

</div>
<div class="elem-scene">
    {{-- cube(s) --}}
    <img src="@asset('images/elem-cube-3.png')" data-depth="0.5" class="elem_cube-01 absolute" alt="">
    {{-- dot(s) --}}
    <span class="elem_dot elem_dot-01 absolute bg-warning" data-depth="0.07"></span>
    <span class="elem_dot elem_dot-02 absolute bg-primary-400" data-depth="0.2"></span>
    <span class="elem_dot elem_dot-03 absolute bg-primary-400" data-depth="0.2"></span>
    <span class="elem_dot elem_dot-04 absolute bg-danger" data-depth="0.3"></span>
    {{-- triangle(s) --}}
    <img src="@asset('images/elem-triangle-2.png')" data-depth="0.2" class="elem_triangle-01 absolute" alt="">
</div>
</div>
@endsection