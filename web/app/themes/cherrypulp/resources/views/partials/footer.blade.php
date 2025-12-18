<footer class="app-footer" role="contentinfo">
    {{-- @php(dynamic_sidebar('sidebar-footer')) --}}

    @include('partials.footer-contact')

    <div class="container-wide pb-0 pt-20">

        @include('partials.footer-menu')

        {{-- <div class="">
            @include('partials.footer-accessibility')
            @include('partials.footer-identity')
        </div> --}}
        @include('partials.footer-copyright')
    </div>
</footer>
