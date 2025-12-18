@php
    $copyright = get_field('copyright', 'option');
@endphp
<div class="footer-copyright grid grid-cols-12 gap-4">
    {{-- @include('partials.menu-social') --}}

    <small class="col-span-12 md:col-span-6">
        Made with <span>love</span> by <a href="https://www.cherrypulp.com" target="_blank" rel="external">Cherry Pulp</a>
    </small>

    @if ($copyright)
    <small class="col-span-12 md:col-span-6 md:text-right">{{ $copyright }}</small>
    @endif
</div><!-- /.footer-copyright -->
