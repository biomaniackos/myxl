@php
    $message = get_field('message', 'option') ?? "life isn’t about getting and having, it’s about giving and being";
@endphp
<div class="footer-menu grid grid-cols-12 gap-4">
    <div class="col-span-12 md:col-span-6 lg:col-span-2">
        <img src="@asset('images/logo.svg')" class="w-32" alt="logo myxl">
    </div>

    <div class="col-span-12 md:col-span-6 lg:col-span-4">
        <h3 class="max-w-xs">{{ $message }}</h3>
    </div>

    <div class="col-span-12 md:col-span-6 lg:col-span-2 lg:col-start-8">
        {{ wp_nav_menu([
            'theme_location' => 'footer_navigation',
            'menu_class' => 'menu-footer',
        ]) }}
    </div>

    <div class="col-span-12 md:col-span-6 lg:col-span-3">
        {{ wp_nav_menu([
            'theme_location' => 'footer_secondary_navigation',
            'menu_class' => 'menu-footer-secondary',
        ]) }}
    </div>
</div>