@if ($social_networks)
    <div class="menu-social">
        @foreach ($social_networks as $network)
            <a href="{{ $network['link'] }}" target="_blank" class="text-gray-400 hover:text-gray-300">
                <span class="sr-only">{{ $network['title'] }}</span>
                <i class="fab fa-{{ $network['network'] }}"></i>
            </a>
        @endforeach
    </div>
@endif
