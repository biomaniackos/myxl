@php
    $identity_option = get_field('identity', 'option');
    $logo_id = $identity_option['logo'] ?? null;
    $logo = null;
    if ($logo_id) {
        $logo = wp_get_attachment_image_src($logo_id, 'thumbnail', false);
    }
    $header_no_bg = $header_no_bg ?? false;
    $main_background = $main_background ?? false;
    
    if (isset($hero)) {
        if ($hero['title'] || $hero['text']) {
            $main_background = false;
        }
    }
@endphp
<header id="app-header" class="app-header @if ($header_no_bg) no-shadow @endif @if ($main_background) background @endif" role="banner">
    {{-- @include('partials.header-banner') --}}
    {{-- @include('partials.header-navigation') --}}

    <div class="flex justify-between items-center">
        <div class="logo">
            <a href="{{ get_home_url() }}">
                <span class="sr-only">accueil</span>
                @if ($logo)
                    <img src="{{ $logo[0] }}" alt="Myxl logo">
                @else
                <img src="@asset('images/logo.svg')" alt="Myxl logo">
                @endif
            </a>
        </div>

        <div id="menu-header-wrapper" class="menu-header-wrapper flex flex-col md:flex-row md:justify-between md:items-center">
            {{ wp_nav_menu([
                'theme_location' => 'primary_navigation',
                'menu_class' => 'menu-header',
            ]) }}
            <button id="toggle-search" class="toggle-search md:ml-10">
                <img src="@asset('images/search.svg')" alt="">
                <span class="md:sr-only">recherche</span>
            </button>
        </div>

        <button id="toggle-menu" class="toggle-menu">
            <span class="sr-only">menu</span>
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </button>
    </div>

    <div id="search-form" class="search-form">
        <button id="close-search-form">
            <span class="sr-only">fermer la recherche</span>
            <img src="@asset('images/close.svg')" alt="">
        </button>
        <form id="searchform" method="get" action="{{ home_url('/') }}">
            <input type="text" class="search-field" name="s" placeholder="Recherche" value="{{ get_search_query() }}">
            <div class="send">
                <input type="submit" value="Search">
                <img src="@asset('images/search.svg')" alt="">
            </div>
        </form>
    </div>

</header>