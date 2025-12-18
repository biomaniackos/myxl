@php
    $main_background = $main_background ?? false;
@endphp

<a class="sr-only focus:not-sr-only" href="#main">
    {{ __('Skip to content') }}
</a>

@include('partials.header')

<main class="app-body @if ($main_background) background @endif">
    @yield('content')
</main>

@hasSection('sidebar')
    <aside class="sidebar">
        @yield('sidebar')
    </aside>
@endif

@include('partials.footer')
