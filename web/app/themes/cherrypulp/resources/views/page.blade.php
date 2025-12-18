@php
    $header_no_bg = true;
@endphp

@extends('layouts.app')

@section('content')
    <div class="page-content container-wide">
        @while(have_posts()) @php(the_post())
        @include('partials.page-header')
        @includeFirst(['partials.content-page', 'partials.content'])
        @endwhile
    </div>
@endsection
