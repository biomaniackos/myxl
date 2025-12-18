@if ($identity)
    <div class="footer-identity">
        @if ($identity['logo'])
            @php
                $image = App\get_image($identity['logo']);
            @endphp
            <img class="h-10" src="{{ $image['url'] }}" alt="{{ $image['alt'] ?? $siteName }}">
        @endif
        <div class="text-gray-300 text-base">
            {!! $identity['description'] !!}
        </div>
    </div><!-- /.footer-identity -->
@endif
